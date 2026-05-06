<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Editar Contrato — {{ $contrato->numero_contrato }}
        </h2>
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

                <form action="{{ route('admin.contratos.update', $contrato) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Cliente *</label>
                            <select name="cliente_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}"
                                        {{ old('cliente_id', $contrato->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Número de Contrato *</label>
                            <input type="text" name="numero_contrato"
                                   value="{{ old('numero_contrato', $contrato->numero_contrato) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Inicio *</label>
                            <input type="date" name="fecha_inicio"
                                   value="{{ old('fecha_inicio', $contrato->fecha_inicio->format('Y-m-d')) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mensualidad *</label>
                            <input type="number" name="mensualidad" step="0.01"
                                   value="{{ old('mensualidad', $contrato->mensualidad) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Velocidad</label>
                            <input type="text" name="velocidad"
                                   value="{{ old('velocidad', $contrato->velocidad) }}"
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
                            <select name="estatus" id="estatus" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="activo"    {{ old('estatus', $contrato->estatus) == 'activo'    ? 'selected' : '' }}>Activo</option>
                                <option value="adeudo"    {{ old('estatus', $contrato->estatus) == 'adeudo'    ? 'selected' : '' }}>Adeudo</option>
                                <option value="cancelado" {{ old('estatus', $contrato->estatus) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>

                        <div id="div_fecha_cancelacion" class="{{ old('estatus', $contrato->estatus) == 'cancelado' ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700">Fecha de Cancelación *</label>
                            <input type="date" name="fecha_cancelacion" id="fecha_cancelacion"
                                value="{{ old('fecha_cancelacion', $contrato->fecha_cancelacion?->format('Y-m-d')) }}"
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observaciones" rows="3"
                                      class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('observaciones', $contrato->observaciones) }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.contratos.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Actualizar Contrato
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('estatus').addEventListener('change', function () {
            const div = document.getElementById('div_fecha_cancelacion');
            const campo = document.getElementById('fecha_cancelacion');
            if (this.value === 'cancelado') {
                div.classList.remove('hidden');
                // Poner fecha actual si está vacío
                if (!campo.value) {
                    const hoy = new Date();
                    const y = hoy.getFullYear();
                    const m = String(hoy.getMonth() + 1).padStart(2, '0');
                    const d = String(hoy.getDate()).padStart(2, '0');
                    campo.value = `${y}-${m}-${d}`;
                }
            } else {
                div.classList.add('hidden');
                campo.value = '';
            }
        });
    </script>
</x-app-layout>