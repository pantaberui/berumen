<?php

namespace App\Mail;

use App\Models\SolicitudServicio;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TramitaNetSolicitudRegistradaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SolicitudServicio $solicitud
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitud recibida | TramitaNet',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.tramitanet.solicitud-registrada',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
