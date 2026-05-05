<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Detalle de Pago #{{ $pago->id }}</h2>
            <div class="space-x-2">
                <a href="{{ route('admin.pagos.edit', $pago) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
                <a href="{{ route('admin.pagos.index') }}"
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

            {{-- Ticket visual --}}
            <div class="bg-white shadow-sm rounded-lg p-6 font-mono text-sm" id="ticket">
                <div class="text-center mb-4">
                    <p class="font-bold text-lg">ENTRETENIMIENTO BERUMEN</p>
                    <p class="text-gray-500">Recibo de Pago</p>
                    <p class="text-gray-400 text-xs">{{ now()->format('d/m/Y H:i') }}</p>
                </div>

                <div class="border-t border-dashed pt-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Cliente:</span>
                        <span class="font-medium">{{ $pago->contrato->cliente->nombre_completo }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Contrato:</span>
                        <span>{{ $pago->contrato->numero_contrato }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Fecha pago:</span>
                        <span>{{ $pago->fecha_pago->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Periodo:</span>
                        <span>{{ $pago->periodo_desde->format('d/m/Y') }} al {{ $pago->periodo_hasta->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tipo de pago:</span>
                        <span class="capitalize">{{ $pago->tipo_pago }}</span>
                    </div>
                </div>

                <div class="border-t border-dashed mt-4 pt-4 space-y-1">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Importe:</span>
                        <span>${{ number_format($pago->importe, 2) }}</span>
                    </div>
                    @if($pago->descuento > 0)
                    <div class="flex justify-between text-red-600">
                        <span>Descuento:</span>
                        <span>-${{ number_format($pago->descuento, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between font-bold text-lg border-t pt-2 mt-2">
                        <span>TOTAL:</span>
                        <span>${{ number_format($pago->total, 2) }}</span>
                    </div>
                </div>

                <div class="border-t border-dashed mt-4 pt-4 text-center text-gray-400 text-xs">
                    <p>Atendido por: {{ $pago->cajero->name }}</p>
                    <p class="mt-2">¡Gracias por su pago!</p>
                </div>
            </div>

            <div class="mt-4 text-center">
                <button onclick="window.print()"
                        class="bg-gray-800 text-white px-6 py-2 rounded hover:bg-gray-900">
                    🖨 Imprimir Ticket
                </button>
            </div>

        </div>
    </div>
</x-app-layout>