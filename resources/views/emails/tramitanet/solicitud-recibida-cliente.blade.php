<x-mail::message>
# Solicitud recibida

Hola.

Recibimos correctamente tu solicitud en TramitaNet.

<x-mail::panel>
**Folio:** {{ $solicitud->folio }}

**Servicio:** {{ $solicitud->servicio->titulo_publico ?? $solicitud->servicio->nombre }}

**Modalidad:** {{ $solicitud->modalidad->nombre ?? 'No especificada' }}

**Estado:** Solicitud recibida
</x-mail::panel>

Puedes consultar el avance de tu trámite desde el siguiente botón:

<x-mail::button :url="route('tramitanet.expediente', $solicitud->folio)">
Consultar mi trámite
</x-mail::button>

Conserva tu folio para futuras consultas.

Gracias por utilizar TramitaNet.

Saludos,<br>
**Equipo TramitaNet**  
Servicios en Línea Berumen
</x-mail::message>
