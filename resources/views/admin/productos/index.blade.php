<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Catálogo de Productos y Servicios</h2>
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('admin.productos.index') }}" class="flex gap-2">
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Buscar por clave o descripción..."
                           class="border-gray-300 rounded-md shadow-sm text-sm w-64">
                    <select name="categoria" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">— Todos —</option>
                        <option value="producto" {{ request('categoria') == 'producto' ? 'selected' : '' }}>Productos</option>
                        <option value="servicio" {{ request('categoria') == 'servicio' ? 'selected' : '' }}>Servicios</option>
                    </select>
                    <button type="submit" class="px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">Buscar</button>
                    @if(request('q') || request('categoria'))
                        <a href="{{ route('admin.productos.index') }}" class="px-3 py-2 bg-gray-200 text-gray-700 rounded text-sm">✕</a>
                    @endif
                </form>
                <a href="{{ route('admin.productos.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Nuevo
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clave</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock Mín.</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ajustes Stock</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($productos as $producto)
                        <tr class="hover:bg-gray-50 {{ $producto->categoria === 'producto' && $producto->stock <= $producto->stock_minimo ? 'bg-red-50' : '' }}">
                            <td class="px-4 py-3 text-sm font-mono font-medium text-gray-900">{{ $producto->clave }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $producto->descripcion }}</td>
                            <td class="px-4 py-3 text-sm">
                                @if($producto->categoria === 'producto')
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Producto</span>
                                @else
                                    <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">Servicio</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm {{ $producto->categoria === 'producto' && $producto->stock <= $producto->stock_minimo ? 'text-red-600 font-bold' : 'text-gray-500' }}">
                                {{ $producto->categoria === 'producto' ? $producto->stock : '—' }}
                                {{ $producto->categoria === 'producto' && $producto->stock <= $producto->stock_minimo ? '⚠️' : '' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ $producto->categoria === 'producto' ? $producto->stock_minimo : '—' }}
                            </td>

                            <td class="px-4 py-3 text-xs text-gray-500 max-w-xs">
                                @if($producto->observaciones_stock)
                                    <div class="max-h-16 overflow-y-auto whitespace-pre-line leading-tight">
                                        {{ $producto->observaciones_stock }}
                                    </div>
                                @else
                                    —
                                @endif
                            </td>
                            
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">${{ number_format($producto->precio_unitario, 2) }}</td>
                            <td class="px-4 py-3 text-sm">
                                @if($producto->activo)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Activo</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm space-x-2">
                                <a href="{{ route('admin.productos.edit', $producto) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                                <form action="{{ route('admin.productos.destroy', $producto) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('¿Eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-400">No hay productos registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">{{ $productos->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>