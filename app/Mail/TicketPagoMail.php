<?php

namespace App\Mail;

use App\Models\Pago;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketPagoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pago $pago) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recibo de Pago — Entretenimiento Berumen',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.ticket-pago',
            with: ['pago' => $this->pago],
        );
    }
}
