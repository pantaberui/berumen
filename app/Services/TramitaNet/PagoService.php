<?php

namespace App\Services\TramitaNet;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\SolicitudServicio;
use App\Models\SolicitudServicioPago;
use App\Models\SolicitudServicioNota;
use App\Models\HistorialEstatusSolicitud;
use Illuminate\Http\UploadedFile;
use App\Services\TramitaNet\CambioEstadoService;
use App\Support\TramitaNet\EstadosSolicitud;

class PagoService
{
    public static function registrarComprobante(
        SolicitudServicio $solicitud,
        UploadedFile $archivo,
        array $datos = []
    ): SolicitudServicioPago
    {
        return DB::transaction(function () use ($solicitud, $archivo, $datos) {

            $ruta = $archivo->store(
                "tramitanet/pagos/{$solicitud->folio}",
                'public'
            );

            $pago = SolicitudServicioPago::create([
                'solicitud_servicio_id' => $solicitud->id,
                'estatus'              => 'pendiente',
                'ruta_archivo'         => $ruta,
                'nombre_original_archivo' => $archivo->getClientOriginalName(),
                'mime_type'            => $archivo->getMimeType(),
                'tamano_archivo'       => $archivo->getSize(),
                'monto_reportado'      => $datos['monto_reportado'] ?? null,
                'referencia_reportada' => $datos['referencia_reportada'] ?? null,
            ]);

            // Cambiar estado
            CambioEstadoService::ejecutar(
                solicitud: $solicitud,
                nuevoEstado: EstadosSolicitud::PAGO_EN_REVISION,
                observacion: 'El ciudadano envió un comprobante de pago.',
                userId: null,
                tipoNota: 'pago'
            );

            return $pago;
        });
    }

    public static function validarPago(
        SolicitudServicioPago $pago,
        ?string $observacion = null
    ): void {
        DB::transaction(function () use ($pago, $observacion) {

            $pago->loadMissing('solicitud');

            if (!$pago->solicitud) {
                throw new \RuntimeException(
                    'El comprobante no está asociado a una solicitud válida.'
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
                observacion: $observacion ?? 'Pago validado correctamente.',
                userId: auth()->id(),
                tipoNota: 'pago'
            );
        });
    }

    public static function rechazarPago(
        SolicitudServicioPago $pago,
        string $observacion
    ): void {

        $pago->loadMissing('solicitud');

        if (!$pago->solicitud) {
            throw new \RuntimeException(
                'El comprobante no está asociado a una solicitud válida.'
            );
        }
        
        DB::transaction(function () use ($pago, $observacion) {
            $pago->update([
                'estatus' => 'rechazado',
                'observacion' => $observacion,
                'fecha_validacion' => now(),
                'user_id' => auth()->id(),
            ]);

            CambioEstadoService::ejecutar(
                solicitud: $pago->solicitud,
                nuevoEstado: EstadosSolicitud::ESPERANDO_PAGO,
                observacion: 'Comprobante de pago rechazado: ' . $observacion,
                userId: auth()->id(),
                tipoNota: 'pago'
            );
        });
    }


}
