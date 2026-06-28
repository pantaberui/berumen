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

            @if($incidencia->estatus === 'atendido' && isset($contrato))
            <button onclick="abrirModalDias()"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                📅 Agregar Días de Servicio
            </button>
            @endif

            {{-- Modal Agregar Días --}}
            <div id="modal_dias" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-sm mx-4">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">📅 Agregar Días de Servicio</h3>
                    <form action="{{ route('admin.incidencias.agregar-dias', $incidencia) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Días a agregar (máx. 30)</label>
                            <input type="number" name="dias" min="1" max="30" required
                                class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <textarea name="descripcion_extra" rows="2" required
                                    class="w-full border-gray-300 rounded-md shadow-sm text-sm"
                                    placeholder="Motivo de la reposición de días..."></textarea>
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="cerrarModalDias()"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm">Cancelar</button>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded text-sm">Agregar Días</button>
                        </div>
                    </form>
                </div>
            </div>




        </div>
    </div>

                   
    


    <script>
        function abrirModalDias()  { document.getElementById('modal_dias').classList.remove('hidden'); }
        function cerrarModalDias() { document.getElementById('modal_dias').classList.add('hidden'); }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarModalDias(); });
    </script>
</x-app-layout>

