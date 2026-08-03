<?php

namespace App\Services\TramitaNet;

use App\Models\SolicitudServicio;
use App\Models\HistorialEstatusSolicitud;
use App\Models\SolicitudServicioNota;
use App\Support\TramitaNet\EstadosSolicitud;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use App\Services\TramitaNetNotificacionService;

class CambioEstadoService
{
    public static function ejecutar(
        SolicitudServicio $solicitud,
        string $nuevoEstado,
        ?string $observacion = null,
        ?int $userId = null,
        string $tipoNota = 'estatus',
        bool $notificarCliente = true,
        ?string $eventoNotificacion = null
    ): void {

        DB::transaction(function () use (
            $solicitud,
            $nuevoEstado,
            $observacion,
            $userId,
            $tipoNota,
            $notificarCliente,
            $eventoNotificacion
        ) {

            $estadoAnterior = $solicitud->estatus;

            if ($estadoAnterior === $nuevoEstado) {
                return;
            }

            if (!EstadosSolicitud::puedeCambiarDe($estadoAnterior, $nuevoEstado)) {
                throw new InvalidArgumentException(
                    "No es posible cambiar de {$estadoAnterior} a {$nuevoEstado}."
                );
            }

            $solicitud->update([
                'estatus' => $nuevoEstado,
            ]);

            HistorialEstatusSolicitud::create([
                'solicitud_servicio_id' => $solicitud->id,
                'estatus_anterior'      => $estadoAnterior,
                'estatus_nuevo'         => $nuevoEstado,
                'observacion'           => $observacion,
                'user_id'               => $userId,
            ]);

            SolicitudServicioNota::create([
                'solicitud_servicio_id' => $solicitud->id,
                'user_id'               => $userId,
                'tipo'                  => $tipoNota,
                'nota'                  => $observacion
                    ?? "Cambio de estado a {$nuevoEstado}.",
                'visible_cliente'       => false,
            ]);

            if ($notificarCliente) {
                DB::afterCommit(function () use (
                    $solicitud,
                    $eventoNotificacion
                ) {
                    TramitaNetNotificacionService::cambioEstatus(
                        $solicitud->fresh([
                            'servicio',
                            'modalidad',
                        ]),
                        $eventoNotificacion
                    );
                });
            }
        });
    }
}
