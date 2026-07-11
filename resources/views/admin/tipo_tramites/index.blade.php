<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Tipos de Trámite</h2>
            <a href="{{ route('admin.tipo-tramites.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nuevo Tipo
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Requisitos</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio Sugerido</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tramites as $tramite)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $tramite->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $tramite->tipo ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $tramite->nombre }}</td>
                            <td class="PX-6 py-4 text-sm text-gray-500">{{ $tramite->requisitos ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $tramite->precio_sugerido ? '$'.number_format($tramite->precio_sugerido, 2) : '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($tramite->activo)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Activo</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.tipo-tramites.edit', $tramite) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                                <form action="{{ route('admin.tipo-tramites.destroy', $tramite) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('¿Eliminar?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">No hay tipos de trámite.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">{{ $tramites->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>