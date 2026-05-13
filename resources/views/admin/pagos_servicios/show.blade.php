<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Pago de Servicio #{{ str_pad($pagoServicio->id, 6, '0', STR_PAD_LEFT) }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('admin.pagos-servicios.edit', $pagoServicio) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
                <a href="{{ route('admin.pagos-servicios.index') }}"
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Volver</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Ticket --}}
            <div class="bg-white shadow-sm rounded-lg p-6 font-mono text-sm" id="ticket" style="max-width:600px;margin:0 auto;">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo.jpg') }}"
                         alt="Entretenimiento Berumen"
                         class="mx-auto mb-3"
                         style="width:75%;max-width:400px;height:180px;object-fit:contain;">
                    <p class="font-bold text-lg">ENTRETENIMIENTO BERUMEN</p>
                    <p class="text-gray-600 text-sm">Tamaulipas 3, San José de Mojarras,</p>
                    <p class="text-gray-600 text-sm">Nayarit, México. Tel. (311) 352-2645</p>
                    <p class="text-gray-600 text-sm">entretenimientoberumen@hotmail.com</p>
                    <p class="text-gray-600 text-sm">Síguenos en Facebook: /berumen.entretenimiento</p>
                    <p class="text-gray-400 text-xs mt-1">{{ $pagoServicio->fecha_hora_registro?->format('d/m/Y H:i') }}</p>
                </div>

                <div class="border-t border-dashed pt-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Folio:</span>
                        <span class="font-bold">#{{ str_pad($pagoServicio->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Servicio:</span>
                        <span class="font-medium">{{ $pagoServicio->tipoServicio->nombre }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Cliente:</span>
                        <span class="font-medium">{{ $pagoServicio->cliente->nombre_completo }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Referencia:</span>
                        <span>{{ $pagoServicio->referencia }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tipo de pago:</span>
                        <span class="capitalize">{{ $pagoServicio->tipo_pago }}</span>
                    </div>
                    @if($pagoServicio->estatus === 'cancelado')
                    <div class="flex justify-between text-red-600 font-medium">
                        <span>ESTATUS:</span>
                        <span>CANCELADO</span>
                    </div>
                    @endif
                </div>

                <div class="border-t border-dashed mt-4 pt-4 space-y-1">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Importe:</span>
                        <span>${{ number_format($pagoServicio->importe, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Comisión:</span>
                        <span>${{ number_format($pagoServicio->comision, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t pt-2 mt-2">
                        <span>TOTAL:</span>
                        <span>${{ number_format($pagoServicio->total, 2) }}</span>
                    </div>
                    <div class="text-xs text-gray-500 italic mt-1">
                        {{ \App\Helpers\NumeroALetras::convertir($pagoServicio->total) }}
                    </div>
                </div>

                <div class="border-t border-dashed mt-4 pt-4 text-center text-gray-400 text-xs">
                    <p>Atendido por: {{ $pagoServicio->cajero->name }} {{ $pagoServicio->cajero->apellido_paterno }}</p>
                    <p class="mt-2">¡Gracias por su pago!</p>
                </div>
            </div>

            {{-- Botones --}}
            <div class="mt-4 flex justify-center gap-3">
                <button onclick="imprimirTicket()"
                        class="bg-gray-800 text-white px-6 py-2 rounded hover:bg-gray-900">
                    🖨 Imprimir Ticket
                </button>
                <button onclick="abrirModalCorreo()"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    ✉️ Enviar por Correo
                </button>
                <button onclick="abrirModalWhatsApp()"
                        class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    📱 Enviar por WhatsApp
                </button>
            </div>

            {{-- Modal correo --}}
            <div id="modal_correo" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-4">
                    <h3 class="text-base font-semibold text-gray-900 mb-1">Enviar Ticket por Correo</h3>
                    <p class="text-sm text-gray-500 mb-4">Puedes modificar el correo si lo deseas.</p>
                    @if(session('success_correo'))
                        <div class="bg-green-100 text-green-800 px-3 py-2 rounded text-sm mb-3">{{ session('success_correo') }}</div>
                    @endif
                    @if(session('error_correo'))
                        <div class="bg-red-100 text-red-800 px-3 py-2 rounded text-sm mb-3">{{ session('error_correo') }}</div>
                    @endif
                    <form action="{{ route('admin.pagos-servicios.enviar-correo', $pagoServicio) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                            <input type="email" name="email"
                                   value="{{ $pagoServicio->cliente->email ?? '' }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm text-sm"
                                   placeholder="correo@ejemplo.com">
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="cerrarModalCorreo()"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm">Cancelar</button>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded text-sm">✉️ Enviar</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Modal WhatsApp --}}
            <div id="modal_whatsapp" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-4">
                    <h3 class="text-base font-semibold text-gray-900 mb-1">Enviar por WhatsApp</h3>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número (10 dígitos)</label>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-500 bg-gray-100 border border-gray-300 rounded px-3 py-2">+52</span>
                            <input type="text" id="whatsapp_numero"
                                   value="{{ preg_replace('/\D/', '', $pagoServicio->cliente->celular ?? $pagoServicio->cliente->telefono ?? '') }}"
                                   class="flex-1 border-gray-300 rounded-md shadow-sm text-sm"
                                   maxlength="10" placeholder="3113522645">
                        </div>
                        <p id="error_whatsapp" class="hidden text-red-600 text-xs mt-1">Ingresa un número válido de 10 dígitos.</p>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="cerrarModalWhatsApp()"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm">Cancelar</button>
                        <button type="button" onclick="enviarWhatsApp()"
                                class="px-4 py-2 bg-green-600 text-white rounded text-sm">📱 Abrir WhatsApp</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function imprimirTicket() {
            const ticket = document.getElementById('ticket').innerHTML;
            const ventana = window.open('', '_blank', 'width=700,height=900');
            ventana.document.write(`<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Recibo</title>
            <style>
                body{font-family:monospace;font-size:13px;margin:20px;}
                img{max-width:100%;}.text-center{text-align:center;}
                .flex{display:flex;}.justify-between{justify-content:space-between;}
                .font-bold{font-weight:bold;}.font-medium{font-weight:500;}
                .text-lg{font-size:16px;}.text-sm{font-size:12px;}.text-xs{font-size:11px;}
                .text-gray-500{color:#6b7280;}.text-gray-600{color:#4b5563;}
                .text-gray-400{color:#9ca3af;}.text-red-600{color:#dc2626;}
                .border-t{border-top:1px solid #e5e7eb;}.border-dashed{border-top-style:dashed;}
                .pt-4{padding-top:16px;}.mt-4{margin-top:16px;}.mt-2{margin-top:8px;}
                .mb-4{margin-bottom:16px;}.mb-3{margin-bottom:12px;}
                .space-y-2>*+*{margin-top:8px;}.space-y-1>*+*{margin-top:4px;}
                .pt-2{padding-top:8px;}.italic{font-style:italic;}
                .capitalize{text-transform:capitalize;}
                @page{margin:1cm;}
            </style></head>
            <body onload="window.print();window.close();">${ticket}</body></html>`);
            ventana.document.close();
        }

        function abrirModalCorreo() { document.getElementById('modal_correo').classList.remove('hidden'); }
        function cerrarModalCorreo() { document.getElementById('modal_correo').classList.add('hidden'); }
        function abrirModalWhatsApp() { document.getElementById('modal_whatsapp').classList.remove('hidden'); }
        function cerrarModalWhatsApp() { document.getElementById('modal_whatsapp').classList.add('hidden'); }

        @if(session('success_correo') || session('error_correo'))
            document.addEventListener('DOMContentLoaded', () => abrirModalCorreo());
        @endif

        function enviarWhatsApp() {
            const numero = document.getElementById('whatsapp_numero').value.replace(/\D/g, '');
            if (numero.length !== 10) {
                document.getElementById('error_whatsapp').classList.remove('hidden');
                return;
            }
            document.getElementById('error_whatsapp').classList.add('hidden');

            const datos = {
                folio:    '{{ str_pad($pagoServicio->id, 6, "0", STR_PAD_LEFT) }}',
                servicio: @json($pagoServicio->tipoServicio->nombre),
                cliente:  @json($pagoServicio->cliente->nombre_completo),
                ref:      @json($pagoServicio->referencia),
                fecha:    '{{ $pagoServicio->fecha_hora_registro?->format("d/m/Y H:i") }}',
                importe:  '${{ number_format($pagoServicio->importe, 2) }}',
                comision: '${{ number_format($pagoServicio->comision, 2) }}',
                total:    '${{ number_format($pagoServicio->total, 2) }}',
            };

            const texto =
                `*ENTRETENIMIENTO BERUMEN*\n` +
                `Tamaulipas 4, San José de Mojarras\n` +
                `Tel. (311) 352-2645\n\n` +
                `*Recibo de Pago de Servicio*\n` +
                `Folio: #${datos.folio}\n` +
                `Servicio: ${datos.servicio}\n` +
                `Cliente: ${datos.cliente}\n` +
                `Referencia: ${datos.ref}\n` +
                `Fecha: ${datos.fecha}\n` +
                `Importe: ${datos.importe}\n` +
                `Comisión: ${datos.comision}\n` +
                `*TOTAL: ${datos.total}*\n\n` +
                `¡Gracias por su pago!`;

            window.open(`https://wa.me/52${numero}?text=${encodeURIComponent(texto)}`, '_blank');
            cerrarModalWhatsApp();
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') { cerrarModalCorreo(); cerrarModalWhatsApp(); }
        });
    </script>
</x-app-layout>