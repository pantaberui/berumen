<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Incidencia #{{ $incidencia->id }} — {{ $incidencia->titulo }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('admin.incidencias.edit', $incidencia) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
                <a href="{{ route('admin.incidencias.index') }}"
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Volver</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6 space-y-4 text-sm">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="font-medium text-gray-500">Cliente</span>
                        <p>
                            <a href="{{ route('admin.clientes.show', $incidencia->cliente) }}"
                               class="text-blue-600 hover:underline">
                                {{ $incidencia->cliente->nombre_completo }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-500">Estatus</span>
                        <p class="mt-1">
                            @if($incidencia->estatus === 'en_espera')
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">En Espera</span>
                            @elseif($incidencia->estatus === 'en_atencion')
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">En Atención</span>
                            @else
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Atendido</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-500">Registrado por</span>
                        <p>{{ $incidencia->usuario->name }}</p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-500">Fecha registro</span>
                        <p>{{ $incidencia->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @if($incidencia->fecha_atencion)
                    <div>
                        <span class="font-medium text-gray-500">Fecha atención</span>
                        <p>{{ $incidencia->fecha_atencion->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>

                <div>
                    <span class="font-medium text-gray-500">Descripción</span>
                    <p class="mt-1 p-3 bg-gray-50 rounded">{{ $incidencia->descripcion }}</p>
                </div>

                @if($incidencia->solucion)
                <div>
                    <span class="font-medium text-gray-500">Solución</span>
                    <p class="mt-1 p-3 bg-green-50 rounded">{{ $incidencia->solucion }}</p>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>