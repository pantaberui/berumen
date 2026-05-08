<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Tipos de Servicio</h2>
            <a href="{{ route('admin.tipo-servicios.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nuevo Servicio
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($servicios as $servicio)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $servicio->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $servicio->nombre }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($servicio->activo)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Activo</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.tipo-servicios.edit', $servicio) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                                <form action="{{ route('admin.tipo-servicios.destroy', $servicio) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('¿Eliminar este servicio?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">
                                No hay servicios registrados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">
                    {{ $servicios->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>