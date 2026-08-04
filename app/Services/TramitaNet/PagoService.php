<?php

namespace App\Services\TramitaNet;

use App\Models\CatalogoCuentaBancaria;
use App\Models\SolicitudServicio;
use App\Models\SolicitudServicioPago;
use App\Support\TramitaNet\EstadosSolicitud;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class PagoService
{
    /**
     * Crea el registro inicial de pago de una solicitud.
     */
    public static function crearPagoInicial(
        SolicitudServicio $solicitud
    ): SolicitudServicioPago {
        return DB::transaction(function () use ($solicitud) {

            /*
             * Evita duplicar un pago activo si el método
             * se ejecuta accidentalmente más de una vez.
             */
            $pagoExistente = $solicitud->pagos()
                ->whereIn('estatus', [
                    'pendiente',
                    'esperando_comprobante',
                    'comprobante_recibido',
                    'en_revision',
                ])
                ->latest()
                ->first();

            if ($pagoExistente) {
                return $pagoExistente;
            }

            $cuenta = CatalogoCuentaBancaria::query()
                ->activas()
                ->principal()
                ->first();

            if (!$cuenta) {
                throw new RuntimeException(
                    'No existe una cuenta bancaria principal activa para recibir el pago.'
                );
            }

            return $solicitud->pagos()->create([
                'catalogo_cuenta_bancaria_id' => $cuenta->id,

                'estatus' => 'esperando_comprobante',

                /*
                 * Snapshot de los datos bancarios.
                 */
                'banco' => $cuenta->banco,
                'titular' => $cuenta->titular,
                'numero_cuenta' => $cuenta->numero_cuenta,
                'clabe_interbancaria' => $cuenta->clabe_interbancaria,

                /*
                 * Por ahora reutilizamos estos campos para guardar
                 * el monto y la referencia esperados.
                 */
                'monto_reportado' => $solicitud->total_pagar,
                'referencia_reportada' => $solicitud->referencia_pago,
            ]);
        });
    }

    /**
     * Registra el comprobante enviado por el ciudadano.
     */
    public static function registrarComprobante(
        SolicitudServicio $solicitud,
        UploadedFile $archivo,
        array $datos = []
    ): SolicitudServicioPago {
        $ruta = null;

        try {
            $ruta = $archivo->store(
                "tramitanet/pagos/{$solicitud->folio}",
                'public'
            );

            return DB::transaction(function () use (
                $solicitud,
                $archivo,
                $datos,
                $ruta
            ) {
                /*
                 * Buscamos el pago que está esperando comprobante.
                 */
                $pago = $solicitud->pagos()
                    ->whereIn('estatus', [
                        'pendiente',
                        'esperando_comprobante',
                    ])
                    ->latest()
                    ->lockForUpdate()
                    ->first();

                /*
                 * Si el pago anterior fue rechazado o no existe,
                 * generamos un nuevo intento.
                 */
                if (!$pago) {
                    $pago = self::crearPagoInicial($solicitud);
                }

                /*
                 * Si por alguna razón ya tenía otro archivo,
                 * eliminamos el anterior antes de sustituirlo.
                 */
                if (
                    $pago->ruta_archivo &&
                    $pago->ruta_archivo !== $ruta &&
                    Storage::disk('public')->exists($pago->ruta_archivo)
                ) {
                    Storage::disk('public')->delete($pago->ruta_archivo);
                }

                $pago->update([
                    'estatus' => 'en_revision',

                    'ruta_archivo' => $ruta,
                    'nombre_original_archivo' =>
                        $archivo->getClientOriginalName(),

                    'mime_type' => $archivo->getMimeType(),
                    'tamano_archivo' => $archivo->getSize(),

                    /*
                     * Si el ciudadano no captura estos datos,
                     * conservamos los asignados inicialmente.
                     */
                    'monto_reportado' =>
                        filled($datos['monto_reportado'] ?? null)
                            ? $datos['monto_reportado']
                            : $pago->monto_reportado,

                    'referencia_reportada' =>
                        filled($datos['referencia_reportada'] ?? null)
                            ? $datos['referencia_reportada']
                            : $pago->referencia_reportada,
             

                    /*
                     * Limpiamos datos de una posible revisión anterior.
                     */
                    'observacion' => null,
                    'fecha_validacion' => null,
                    'user_id' => null,
                ]);

                CambioEstadoService::ejecutar(
                    solicitud: $solicitud,
                    nuevoEstado: EstadosSolicitud::PAGO_EN_REVISION,
                    observacion:
                        'El ciudadano envió un comprobante de pago.',
                    userId: null,
                    tipoNota: 'pago'
                );

                return $pago->fresh();
            });
        } catch (Throwable $e) {
            /*
             * El almacenamiento de archivos no participa en la
             * transacción SQL. Si falla la base de datos, eliminamos
             * el archivo para no dejar archivos huérfanos.
             */
            if (
                $ruta &&
                Storage::disk('public')->exists($ruta)
            ) {
                Storage::disk('public')->delete($ruta);
            }

            throw $e;
        }
    }

    /**
     * Confirma el pago después de la revisión administrativa.
     */
    public static function validarPago(
        SolicitudServicioPago $pago,
        ?string $observacion = null
    ): void {
        DB::transaction(function () use ($pago, $observacion) {
            $pago->loadMissing('solicitud');

            if (!$pago->solicitud) {
                throw new RuntimeException(
                    'El comprobante no está asociado a una solicitud válida.'
                );
            }

            if (!$pago->ruta_archivo) {
                throw new RuntimeException(
                    'No se puede validar un pago sin comprobante.'
                );
            }

            if ($pago->estatus === 'validado') {
                throw new RuntimeException(
                    'Este pago ya fue validado anteriormente.'
                );
            }

            $pago->update([
                'estatus' => 'validado',
                'observacion' => $observacion,
                'fecha_validacion' => now(),
                'user_id' => auth()->id(),
            ]);

            CambioEstadoService::ejecutar(
                solicitud: $pago->solicitud,
                nuevoEstado: EstadosSolicitud::PAGO_CONFIRMADO,
                observacion:
                    $observacion ?? 'Pago validado correctamente.',
                userId: auth()->id(),
                tipoNota: 'pago'
            );
        });
    }

    /**
     * Rechaza el comprobante y permite que se genere un nuevo intento.
     */
    public static function rechazarPago(
        SolicitudServicioPago $pago,
        string $observacion
    ): void {
        DB::transaction(function () use ($pago, $observacion) {
            $pago->loadMissing('solicitud');

            if (!$pago->solicitud) {
                throw new RuntimeException(
                    'El comprobante no está asociado a una solicitud válida.'
                );
            }

            if (!$pago->ruta_archivo) {
                throw new RuntimeException(
                    'No se puede rechazar un pago sin comprobante.'
                );
            }

            if ($pago->estatus === 'validado') {
                throw new RuntimeException(
                    'No se puede rechazar un pago que ya fue validado.'
                );
            }

            $pago->update([
                'estatus' => 'rechazado',
                'observacion' => $observacion,
                'fecha_validacion' => now(),
                'user_id' => auth()->id(),
            ]);

            CambioEstadoService::ejecutar(
                solicitud: $pago->solicitud,
                nuevoEstado: EstadosSolicitud::ESPERANDO_PAGO,
                observacion:
                    'Comprobante de pago rechazado: ' . $observacion,
                userId: auth()->id(),
                tipoNota: 'pago',
                eventoNotificacion: 'pago_rechazado'
            );
        });
    }
}
