<?php

namespace App\Mail;

use App\Models\PagoServicio;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketPagoServicioMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PagoServicio $pago) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Recibo de Pago de Servicio — Entretenimiento Berumen');
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.ticket-pago-servicio',
            with: ['pago' => $this->pago],
        );
    }
}
