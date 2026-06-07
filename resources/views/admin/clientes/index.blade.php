<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Clientes</h2>

            
            <form method="GET" action="{{ route('admin.clientes.index') }}" class="flex gap-2 items-center">
                {{-- ... inputs existentes ... --}}
                <select name="por_pagina" onchange="this.form.submit()"
                        class="border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="15"  {{ $porPagina == 15  ? 'selected' : '' }}>15 por página</option>
                    <option value="25"  {{ $porPagina == 25  ? 'selected' : '' }}>25 por página</option>
                    <option value="50"  {{ $porPagina == 50  ? 'selected' : '' }}>50 por página</option>
                    <option value="100" {{ $porPagina == 100 ? 'selected' : '' }}>100 por página</option>
                </select>
            </form>



            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('admin.clientes.index') }}" class="flex gap-2">
                    <input type="text" name="q" value="{{ $busqueda ?? '' }}"
                           placeholder="Buscar nombre, apellido, CURP, RFC..."
                           class="border-gray-300 rounded-md shadow-sm text-sm w-64"
                           minlength="3">
                    <button type="submit"
                            class="px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">
                        Buscar
                    </button>
                    @if(!empty($busqueda))
                        <a href="{{ route('admin.clientes.index') }}"
                           class="px-3 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">
                            ✕ Limpiar
                        </a>
                    @endif
                </form>
                <a href="{{ route('admin.clientes.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Nuevo Cliente
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

                            {{-- Columnas ordenables --}}
                            @php
                                $cols = [
                                    'nombre'           => 'Nombre',
                                    'apellido_paterno' => 'Apellido Paterno',
                                    'apellido_materno' => 'Apellido Materno',
                                ];
                            @endphp

                            @foreach($cols as $col => $label)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                <a href="{{ route('admin.clientes.index', array_merge(request()->query(), [
                                        'orden' => $col,
                                        'dir'   => ($orden === $col && $direccion === 'asc') ? 'desc' : 'asc',
                                        'q'     => $busqueda ?? '',
                                    ])) }}"
                                   class="flex items-center gap-1 hover:text-gray-700">
                                    {{ $label }}
                                    @if($orden === $col)
                                        {{ $direccion === 'asc' ? '↑' : '↓' }}
                                    @else
                                        <span class="text-gray-300">↕</span>
                                    @endif
                                </a>
                            </th>
                            @endforeach

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teléfono</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Celular</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ciudad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($clientes as $cliente)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $cliente->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $cliente->nombre }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $cliente->apellido_paterno }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $cliente->apellido_materno ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $cliente->telefono ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $cliente->celular ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $cliente->ciudad ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($cliente->activo)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Activo</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.clientes.show', $cliente) }}"
                                   class="text-blue-600 hover:underline">Ver</a>
                                <a href="{{ route('admin.clientes.edit', $cliente) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                                <form action="{{ route('admin.clientes.destroy', $cliente) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('¿Eliminar este cliente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-400">
                                @if(!empty($busqueda))
                                    No se encontraron clientes con "{{ $busqueda }}".
                                @else
                                    No hay clientes registrados aún.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">
                    {{ $clientes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>