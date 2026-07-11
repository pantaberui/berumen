<?php

namespace App\Mail;

use App\Models\SolicitudServicio;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SolicitudRecibidaClienteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SolicitudServicio $solicitud
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recibimos tu solicitud | TramitaNet',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.tramitanet.solicitud-recibida-cliente',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
