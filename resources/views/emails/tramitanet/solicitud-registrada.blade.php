<x-mail::message>
# Solicitud recibida

Hemos registrado correctamente tu solicitud en **TramitaNet**.

**Trámite:**  
{{ $solicitud->servicio->titulo_publico ?? $solicitud->servicio->nombre }}

**Folio:**  
{{ $solicitud->folio }}

**Código de seguimiento:**  
{{ $solicitud->codigo_consulta }}

Conserva ambos datos. Los necesitarás para consultar el avance de tu solicitud.

<x-mail::button :url="route('tramitanet.consulta')">
Consultar mi trámite
</x-mail::button>

También puedes entrar directamente al portal y capturar tu folio y código de seguimiento.

Gracias por utilizar TramitaNet.

Saludos,  
**Servicios Digitales Berumen**
</x-mail::message>
