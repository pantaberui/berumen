<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Editar Trámite #{{ str_pad($tramite->id, 6, '0', STR_PAD_LEFT) }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                @if($errors->any())
                    <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-4 p-3 bg-gray-50 rounded text-sm grid grid-cols-2 gap-2">
                    <div><span class="font-medium text-gray-500">Trámite:</span> {{ $tramite->tipoTramite->nombre }}</div>
                    <div><span class="font-medium text-gray-500">Cliente:</span> {{ $tramite->cliente_nombre }}</div>
                </div>

                <form action="{{ route('admin.tramites.update', $tramite) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cantidad *</label>
                            <input type="number" name="cantidad" id="cantidad" min="1"
                                   value="{{ old('cantidad', $tramite->cantidad) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="calcularSubtotal()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Importe *</label>
                            <input type="number" name="importe" id="importe" step="0.01" min="0"
                                   value="{{ old('importe', $tramite->importe) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="calcularSubtotal()">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Subtotal</label>
                            <div id="subtotal_display"
                                 class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 font-bold text-lg text-green-700">
                                ${{ number_format($tramite->subtotal, 2) }}
                            </div>
                        </div>

                        @if(auth()->user()->hasRole('admin'))
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Estatus</label>
                            <select name="estatus" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="cobrado"   {{ $tramite->estatus == 'cobrado'   ? 'selected' : '' }}>Cobrado</option>
                                <option value="cancelado" {{ $tramite->estatus == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            @if($tramite->estatus === 'cancelado')
                                <p class="text-xs text-red-600 mt-1">
                                    Cancelado el {{ $tramite->fecha_hora_cancelacion?->format('d/m/Y H:i') }}
                                    por {{ $tramite->canceladoPor?->name }}
                                </p>
                            @endif
                        </div>
                        @else
                            <input type="hidden" name="estatus" value="{{ $tramite->estatus }}">
                        @endif

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observaciones" rows="2"
                                      class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('observaciones', $tramite->observaciones) }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.tramites.show', $tramite) }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancelar</a>
                        <button type="submit"
                                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function calcularSubtotal() {
            const importe  = parseFloat(document.getElementById('importe').value) || 0;
            const cantidad = parseInt(document.getElementById('cantidad').value) || 1;
            document.getElementById('subtotal_display').textContent = '$' + (importe * cantidad).toFixed(2);
        }
    </script>
</x-app-layout>