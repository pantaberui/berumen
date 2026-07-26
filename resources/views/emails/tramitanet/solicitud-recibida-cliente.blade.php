<x-mail::message>
# Solicitud recibida

Hola.

Recibimos correctamente tu solicitud en **TramitaNet**.

<x-mail::panel>
**Folio:** {{ $solicitud->folio }}

**Código de seguimiento:** {{ $solicitud->codigo_consulta }}

**Servicio:** {{ $solicitud->servicio->titulo_publico ?? $solicitud->servicio->nombre }}

**Modalidad:** {{ $solicitud->modalidad->nombre ?? 'No especificada' }}

**Estado:** Solicitud recibida
</x-mail::panel>

Conserva tu **folio** y tu **código de seguimiento**. Los necesitarás para consultar el avance de tu solicitud.

<x-mail::button :url="route('tramitanet.consulta')">
Consultar mi trámite
</x-mail::button>

También puedes ingresar directamente al portal y capturar ambos datos.

Gracias por utilizar TramitaNet.

Saludos,<br>
**Equipo TramitaNet**  
Servicios en Línea Berumen
</x-mail::message>
