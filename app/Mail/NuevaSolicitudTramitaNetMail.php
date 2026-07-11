<?php

namespace App\Mail;

use App\Models\SolicitudServicio;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevaSolicitudTramitaNetMail extends Mailable
{
    use Queueable, SerializesModels;

    public SolicitudServicio $solicitud;

    public function __construct(SolicitudServicio $solicitud)
    {
        $this->solicitud = $solicitud->load([
            'servicio.institucion',
            'modalidad',
            'datos',
        ]);
    }

    public function build()
    {
        return $this
            ->subject("Nueva solicitud TramitaNet - {$this->solicitud->folio}")
            ->markdown('emails.tramitanet.nueva-solicitud');
    }
}
