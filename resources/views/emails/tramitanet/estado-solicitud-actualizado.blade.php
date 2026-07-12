@php
    use App\Support\TramitaNet\EstadosSolicitud;

    $estado = EstadosSolicitud::labels()[$solicitud->estatus]
        ?? strtoupper(str_replace('_', ' ', $solicitud->estatus));

    $mensajes = [
        'esperando_pago' => [
            'titulo' => 'Tu solicitud está en espera de pago',
            'mensaje' => 'Ya puedes consultar la referencia y las instrucciones de pago en tu expediente.',
        ],

        'pago_en_revision' => [
            'titulo' => 'Estamos revisando tu comprobante',
            'mensaje' => 'Recibimos tu comprobante y nuestro personal lo revisará en breve.',
        ],

        'pago_confirmado' => [
            'titulo' => 'Tu pago fue confirmado',
            'mensaje' => 'El pago fue validado correctamente y tu trámite continuará con el siguiente paso.',
        ],

        'en_gestion' => [
            'titulo' => 'Tu trámite está en gestión',
            'mensaje' => 'Nuestro personal ya está realizando las gestiones correspondientes.',
        ],

        'informacion_requerida' => [
            'titulo' => 'Necesitamos información adicional',
            'mensaje' => 'Consulta tu expediente para revisar la información o documentación requerida.',
        ],

        'entregado' => [
            'titulo' => 'Tu trámite ha concluido',
            'mensaje' => 'Tu documento o resultado ya está disponible en el expediente.',
        ],

        'cancelado' => [
            'titulo' => 'Tu solicitud fue cancelada',
            'mensaje' => 'Consulta el expediente para conocer los detalles de la cancelación.',
        ],

        'rechazado' => [
            'titulo' => 'Tu solicitud no pudo continuar',
            'mensaje' => 'Consulta el expediente para revisar los detalles y observaciones.',
        ],
    ];

    $contenido = $mensajes[$solicitud->estatus] ?? [
        'titulo' => 'El estado de tu solicitud cambió',
        'mensaje' => 'Consulta tu expediente para conocer el avance actualizado.',
    ];
@endphp

@php
    $ultimoHistorial = $solicitud->historial()
        ->latest('id')
        ->first();
@endphp


<x-mail::message>
# {{ $contenido['titulo'] }}

{{ $contenido['mensaje'] }}


@if(
    $ultimoHistorial?->observacion &&
    in_array($solicitud->estatus, [
        'esperando_pago',
        'informacion_requerida',
        'cancelado',
        'rechazado',
    ])
)
<x-mail::panel>
**Observación:**

{{ $ultimoHistorial->observacion }}
</x-mail::panel>
@endif




<x-mail::button :url="route('tramitanet.expediente', $solicitud->folio)">
Consultar mi trámite
</x-mail::button>

Conserva tu folio para futuras consultas.

Saludos,<br>
**Servicios en Línea Berumen**
</x-mail::message>
