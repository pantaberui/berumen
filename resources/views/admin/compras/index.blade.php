<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Compras a Proveedor</h2>
            <a href="{{ route('admin.compras.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Registrar Compra
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
                <form method="GET" action="{{ route('admin.compras.index') }}"
                      class="grid grid-cols-1 md:grid-cols-4 gap-3">
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
                        <label class="block text-xs font-medium text-gray-500 mb-1">Producto</label>
                        <select name="producto_id" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">— Todos —</option>
                            @foreach($productos as $p)
                                <option value="{{ $p->id }}" {{ request('producto_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->clave }} — {{ $p->descripcion }}
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
                            <a href="{{ route('admin.compras.index') }}"
                               class="py-2 px-3 bg-gray-200 text-gray-700 rounded text-sm">✕</a>
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
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Proveedor</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Productos</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>


                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($compras as $compra)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $compra->id }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700 font-medium">{{ $compra->proveedor ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                @foreach($compra->detalles as $detalle)
                                    <div class="text-xs">
                                        <span class="font-mono text-gray-400">{{ $detalle->producto->clave }}</span>
                                        {{ $detalle->producto->descripcion }}
                                        <span class="text-gray-400">x{{ $detalle->cantidad }}</span>
                                    </div>
                                @endforeach
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">${{ number_format($compra->total, 2) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $compra->usuario->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $compra->fecha_compra?->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-sm space-x-2">
                                <a href="{{ route('admin.compras.show', $compra) }}"
                                class="text-blue-600 hover:underline">Ver</a>
                                <form action="{{ route('admin.compras.destroy', $compra) }}"
                                    method="POST" class="inline"
                                    onsubmit="return confirm('¿Eliminar esta compra? Se revertirá el stock.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">No hay compras en el rango seleccionado.</td>
                        </tr>
                        @endforelse
                    </tbody>



                </table>
                <div class="px-6 py-4">{{ $compras->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>