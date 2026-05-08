<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Reporte de Ventas — Fichas WiFi Netplus</h2>
            <a href="{{ route('admin.codigos-netplus.index') }}"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Filtros --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="GET" action="{{ route('admin.codigos-netplus.reporte') }}"
                      class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Fecha desde</label>
                        <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Fecha hasta</label>
                        <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
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
                    <div class="flex items-end gap-2">
                        <button type="submit"
                                class="flex-1 py-2 bg-gray-700 text-white rounded hover:bg-gray-800 text-sm">
                            Consultar
                        </button>
                        <a href="{{ route('admin.codigos-netplus.reporte') }}"
                           class="py-2 px-3 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">
                            ✕
                        </a>
                    </div>
                </form>
            </div>

            @if(request()->hasAny(['fecha_desde','fecha_hasta','user_id']))

            {{-- Resumen --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-green-700">${{ number_format($total, 2) }}</p>
                    <p class="text-sm text-green-600">Total acumulado</p>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-blue-700">{{ $cantidad }}</p>
                    <p class="text-sm text-blue-600">Fichas vendidas</p>
                </div>
                @foreach($porTipo as $key => $datos)
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                    <p class="text-lg font-bold text-gray-700">{{ $datos['cantidad'] }}</p>
                    <p class="text-xs text-gray-500">{{ \App\Models\CodigoNetplus::tiposFicha()[$key]['label'] ?? $key }}</p>
                    <p class="text-sm font-medium text-gray-600">${{ number_format($datos['total'], 2) }}</p>
                </div>
                @endforeach
            </div>

            {{-- Detalle --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Folio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Importe</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vendedor</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($ventas as $venta)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                #{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 py-3 text-sm font-mono text-gray-700">{{ $venta->codigo }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ \App\Models\CodigoNetplus::tiposFicha()[$venta->tipo_ficha]['label'] ?? $venta->tipo_ficha }}
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                ${{ number_format($venta->importe, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $venta->vendedor?->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ $venta->fecha_venta?->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <a href="{{ route('admin.fichas-wifi.ticket', $venta) }}"
                                   class="text-blue-600 hover:underline">Reimprimir</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                No hay ventas en el rango seleccionado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($ventas->count() > 0)
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-sm font-medium text-gray-700 text-right">
                                Total:
                            </td>
                            <td class="px-4 py-3 text-sm font-bold text-green-700">
                                ${{ number_format($total, 2) }}
                            </td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            @endif

        </div>
    </div>
</x-app-layout>