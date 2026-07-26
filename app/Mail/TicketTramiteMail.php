<?php

namespace App\Mail;

use App\Models\Tramite;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketTramiteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Tramite $tramite) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Recibo de Trámite — Entretenimiento Berumen');
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-tramite',
            with: ['tramite' => $this->tramite],
        );
    }
}