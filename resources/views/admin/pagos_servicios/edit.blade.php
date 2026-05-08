<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Editar Pago #{{ str_pad($pagoServicio->id, 6, '0', STR_PAD_LEFT) }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                @if($errors->any())
                    <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-4 p-3 bg-gray-50 rounded text-sm grid grid-cols-2 gap-2">
                    <div><span class="font-medium text-gray-500">Servicio:</span> {{ $pagoServicio->tipoServicio->nombre }}</div>
                    <div><span class="font-medium text-gray-500">Cliente:</span> {{ $pagoServicio->cliente->nombre_completo }}</div>
                </div>

                <form action="{{ route('admin.pagos-servicios.update', $pagoServicio) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Referencia *</label>
                            <input type="text" name="referencia"
                                   value="{{ old('referencia', $pagoServicio->referencia) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Importe *</label>
                            <input type="number" name="importe" id="importe" step="0.01"
                                   value="{{ old('importe', $pagoServicio->importe) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="calcularTotal()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Comisión *</label>
                            <input type="number" name="comision" id="comision" step="0.01" min="10" max="100"
                                   value="{{ old('comision', $pagoServicio->comision) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="calcularTotal()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo de Pago *</label>
                            <select name="tipo_pago" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="efectivo"      {{ old('tipo_pago', $pagoServicio->tipo_pago) == 'efectivo'      ? 'selected' : '' }}>Efectivo</option>
                                <option value="transferencia" {{ old('tipo_pago', $pagoServicio->tipo_pago) == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                                <option value="tarjeta"       {{ old('tipo_pago', $pagoServicio->tipo_pago) == 'tarjeta'       ? 'selected' : '' }}>Tarjeta</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total</label>
                            <div id="total_display"
                                 class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 font-bold text-green-700">
                                ${{ number_format($pagoServicio->total, 2) }}
                            </div>
                        </div>

                        {{-- Cancelación solo admin --}}
                        @if(auth()->user()->hasRole('admin'))
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Estatus</label>
                            <select name="estatus" id="estatus"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="pagado"    {{ old('estatus', $pagoServicio->estatus) == 'pagado'    ? 'selected' : '' }}>Pagado</option>
                                <option value="cancelado" {{ old('estatus', $pagoServicio->estatus) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            @if($pagoServicio->estatus === 'cancelado')
                                <p class="text-xs text-red-600 mt-1">
                                    Cancelado el {{ $pagoServicio->fecha_hora_cancelacion?->format('d/m/Y H:i') }}
                                    por {{ $pagoServicio->canceladoPor?->name }}
                                </p>
                            @endif
                        </div>
                        @endif

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observaciones" rows="2"
                                      class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('observaciones', $pagoServicio->observaciones) }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.pagos-servicios.show', $pagoServicio) }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancelar</a>
                        <button type="submit"
                                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function calcularTotal() {
            const importe  = parseFloat(document.getElementById('importe').value) || 0;
            const comision = parseFloat(document.getElementById('comision').value) || 0;
            document.getElementById('total_display').textContent = '$' + (importe + comision).toFixed(2);
        }
    </script>
</x-app-layout>