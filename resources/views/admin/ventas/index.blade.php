<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Ventas</h2>
            <a href="{{ route('admin.ventas.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nueva Venta
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            {{-- Filtros --}}
            <div class="bg-white shadow-sm rounded-lg p-4">
                <form method="GET" action="{{ route('admin.ventas.index') }}"
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
                        <label class="block text-xs font-medium text-gray-500 mb-1">Producto / Servicio</label>
                        <select name="producto_id" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">— Todos —</option>
                            @foreach($productos as $p)
                                <option value="{{ $p->id }}"
                                    {{ request('producto_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->clave }} — {{ $p->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Usuario</label>
                        <select name="user_id" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">— Todos —</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}"
                                    {{ request('user_id', auth()->id()) == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end justify-between gap-2">
                        <div class="flex gap-2">
                            <button type="submit"
                                    class="py-2 px-4 bg-gray-700 text-white rounded hover:bg-gray-800 text-sm">
                                Buscar
                            </button>
                            <a href="{{ route('admin.ventas.index') }}"
                               class="py-2 px-3 bg-gray-200 text-gray-700 rounded text-sm">✕</a>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Total acumulado</p>
                            <p class="text-xl font-bold text-green-700">${{ number_format($totalAcumulado, 2) }}</p>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Folio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto/Servicio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cant.</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo Pago</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vendedor</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                       @forelse($ventas as $venta)
                        <tr class="hover:bg-gray-50 {{ $venta->estatus === 'cancelada' ? 'opacity-60' : '' }}">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900" rowspan="{{ max(1, $venta->detalles->count()) }}">
                                #{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700" rowspan="{{ max(1, $venta->detalles->count()) }}">
                                {{ $venta->cliente_nombre }}
                            </td>

                            {{-- Primera línea de detalle --}}
                            @if($venta->detalles->count() > 0)
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $venta->detalles->first()->producto->descripcion }}
                                </td>
                                <td class="px-4 py-3 text-sm text-center text-gray-500">
                                    {{ $venta->detalles->first()->cantidad }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    ${{ number_format($venta->detalles->first()->precio_unitario, 2) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    ${{ number_format($venta->detalles->first()->subtotal, 2) }}
                                </td>
                            @else
                                <td colspan="4" class="px-4 py-3 text-sm text-gray-400">Sin detalle</td>
                            @endif

                            <td class="px-4 py-3 text-sm font-bold text-green-700" rowspan="{{ max(1, $venta->detalles->count()) }}">
                                ${{ number_format($venta->total, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500 capitalize" rowspan="{{ max(1, $venta->detalles->count()) }}">
                                {{ $venta->tipo_pago }}
                            </td>
                            <td class="px-4 py-3 text-sm" rowspan="{{ max(1, $venta->detalles->count()) }}">
                                @if($venta->estatus === 'completada')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Completada</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Cancelada</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500" rowspan="{{ max(1, $venta->detalles->count()) }}">
                                {{ $venta->vendedor->name }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500" rowspan="{{ max(1, $venta->detalles->count()) }}">
                                {{ $venta->fecha_hora_venta?->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-sm space-x-2" rowspan="{{ max(1, $venta->detalles->count()) }}">
                                <a href="{{ route('admin.ventas.show', $venta) }}"
                                class="text-blue-600 hover:underline">Ver</a>
                                @if($venta->estatus !== 'cancelada')
                                <a href="{{ route('admin.ventas.edit', $venta) }}"
                                class="text-yellow-600 hover:underline">Editar</a>
                                @endif
                            </td>
                        </tr>

                        {{-- Líneas adicionales de detalle --}}
                        @foreach($venta->detalles->skip(1) as $detalle)
                        <tr class="hover:bg-gray-50 {{ $venta->estatus === 'cancelada' ? 'opacity-60' : '' }}">
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $detalle->producto->descripcion }}
                            </td>
                            <td class="px-4 py-3 text-sm text-center text-gray-500">
                                {{ $detalle->cantidad }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                ${{ number_format($detalle->precio_unitario, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                ${{ number_format($detalle->subtotal, 2) }}
                            </td>
                        </tr>
                        @endforeach                       
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-400">
                                No hay ventas en el rango seleccionado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">{{ $ventas->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>