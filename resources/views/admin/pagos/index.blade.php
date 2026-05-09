<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Pagos Internet</h2>
            <a href="{{ route('admin.pagos.create') }}"
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
                <form method="GET" action="{{ route('admin.pagos.index') }}"
                      class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <input type="text" name="q" value="{{ $busqueda ?? '' }}"
                           placeholder="Buscar por nombre cliente..."
                           class="border-gray-300 rounded-md shadow-sm text-sm"
                           minlength="3">
                    <input type="date" name="fecha_desde" value="{{ $fechaDesde }}"
                           class="border-gray-300 rounded-md shadow-sm text-sm">
                    <input type="date" name="fecha_hasta" value="{{ $fechaHasta }}"
                           class="border-gray-300 rounded-md shadow-sm text-sm">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex gap-2">
                            <button type="submit"
                                    class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800 text-sm">
                                Buscar
                            </button>
                            <a href="{{ route('admin.pagos.index') }}"
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

            {{-- Tabla --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contrato</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Pago</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periodo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cajero</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pagos as $pago)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $pago->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $pago->contrato->numero_contrato }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $pago->contrato->cliente->nombre_completo }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $pago->periodo_desde->format('d/m/Y') }} — {{ $pago->periodo_hasta->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">${{ number_format($pago->total, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 capitalize">{{ $pago->tipo_pago }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $pago->cajero->name }}</td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.pagos.show', $pago) }}"
                                   class="text-blue-600 hover:underline">Ver</a>
                                <a href="{{ route('admin.pagos.edit', $pago) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                                <form action="{{ route('admin.pagos.destroy', $pago) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('¿Eliminar este pago?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-400">
                                No hay pagos en el rango seleccionado.
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