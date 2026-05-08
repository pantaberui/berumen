<x-mail::message>

<div style="text-align:center;margin-bottom:20px;">

# ENTRETENIMIENTO BERUMEN
Tamaulipas 3, San José de Mojarras,
Nayarit, México. Tel. (311) 352-2645
</div>

---

# Recibo de Pago de Servicio

**Folio:** #{{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}
**Servicio:** {{ $pago->tipoServicio->nombre }}
**Cliente:** {{ $pago->cliente->nombre_completo }}
**Referencia:** {{ $pago->referencia }}
**Fecha:** {{ $pago->fecha_hora_registro?->format('d/m/Y H:i') }}
**Tipo de pago:** {{ ucfirst($pago->tipo_pago) }}

---

| Concepto | Importe |
|----------|---------|
| Pago de servicio | ${{ number_format($pago->importe, 2) }} |
| Comisión | ${{ number_format($pago->comision, 2) }} |
| **TOTAL** | **${{ number_format($pago->total, 2) }}** |

*{{ \App\Helpers\NumeroALetras::convertir($pago->total) }}*

---

Atendido por: {{ $pago->cajero->name }}

<x-mail::panel>
¡Gracias por su pago! Tel. (311) 352-2645
</x-mail::panel>

</x-mail::message>
