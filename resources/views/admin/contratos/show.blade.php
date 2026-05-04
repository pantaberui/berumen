<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Contrato {{ $contrato->numero_contrato }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('admin.contratos.edit', $contrato) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
                <a href="{{ route('admin.contratos.index') }}"
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Volver</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Datos del contrato --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Datos del Contrato</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                    <div><span class="font-medium text-gray-500">Cliente</span>
                        <p>
                            <a href="{{ route('admin.clientes.show', $contrato->cliente) }}"
                               class="text-blue-600 hover:underline">
                                {{ $contrato->cliente->nombre_completo }}
                            </a>
                        </p>
                    </div>
                    <div><span class="font-medium text-gray-500">Número</span><p>{{ $contrato->numero_contrato }}</p></div>
                    <div><span class="font-medium text-gray-500">Fecha Inicio</span><p>{{ $contrato->fecha_inicio->format('d/m/Y') }}</p></div>
                    <div><span class="font-medium text-gray-500">Mensualidad</span><p>${{ number_format($contrato->mensualidad, 2) }}</p></div>
                    <div><span class="font-medium text-gray-500">Velocidad</span><p>{{ $contrato->velocidad ?? '—' }}</p></div>
                    <div><span class="font-medium text-gray-500">Estatus</span>
                        <p>
                            @if($contrato->estatus === 'activo')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Activo</span>
                            @elseif($contrato->estatus === 'adeudo')
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">Adeudo</span>
                            @else
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Cancelado</span>
                            @endif
                        </p>
                    </div>
                    @if($contrato->observaciones)
                    <div class="col-span-3"><span class="font-medium text-gray-500">Observaciones</span>
                        <p>{{ $contrato->observaciones }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Historial de pagos --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Historial de Pagos</h3>
                @forelse($contrato->pagos as $pago)
                    <div class="border rounded p-3 mb-2 text-sm flex justify-between">
                        <span>{{ $pago->fecha_pago->format('d/m/Y') }} — Periodo: {{ $pago->periodo_desde->format('d/m/Y') }} al {{ $pago->periodo_hasta->format('d/m/Y') }}</span>
                        <span class="font-medium">${{ number_format($pago->total, 2) }}</span>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">Sin pagos registrados.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>