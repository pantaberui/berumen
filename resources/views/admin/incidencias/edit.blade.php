<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar Incidencia #{{ $incidencia->id }}</h2>
    </x-slot>


    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                @if($errors->any())
                    <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.incidencias.update', $incidencia) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cliente *</label>
                            <select name="cliente_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}"
                                        {{ old('cliente_id', $incidencia->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Título *</label>
                            <input type="text" name="titulo"
                                   value="{{ old('titulo', $incidencia->titulo) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="this.value = this.value.toUpperCase()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descripción *</label>
                            <textarea name="descripcion" rows="4"
                                      class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                      oninput="this.value = this.value.toUpperCase()">{{ old('descripcion', $incidencia->descripcion) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estatus *</label>
                            <select name="estatus" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="en_espera"   {{ old('estatus', $incidencia->estatus) == 'en_espera'   ? 'selected' : '' }}>En Espera</option>
                                <option value="en_atencion" {{ old('estatus', $incidencia->estatus) == 'en_atencion' ? 'selected' : '' }}>En Atención</option>
                                <option value="atendido"    {{ old('estatus', $incidencia->estatus) == 'atendido'    ? 'selected' : '' }}>Atendido</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Atención</label>
                            <input type="datetime-local" name="fecha_atencion" id="fecha_atencion"
                                value="{{ old('fecha_atencion', $incidencia->fecha_atencion?->format('Y-m-d\TH:i')) }}"
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Solución</label>
                            <textarea name="solucion" rows="3"
                                      class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                      oninput="this.value = this.value.toUpperCase()">{{ old('solucion', $incidencia->solucion) }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.incidencias.show', $incidencia) }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Actualizar Incidencia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const campo = document.getElementById('fecha_atencion');
            // Solo pone la fecha actual si el campo está vacío
            if (!campo.value) {
                const ahora = new Date();
                const y = ahora.getFullYear();
                const m = String(ahora.getMonth() + 1).padStart(2, '0');
                const d = String(ahora.getDate()).padStart(2, '0');
                const h = String(ahora.getHours()).padStart(2, '0');
                const min = String(ahora.getMinutes()).padStart(2, '0');
                campo.value = `${y}-${m}-${d}T${h}:${min}`;
            }
        });
    </script>
</x-app-layout>