<?php

namespace App\Services\Pagos;

use App\Models\CatalogoCuentaBancaria;
use App\Models\SolicitudServicio;
use App\Models\SolicitudServicioPago;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class RegistrarPagoService
{
    public function crear(
        SolicitudServicio $solicitud
    ): SolicitudServicioPago {
        return DB::transaction(function () use ($solicitud) {
            /*
             * Evitamos crear un segundo pago pendiente accidentalmente
             * para la misma solicitud.
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
                    'No existe una cuenta bancaria principal activa.'
                );
            }

            return $solicitud->pagos()->create([
                'catalogo_cuenta_bancaria_id' => $cuenta->id,

                'estatus' => 'esperando_comprobante',

                /*
                 * Snapshot bancario.
                 */
                'banco' => $cuenta->banco,
                'titular' => $cuenta->titular,
                'numero_cuenta' => $cuenta->numero_cuenta,
                'clabe_interbancaria' => $cuenta->clabe_interbancaria,

                /*
                 * Datos esperados del pago.
                 */
                'monto_reportado' => $solicitud->total_pagar,
                'referencia_reportada' => $solicitud->referencia_pago,
            ]);
        });
    }
}