<?php

namespace App\Services;

use App\Mail\NuevaSolicitudTramitaNetMail;
use App\Mail\SolicitudRecibidaClienteMail;
use App\Models\SolicitudServicio;
use Illuminate\Support\Facades\Mail;
use App\Mail\EstadoSolicitudActualizadoMail;

class TramitaNetNotificacionService
{
    public static function nuevaSolicitud(SolicitudServicio $solicitud): void
    {
        $solicitud->loadMissing([
            'servicio',
            'modalidad',
        ]);

        self::notificarAdministradores($solicitud);
        self::notificarCliente($solicitud);
    }

    private static function notificarAdministradores(
        SolicitudServicio $solicitud
    ): void {
        $correos = collect([
            config('services.tramitanet.correo_admin_1'),
            config('services.tramitanet.correo_admin_2'),
        ])
            ->filter()
            ->unique();

        foreach ($correos as $correo) {
            Mail::to($correo)
                ->send(new NuevaSolicitudTramitaNetMail($solicitud));
        }
    }

    private static function notificarCliente(
            SolicitudServicio $solicitud
        ): void {
            if (blank($solicitud->correo)) {
                return;
            }

            Mail::to($solicitud->correo)
                ->send(new SolicitudRecibidaClienteMail($solicitud));
        }

    public static function cambioEstatus(SolicitudServicio $solicitud): void
    {
        if (blank($solicitud->correo)) {
            return;
        }

        $solicitud->loadMissing([
            'servicio',
            'modalidad',
        ]);

        Mail::to($solicitud->correo)
            ->send(new EstadoSolicitudActualizadoMail($solicitud));
    }
}
