<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar Pago #{{ $pago->id }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form action="{{ route('admin.pagos.update', $pago) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="md:col-span-2 p-3 bg-gray-50 rounded text-sm">
                            <span class="font-medium">Contrato:</span>
                            {{ $pago->contrato->numero_contrato }} —
                            {{ $pago->contrato->cliente->nombre_completo }}
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Pago *</label>
                            <input type="date" name="fecha_pago"
                                   value="{{ old('fecha_pago', $pago->fecha_pago->format('Y-m-d')) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo de Pago *</label>
                            <select name="tipo_pago" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="efectivo"      {{ old('tipo_pago', $pago->tipo_pago) == 'efectivo'      ? 'selected' : '' }}>Efectivo</option>
                                <option value="transferencia" {{ old('tipo_pago', $pago->tipo_pago) == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                                <option value="tarjeta"       {{ old('tipo_pago', $pago->tipo_pago) == 'tarjeta'       ? 'selected' : '' }}>Tarjeta</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Periodo Desde *</label>
                            <input type="date" name="periodo_desde"
                                   value="{{ old('periodo_desde', $pago->periodo_desde->format('Y-m-d')) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Periodo Hasta *</label>
                            <input type="date" name="periodo_hasta"
                                   value="{{ old('periodo_hasta', $pago->periodo_hasta->format('Y-m-d')) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Importe *</label>
                            <input type="number" name="importe" id="importe" step="0.01"
                                   value="{{ old('importe', $pago->importe) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="calcularTotal()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descuento</label>
                            <input type="number" name="descuento" id="descuento" step="0.01"
                                   value="{{ old('descuento', $pago->descuento) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="calcularTotal()">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Total</label>
                            <div id="total_display"
                                 class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 font-bold text-lg text-green-700">
                                ${{ number_format($pago->total, 2) }}
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observaciones" rows="2"
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                oninput="this.value = this.value.toUpperCase()">{{ old('observaciones') }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.pagos.show', $pago) }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancelar</a>
                        <button type="submit"
                                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Actualizar Pago
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function calcularTotal() {
            const importe   = parseFloat(document.getElementById('importe').value) || 0;
            const descuento = parseFloat(document.getElementById('descuento').value) || 0;
            document.getElementById('total_display').textContent = '$' + (importe - descuento).toFixed(2);
        }
    </script>
</x-app-layout>