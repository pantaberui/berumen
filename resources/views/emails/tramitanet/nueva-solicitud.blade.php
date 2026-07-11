<x-mail::message>
# Nueva solicitud TramitaNet

Se ha recibido una nueva solicitud.

**Folio**

{{ $solicitud->folio }}

**Institución**

{{ $solicitud->servicio->institucion->nombre }}

**Servicio**

{{ $solicitud->servicio->titulo_publico ?? $solicitud->servicio->nombre }}

**Modalidad**

{{ $solicitud->modalidad->nombre }}

**Total**

${{ number_format($solicitud->total_pagar, 2) }}

<x-mail::button :url="route('admin.tramitanet.solicitudes.show', $solicitud)">
Ver solicitud
</x-mail::button>

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
