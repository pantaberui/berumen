

@php
    $ultimoHistorial = $solicitud->historial()
        ->latest('id')
        ->first();
@endphp


<x-mail::message>
# {{ $config['titulo'] }}

{{ $config['mensaje'] }}


@if(
    $config['mostrarObservacion']
    && $ultimoHistorial?->observacion
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
