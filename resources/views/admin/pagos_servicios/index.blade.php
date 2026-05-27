<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Pagos de Servicios</h2>
            <a href="{{ route('admin.pagos-servicios.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Registrar Pago
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filtros --}}
            <div class="bg-white shadow-sm rounded-lg p-4 mb-4">
                <form method="GET" action="{{ route('admin.pagos-servicios.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <input type="text" name="q" value="{{ $busqueda ?? '' }}"
                           placeholder="Buscar por nombre cliente..."
                           class="border-gray-300 rounded-md shadow-sm text-sm">
                    <select name="tipo_servicio_id" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">— Todos los servicios —</option>
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id }}"
                                {{ request('tipo_servicio_id') == $servicio->id ? 'selected' : '' }}>
                                {{ $servicio->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <input type="date" name="fecha_desde" value="{{ $fechaDesde }}"
                        class="border-gray-300 rounded-md shadow-sm text-sm">
                    <input type="date" name="fecha_hasta" value="{{ $fechaHasta }}"
                        class="border-gray-300 rounded-md shadow-sm text-sm">

                    <div class="md:col-span-4 flex items-center justify-between">
                        <div class="flex gap-2">
                            <button type="submit"
                                    class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800 text-sm">
                                Buscar
                            </button>
                            <a href="{{ route('admin.pagos-servicios.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">
                                ✕ Limpiar
                            </a>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Total acumulado</p>
                            <p class="text-xl font-bold text-green-700">${{ number_format($totalAcumulado, 2) }}</p>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Folio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Servicio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Referencia</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Importe</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comisión</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pagos as $pago)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900"># {{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $pago->tipoServicio->nombre }}</td>
    
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $pago->cliente_nombre ?? $pago->cliente?->nombre_completo ?? 'PÚBLICO EN GENERAL' }}
                            </td>


                            <td class="px-4 py-3 text-sm text-gray-500">{{ $pago->referencia }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">${{ number_format($pago->importe, 2) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">${{ number_format($pago->comision, 2) }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">${{ number_format($pago->total, 2) }}</td>
                            <td class="px-4 py-3 text-sm">
                                @if($pago->estatus === 'pagado')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Pagado</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Cancelado</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $pago->fecha_hora_registro?->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 text-sm space-x-2">
                                <a href="{{ route('admin.pagos-servicios.show', $pago) }}"
                                   class="text-blue-600 hover:underline">Ver</a>
                                <a href="{{ route('admin.pagos-servicios.edit', $pago) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="px-6 py-8 text-center text-gray-400">
                                No hay pagos registrados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">
                    {{ $pagos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>