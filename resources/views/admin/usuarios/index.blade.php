<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Usuarios</h2>
            <a href="{{ route('admin.usuarios.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nuevo Usuario
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Apellido</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Correo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Celular</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($usuarios as $usuario)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $usuario->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $usuario->apellido_paterno }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $usuario->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $usuario->celular ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm">
                                @foreach($usuario->roles as $rol)
                                    <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full text-xs capitalize">
                                        {{ $rol->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.usuarios.edit', $usuario) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                                @if($usuario->id !== auth()->id())
                                <form action="{{ route('admin.usuarios.destroy', $usuario) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('¿Eliminar este usuario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">No hay usuarios registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">{{ $usuarios->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>