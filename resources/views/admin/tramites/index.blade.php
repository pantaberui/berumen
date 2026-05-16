<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Trámites</h2>
            <a href="{{ route('admin.tramites.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nuevo Trámite
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
                <form method="GET" action="{{ route('admin.tramites.index') }}"
                      class="grid grid-cols-1 md:grid-cols-5 gap-3">
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
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tipo de Trámite</label>
                        <select name="tipo_tramite_id" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">— Todos —</option>
                            @foreach($tiposTramite as $tipo)
                                <option value="{{ $tipo->id }}"
                                    {{ request('tipo_tramite_id') == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nombre }}
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
                                    {{ request('user_id') == $usuario->id ? 'selected' : '' }}>
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
                            <a href="{{ route('admin.tramites.index') }}"
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
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Folio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trámite</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cant.</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Importe</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cajero</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tramites as $tramite)
                        <tr class="hover:bg-gray-50 {{ $tramite->estatus === 'cancelado' ? 'opacity-60' : '' }}">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                #{{ str_pad($tramite->id, 6, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $tramite->tipoTramite->nombre }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $tramite->cliente_nombre }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $tramite->cantidad }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">${{ number_format($tramite->importe, 2) }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">${{ number_format($tramite->subtotal, 2) }}</td>
                            <td class="px-4 py-3 text-sm">
                                @if($tramite->estatus === 'cobrado')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Cobrado</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Cancelado</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $tramite->cajero->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $tramite->fecha_hora_cobro?->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 text-sm space-x-2">
                                <a href="{{ route('admin.tramites.show', $tramite) }}"
                                   class="text-blue-600 hover:underline">Ver</a>
                                <a href="{{ route('admin.tramites.edit', $tramite) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="px-6 py-8 text-center text-gray-400">
                                No hay trámites en el rango seleccionado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">{{ $tramites->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>