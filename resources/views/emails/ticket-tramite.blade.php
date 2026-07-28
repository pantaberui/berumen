<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Trámite</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 500px; margin: 0 auto; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #1e293b, #1e40af); color: white; padding: 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 20px; }
        .header p { margin: 4px 0 0; font-size: 13px; opacity: 0.8; }
        .body { padding: 24px; }
        .row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #f0f0f0; font-size: 14px; }
        .row .label { color: #6b7280; }
        .row .value { font-weight: 500; color: #1e293b; text-align: right; max-width: 60%; }
        .total-row { display: flex; justify-content: space-between; padding: 12px 0; font-size: 18px; font-weight: bold; border-top: 2px solid #1e40af; margin-top: 8px; }
        .total-row .value { color: #16a34a; }
        .letras { font-size: 11px; color: #6b7280; font-style: italic; padding: 4px 0 12px; }
        .detalles { background: #f8fafc; border-radius: 6px; padding: 12px; margin: 12px 0; }
        .detalles h3 { margin: 0 0 8px; font-size: 13px; color: #374151; }
        .detalle-row { display: flex; justify-content: space-between; font-size: 13px; color: #4b5563; padding: 3px 0; }
        .footer { background: #f8fafc; padding: 16px 24px; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #e5e7eb; }
        .badge { display: inline-block; background: #dcfce7; color: #166534; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge.cancelado { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Entretenimiento Berumen</h1>
            <p>Tamaulipas 3, San José de Mojarras, Nayarit · Tel. (311) 352-2645</p>
        </div>
        <div class="body">
            <p style="font-size:13px; color:#6b7280; margin:0 0 16px;">
                Recibo de Trámite &nbsp;·&nbsp;
                {{ $tramite->fecha_hora_cobro?->format('d/m/Y H:i') }}
                &nbsp;·&nbsp;
                <span class="badge {{ $tramite->estatus === 'cancelado' ? 'cancelado' : '' }}">
                    {{ ucfirst($tramite->estatus) }}
                </span>
            </p>

            <div class="row">
                <span class="label">Folio</span>
                <span class="value">#{{ str_pad($tramite->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="row">
                <span class="label">Cliente</span>
                <span class="value">{{ $tramite->cliente_nombre }}</span>
            </div>


            {{-- Detalle de trámites --}}
            @if($tramite->detalles && $tramite->detalles->count() > 0)
            <div class="detalles">
                <h3>Detalle de Trámites</h3>
                @foreach($tramite->detalles as $detalle)
                <div class="detalle-row">
                    <span>{{ $detalle->tipoTramite->nombre }} × {{ $detalle->cantidad }}</span>
                    <span>${{ number_format($detalle->subtotal, 2) }}</span>
                </div>
                @endforeach
            </div>
            @endif

            @if($tramite->observaciones)
            <div class="row">
                <span class="label">Observaciones</span>
                <span class="value">{{ $tramite->observaciones }}</span>
            </div>
            @endif

            <div class="total-row">
                <span>TOTAL </span>
                <span class="value">${{ number_format($tramite->subtotal, 2) }}</span>
            </div>
            <div class="letras">{{ \App\Helpers\NumeroALetras::convertir($tramite->subtotal) }}</div>
        </div>

        <div class="row">
            <span class="label">Atendido por </span>
            <span class="value">{{ $tramite->cajero->name }} {{ $tramite->cajero->apellido_paterno }}</span>
        </div>

        <div class="footer">
            ¡Gracias por su visita! · Entretenimiento Berumen · Tel. (311) 352-2645
            <br>© {{ date('Y') }} Entretenimiento Berumen. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
