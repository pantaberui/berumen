<?php

namespace App\Services\TramitaNet;

use App\Models\SolicitudServicio;
use App\Models\HistorialEstatusSolicitud;
use App\Models\SolicitudServicioNota;
use App\Support\TramitaNet\EstadosSolicitud;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class CambioEstadoService
{
    public static function ejecutar(
        SolicitudServicio $solicitud,
        string $nuevoEstado,
        ?string $observacion = null,
        ?int $userId = null,
        string $tipoNota = 'estatus'
    ): void {

        DB::transaction(function () use (
            $solicitud,
            $nuevoEstado,
            $observacion,
            $userId,
            $tipoNota
        ) {

            $estadoAnterior = $solicitud->estatus;

            // Si no cambió, no hacer nada
            if ($estadoAnterior === $nuevoEstado) {
                return;
            }

            // Validar transición
            if (!EstadosSolicitud::puedeCambiarDe($estadoAnterior, $nuevoEstado)) {
                throw new InvalidArgumentException(
                    "No es posible cambiar de {$estadoAnterior} a {$nuevoEstado}."
                );
            }

            // Actualizar solicitud
            $solicitud->update([
                'estatus' => $nuevoEstado,
            ]);

            // Historial
            HistorialEstatusSolicitud::create([
                'solicitud_servicio_id' => $solicitud->id,
                'estatus_anterior'      => $estadoAnterior,
                'estatus_nuevo'         => $nuevoEstado,
                'observacion'           => $observacion,
                'user_id'               => $userId,
            ]);

            // Nota
            SolicitudServicioNota::create([
                'solicitud_servicio_id' => $solicitud->id,
                'user_id'               => $userId,
                'tipo'                  => $tipoNota,
                'nota'                  => $observacion
                    ?? "Cambio de estado a {$nuevoEstado}.",
                'visible_cliente'       => false,
            ]);

        });

    }
}
