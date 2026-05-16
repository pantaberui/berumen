<x-mail::message>

<div style="text-align:center;margin-bottom:20px;">

# ENTRETENIMIENTO BERUMEN
Tamaulipas 3, San José de Mojarras,
Nayarit, México. Tel. (311) 352-2645
</div>

---

# Recibo de Trámite

**Folio:** #{{ str_pad($tramite->id, 6, '0', STR_PAD_LEFT) }}
**Trámite:** {{ $tramite->tipoTramite->nombre }}
**Cliente:** {{ $tramite->cliente_nombre }}
**Fecha:** {{ $tramite->fecha_hora_cobro?->format('d/m/Y H:i') }}

---

| Concepto | Cant. | Importe | Subtotal |
|----------|-------|---------|----------|
| {{ $tramite->tipoTramite->nombre }} | {{ $tramite->cantidad }} | ${{ number_format($tramite->importe, 2) }} | ${{ number_format($tramite->subtotal, 2) }} |

**TOTAL: ${{ number_format($tramite->subtotal, 2) }}**

*{{ \App\Helpers\NumeroALetras::convertir($tramite->subtotal) }}*

---

Atendido por: {{ $tramite->cajero->name }} {{ $tramite->cajero->apellido_paterno }}

<x-mail::panel>
¡Gracias por su visita! Tel. (311) 352-2645
</x-mail::panel>

</x-mail::message>