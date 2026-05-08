<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Ficha WiFi — Folio #{{ str_pad($codigoNetplus->id, 6, '0', STR_PAD_LEFT) }}
            </h2>
            <a href="{{ route('admin.fichas-wifi.create') }}"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-sm mx-auto sm:px-6 lg:px-8">

            {{-- Ticket --}}
            <div class="bg-white shadow-sm rounded-lg p-6 font-mono text-sm" id="ticket">

                {{-- Logo NetPlus placeholder --}}
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo_netplus.jpg') }}"
                        alt="Entretenimiento Berumen"
                        class="mx-auto mb-3"
                        style="width: 95%; max-width: 700px; height: 150px; object-fit: contain;">
                    <p class="text-gray-500 text-xs mt-2">
                        Gracias por usar nuestros servicios,<br>
                        Conéctate a la red WiFi <strong>NetPlus</strong> y digita el código de tu ficha.<br>
                    </p>
                    <p class="text-gray-400 text-xs mt-1">
                        {{ $codigoNetplus->fecha_venta?->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div class="border-t border-dashed pt-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Folio:</span>
                        <span class="font-bold">#{{ str_pad($codigoNetplus->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tiempo:</span>
                        <span class="font-medium">{{ $tipo['label'] ?? $codigoNetplus->tiempo }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Importe:</span>
                        <span class="font-medium">${{ number_format($codigoNetplus->importe, 2) }}</span>
                    </div>
                    @if($codigoNetplus->estatus === 'cancelado')
                    <div class="flex justify-between text-red-600 font-medium">
                        <span>ESTATUS:</span>
                        <span>CANCELADO</span>
                    </div>
                    @endif
                </div>

                {{-- Código resaltado --}}
                <div class="border-t border-dashed mt-4 pt-4 text-center">
                    <p class="text-gray-500 text-xs mb-2">Tu código de acceso:</p>
                    <div class="bg-gray-100 rounded-lg py-4 px-6 inline-block">
                        <span class="font-bold tracking-widest"
                              style="font-size: 1.6rem; letter-spacing: 0.2em;">
                            {{ $codigoNetplus->codigo }}
                        </span>
                    </div>
                    <p class="text-gray-400 text-xs mt-2">⚠️ Digítalo en minúsculas</p>
                </div>

                <div class="border-t border-dashed mt-4 pt-4 text-center text-gray-400 text-xs">
                    <p>Atendido por: {{ $codigoNetplus->vendedor?->name }}</p>
                    <p class="mt-1">Entretenimiento Berumen</p>
                    <p class="mt-1">Tel. (311) 352-2645</p>
                </div>

            </div>

            {{-- Botones --}}
            <div class="mt-4 flex justify-center gap-3">
                <button onclick="imprimirTicket()"
                        class="bg-gray-800 text-white px-6 py-2 rounded hover:bg-gray-900">
                    🖨 Imprimir
                </button>
                @if(auth()->user()->hasRole('admin') && $codigoNetplus->estatus !== 'cancelado')
                <form action="{{ route('admin.codigos-netplus.cancelar', $codigoNetplus) }}"
                      method="POST" class="inline"
                      onsubmit="return confirm('¿Cancelar esta ficha?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                        Cancelar Ficha
                    </button>
                </form>
                @endif
            </div>

        </div>
    </div>

    <script>
        function imprimirTicket() {
            const ticket = document.getElementById('ticket').innerHTML;
            const ventana = window.open('', '_blank', 'width=400,height=600');
            ventana.document.write(`<!DOCTYPE html><html><head><meta charset="UTF-8">
            <title>Ficha WiFi Netplus</title>
            <style>
                body{font-family:monospace;font-size:13px;margin:20px;max-width:300px;}
                .text-center{text-align:center;}.flex{display:flex;}
                .justify-between{justify-content:space-between;}
                .font-bold{font-weight:bold;}.font-medium{font-weight:500;}
                .text-gray-500{color:#6b7280;}.text-gray-400{color:#9ca3af;}
                .text-red-600{color:#dc2626;}
                .border-t{border-top:1px solid #e5e7eb;}.border-dashed{border-top-style:dashed;}
                .pt-4{padding-top:16px;}.mt-4{margin-top:16px;}.mt-2{margin-top:8px;}
                .mt-1{margin-top:4px;}.mt-3{margin-top:12px;}.mb-2{margin-bottom:8px;}
                .space-y-2>*+*{margin-top:8px;}
                .bg-gray-100{background:#f3f4f6;}.rounded-lg{border-radius:8px;}
                .py-4{padding-top:16px;padding-bottom:16px;}
                .px-6{padding-left:24px;padding-right:24px;}
                .inline-block{display:inline-block;}
                .tracking-widest{letter-spacing:0.2em;}
                .text-xs{font-size:11px;}
                @page{margin:0.5cm;}
            </style></head>
            <body onload="window.print();window.close();">${ticket}</body></html>`);
            ventana.document.close();
        }
    </script>
</x-app-layout>