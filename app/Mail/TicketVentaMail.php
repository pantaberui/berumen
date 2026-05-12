<?php

namespace App\Mail;

use App\Models\Venta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketVentaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Venta $venta) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Ticket de Venta — Entretenimiento Berumen');
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.ticket-venta',
            with: ['venta' => $this->venta],
        );
    }
}
