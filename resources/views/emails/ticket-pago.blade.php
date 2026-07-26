<x-mail::message>

<div style="text-align:center; margin-bottom: 20px;">
<img src="{{ asset('images/logo_berumen.png') }}" alt="Entretenimiento Berumen" style="height:80px;">

# ENTRETENIMIENTO BERUMEN
Tamaulipas 3, San José de Mojarras.
Nayarit, México. Tel. (311) 352-2645
tramitanet.berumen@gmail.com
</div>

---

# Recibo de Pago

**Folio:** # {{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}
**Cliente:** {{ $pago->contrato->cliente->nombre_completo }}
**Contrato:** {{ $pago->contrato->numero_contrato }}
**Fecha de pago:** {{ $pago->fecha_pago->format('d/m/Y') }}
**Periodo:** {{ $pago->periodo_desde->format('d/m/Y') }} al {{ $pago->periodo_hasta->format('d/m/Y') }}
**Tipo de pago:** {{ ucfirst($pago->tipo_pago) }}

---

| Concepto | Importe |
|----------|---------|
| Renta de Internet | ${{ number_format($pago->importe, 2) }} |
@if($pago->descuento > 0)
| Descuento | -${{ number_format($pago->descuento, 2) }} |
@endif
| **TOTAL** | **${{ number_format($pago->total, 2) }}** |

*{{ \App\Helpers\NumeroALetras::convertir($pago->total) }}*

---

Atendido por: {{ $pago->cajero->name }}
Fecha de emisión: {{ $pago->fecha_hora_registro?->format('d/m/Y H:i') }}

<x-mail::panel>
¡Gracias por su pago! Si tiene alguna duda comuníquese al Tel. (311) 352-26-45.
</x-mail::panel>

Síguenos en Facebook: /berumen.entretenimiento

</x-mail::message>
