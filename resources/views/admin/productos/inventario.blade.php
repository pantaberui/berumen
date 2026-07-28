<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Consulta de Inventario</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Filtros --}}
            <div class="bg-white shadow-sm rounded-lg p-4">
                <form method="GET" action="{{ route('admin.productos.inventario') }}"
                      class="grid grid-cols-1 md:grid-cols-5 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Buscar</label>
                        <input type="text" name="q" value="{{ request('q') }}"
                               placeholder="Clave o descripción..."
                               class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Categoría</label>
                        <select name="categoria" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">— Todas —</option>
                            <option value="producto" {{ request('categoria') == 'producto' ? 'selected' : '' }}>Producto</option>
                            <option value="servicio" {{ request('categoria') == 'servicio' ? 'selected' : '' }}>Servicio</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Proveedor</label>
                        <select name="proveedor" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">— Todos —</option>
                            @foreach($proveedores as $key => $label)
                                <option value="{{ $key }}" {{ request('proveedor') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <label class="flex items-center gap-2 text-sm text-gray-600 mb-1">
                            <input type="checkbox" name="stock_bajo" value="1"
                                   {{ request('stock_bajo') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-red-600">
                            Solo stock bajo
                        </label>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit"
                                class="flex-1 py-2 bg-gray-700 text-white rounded hover:bg-gray-800 text-sm">
                            Consultar
                        </button>
                        <a href="{{ route('admin.productos.inventario') }}"
                           class="py-2 px-3 bg-gray-200 text-gray-700 rounded text-sm">✕</a>
                    </div>
                </form>
            </div>

            {{-- Resumen --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-blue-700">{{ $productos->total() }}</p>
                    <p class="text-sm text-blue-600">Productos en catálogo</p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-red-700">
                        {{ $productos->filter(fn($p) => $p->categoria === 'producto' && $p->stock <= $p->stock_minimo)->count() }}
                    </p>
                    <p class="text-sm text-red-600">Con stock bajo o agotado</p>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-green-700">
                        {{ $productos->filter(fn($p) => $p->categoria === 'producto' && $p->stock > $p->stock_minimo)->count() }}
                    </p>
                    <p class="text-sm text-green-600">Con stock suficiente</p>
                </div>
            </div>

            {{-- Tabla --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clave</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock Mín.</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ajustes Stock</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio Venta</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Último Proveedor</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Última Compra</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($productos as $producto)
                        @php
                            $stockBajo    = $producto->categoria === 'producto' && $producto->stock <= $producto->stock_minimo;
                            $ultimaCompra = $producto->compras()->orderBy('created_at', 'desc')->first();
                            $compraInfo   = $ultimaCompra ? $ultimaCompra->compra : null;
                        @endphp
                        <tr class="hover:bg-gray-50 {{ $stockBajo ? 'bg-red-50' : '' }}">
                            <td class="px-4 py-3 text-sm font-mono font-medium text-gray-900">{{ $producto->clave }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $producto->descripcion }}</td>
                            <td class="px-4 py-3 text-sm">
                                @if($producto->categoria === 'producto')
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Producto</span>
                                @else
                                    <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">Servicio</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm font-medium {{ $stockBajo ? 'text-red-600' : 'text-gray-700' }}">
                                {{ $producto->categoria === 'producto' ? $producto->stock : '—' }}
                                {{ $stockBajo ? '⚠️' : '' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ $producto->categoria === 'producto' ? $producto->stock_minimo : '—' }}
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-500">
                                @if($producto->observaciones_stock)
                                    @php $lineas = explode("\n", trim($producto->observaciones_stock)); @endphp
                                    <div class="max-h-16 overflow-y-auto">
                                        @foreach(array_filter($lineas) as $linea)
                                            <p class="leading-tight">{{ $linea }}</p>
                                        @endforeach
                                    </div>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                ${{ number_format($producto->precio_unitario, 2) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ $compraInfo?->proveedor ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                @if($ultimaCompra)
                                    ${{ number_format($ultimaCompra->precio_compra, 2) }}
                                    <span class="text-xs text-gray-400 block">
                                        {{ $compraInfo?->fecha_compra?->format('d/m/Y') }}
                                    </span>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <a href="{{ route('admin.productos.edit', $producto) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-400">
                                No hay productos con los filtros seleccionados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">{{ $productos->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>