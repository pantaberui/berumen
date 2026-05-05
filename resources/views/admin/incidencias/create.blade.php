<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nueva Incidencia</h2>
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

                <form action="{{ route('admin.incidencias.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cliente *</label>
                            <select name="cliente_id" id="cliente_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">— Selecciona un cliente —</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}"
                                        {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Título *</label>
                            <input type="text" name="titulo" value="{{ old('titulo') }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="this.value = this.value.toUpperCase()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descripción *</label>
                            <textarea name="descripcion" rows="4"
                                      class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                      oninput="this.value = this.value.toUpperCase()">{{ old('descripcion') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estatus *</label>
                            <select name="estatus" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="en_espera"   {{ old('estatus') == 'en_espera'   ? 'selected' : '' }}>En Espera</option>
                                <option value="en_atencion" {{ old('estatus') == 'en_atencion' ? 'selected' : '' }}>En Atención</option>
                                <option value="atendido"    {{ old('estatus') == 'atendido'    ? 'selected' : '' }}>Atendido</option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.incidencias.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Guardar Incidencia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        new TomSelect('#cliente_id', {
            searchField: ['text'],
            placeholder: '— Busca por nombre de cliente —',
            maxOptions: 50,
        });
    </script>
</x-app-layout>