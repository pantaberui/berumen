<?php

namespace App\Services;

use App\Mail\NuevaSolicitudTramitaNetMail;
use App\Models\SolicitudServicio;
use Illuminate\Support\Facades\Mail;

class TramitaNetNotificacionService
{
    public static function nuevaSolicitud(SolicitudServicio $solicitud): void
    {
        $correos = collect([
            config('services.tramitanet.correo_admin_1'),
            config('services.tramitanet.correo_admin_2'),
        ])
            ->filter()
            ->unique();

        foreach ($correos as $correo) {
            Mail::to($correo)->send(new NuevaSolicitudTramitaNetMail($solicitud));
        }
    }
}
