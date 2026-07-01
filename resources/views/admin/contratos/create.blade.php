<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nuevo Contrato</h2>
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

                <form action="{{ route('admin.contratos.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="md:col-span-2">
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
                            <label class="block text-sm font-medium text-gray-700">Número de Contrato *</label>
                            <input type="text" name="numero_contrato"
                                   value="{{ old('numero_contrato', $numero) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Inicio *</label>
                            <input type="date" name="fecha_inicio"
                                   value="{{ old('fecha_inicio', date('Y-m-d')) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mensualidad *</label>
                            <input type="number" name="mensualidad" step="0.01"
                                   value="{{ old('mensualidad') }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Red</label>
                            <input type="text" name="velocidad" placeholder="Ej: 10MB, 20MB"
                                   value="{{ old('velocidad') }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dirección IP</label>
                            <input type="text" name="ip" id="ip"
                                value="{{ old('ip') }}"
                                placeholder="192.168.001.001"
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                maxlength="15">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estatus *</label>
                            <select name="estatus" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="activo" {{ old('estatus') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="adeudo" {{ old('estatus') == 'adeudo' ? 'selected' : '' }}>Adeudo</option>
                                <option value="cancelado" {{ old('estatus') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observaciones" rows="3"
                                      class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('observaciones') }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.contratos.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Guardar Contrato
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