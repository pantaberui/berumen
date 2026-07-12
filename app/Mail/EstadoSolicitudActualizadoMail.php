<?php

namespace App\Mail;

use App\Models\SolicitudServicio;
use App\Support\TramitaNet\EstadosSolicitud;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EstadoSolicitudActualizadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SolicitudServicio $solicitud
    ) {
    }

    public function envelope(): Envelope
    {
        $estado = EstadosSolicitud::labels()[$this->solicitud->estatus]
            ?? strtoupper(str_replace('_', ' ', $this->solicitud->estatus));

        return new Envelope(
            subject: "TramitaNet | {$estado} | Folio {$this->solicitud->folio}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.tramitanet.estado-solicitud-actualizado',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
