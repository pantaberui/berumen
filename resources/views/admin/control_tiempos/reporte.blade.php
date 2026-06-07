<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Reporte — Control de Tiempos</h2>
            <a href="{{ route('admin.control-tiempos.index') }}"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Filtros --}}
            <div class="bg-white shadow-sm rounded-lg p-4">
                <form method="GET" action="{{ route('admin.control-tiempos.reporte') }}"
                      class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Fecha desde</label>
                        <input type="date" name="fecha_desde" value="{{ $fechaDesde }}"
                               class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Fecha hasta</label>
                        <input type="date" name="fecha_hasta" value="{{ $fechaHasta }}"
                               class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Usuario</label>
                        <select name="user_id" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">— Todos —</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}"
                                    {{ request('user_id') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full py-2 bg-gray-700 text-white rounded hover:bg-gray-800 text-sm">
                            Consultar
                        </button>
                    </div>
                </form>
            </div>

            {{-- Resumen --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-blue-700">${{ number_format($totalRentas, 2) }}</p>
                    <p class="text-sm text-blue-600">Total Rentas</p>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-purple-700">${{ number_format($totalProductos, 2) }}</p>
                    <p class="text-sm text-purple-600">Total Productos</p>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-green-700">${{ number_format($totalGeneral, 2) }}</p>
                    <p class="text-sm text-green-600">Total General</p>
                </div>
            </div>

            {{-- Detalle --}}
            <div class="bg-white shadow-sm rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Folio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Equipo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Inicio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fin</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tiempo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Renta</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Productos</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cajero</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($rentas as $renta)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                #{{ str_pad($renta->id, 6, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $renta->equipo->tipo === 'computadora' ? '💻' : '🎮' }}
                                Equipo {{ $renta->equipo->numero }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ $renta->hora_inicio?->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ $renta->hora_fin?->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-sm font-mono text-gray-700">
                                @php
                                    $h = intdiv($renta->segundos_acumulados, 3600);
                                    $m = intdiv($renta->segundos_acumulados % 3600, 60);
                                    $s = $renta->segundos_acumulados % 60;
                                @endphp
                                {{ sprintf('%02d:%02d:%02d', $h, $m, $s) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">${{ number_format($renta->total_renta, 2) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                @if($renta->total_productos > 0)
                                    ${{ number_format($renta->total_productos, 2) }}
                                    <div class="text-xs text-gray-400">
                                        @foreach($renta->productos as $rp)
                                            {{ $rp->producto->descripcion }} x{{ $rp->cantidad }}<br>
                                        @endforeach
                                    </div>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm font-bold text-green-700">${{ number_format($renta->total, 2) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $renta->cajero->name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-400">
                                No hay rentas en el rango seleccionado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($rentas->count() > 0)
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-sm font-medium text-gray-700 text-right">Totales:</td>
                            <td class="px-4 py-3 text-sm font-bold text-blue-700">${{ number_format($totalRentas, 2) }}</td>
                            <td class="px-4 py-3 text-sm font-bold text-purple-700">${{ number_format($totalProductos, 2) }}</td>
                            <td class="px-4 py-3 text-sm font-bold text-green-700">${{ number_format($totalGeneral, 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</x-app-layout>