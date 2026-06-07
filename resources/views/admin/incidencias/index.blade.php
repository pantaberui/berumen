<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Incidencias</h2>
            <div class="flex items-center gap-3">
                <form action="{{ route('admin.incidencias.buscar') }}" method="GET" class="flex gap-2">
                    <input type="text" name="q" value="{{ $busqueda ?? '' }}"
                        placeholder="Buscar por nombre..."
                        class="border-gray-300 rounded-md shadow-sm text-sm"
                        minlength="3">
                    <button type="submit"
                            class="px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">
                        Buscar
                    </button>
                    @if(!empty($busqueda))
                        <a href="{{ route('admin.incidencias.index') }}"
                        class="px-3 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">
                            ✕ Limpiar
                        </a>
                    @endif
                </form>
                <a href="{{ route('admin.incidencias.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Nueva Incidencia
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registrado por</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($incidencias as $incidencia)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $incidencia->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $incidencia->cliente->nombre_completo }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $incidencia->titulo }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($incidencia->estatus === 'en_espera')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">En Espera</span>
                                @elseif($incidencia->estatus === 'en_atencion')
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">En Atención</span>
                                @else
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Atendido</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $incidencia->usuario->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $incidencia->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.incidencias.show', $incidencia) }}"
                                   class="text-blue-600 hover:underline">Ver</a>
                                <a href="{{ route('admin.incidencias.edit', $incidencia) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                                <form action="{{ route('admin.incidencias.destroy', $incidencia) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('¿Eliminar esta incidencia?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                No hay incidencias registradas aún.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">
                    {{ $incidencias->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>