<x-mail::message>

<div style="text-align:center;margin-bottom:20px;">

# ENTRETENIMIENTO BERUMEN
Tamaulipas 3, San José de Mojarras
Nayarit, México. Tel. (311) 352-2645
</div>

---

# Ticket de Venta

**Folio:** #{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}
**Cliente:** {{ $venta->cliente_nombre }}
**Fecha:** {{ $venta->fecha_hora_venta?->format('d/m/Y H:i') }}
**Tipo de pago:** {{ ucfirst($venta->tipo_pago) }}

---

| Descripción | Cant. | Precio | Desc. | Subtotal |
|-------------|-------|--------|-------|----------|
@foreach($venta->detalles as $detalle)
| {{ $detalle->producto->descripcion }} | {{ $detalle->cantidad }} | ${{ number_format($detalle->precio_unitario, 2) }} | -${{ number_format($detalle->descuento, 2) }} | ${{ number_format($detalle->subtotal, 2) }} |
@endforeach

@if($venta->descuento_total > 0)
**Descuentos:** -${{ number_format($venta->descuento_total, 2) }}
@endif
**TOTAL: ${{ number_format($venta->total, 2) }}**

*{{ \App\Helpers\NumeroALetras::convertir($venta->total) }}*

---

Atendido por: {{ $venta->vendedor->name }}

<x-mail::panel>
¡Gracias por su compra! Tel. (311) 352-2645
</x-mail::panel>

</x-mail::message>