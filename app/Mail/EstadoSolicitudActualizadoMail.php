<?php

namespace App\Mail;

use App\Models\SolicitudServicio;
use App\Support\TramitaNet\EstadosSolicitud;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Services\TramitaNet\NotificacionEstadoService;

class EstadoSolicitudActualizadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SolicitudServicio $solicitud,
        public ?string $evento = null
    ) {
    }

    public function envelope(): Envelope
    {
        $config = NotificacionEstadoService::obtener(
            $this->solicitud,
            $this->evento
        );

        return new Envelope(
            subject: "TramitaNet | {$config['asunto']} | Folio {$this->solicitud->folio}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.tramitanet.estado-solicitud-actualizado',
            with: [
                'config' => NotificacionEstadoService::obtener(
                    $this->solicitud,
                    $this->evento
                ),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
