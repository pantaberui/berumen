<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar Compra #{{ $compra->id }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="mb-4 p-3 bg-gray-50 rounded text-sm">
                    <span class="font-medium text-gray-500">Producto:</span>
                    {{ $compra->producto->clave }} — {{ $compra->producto->descripcion }}
                    (Stock actual: {{ $compra->producto->stock }})
                </div>

                <form action="{{ route('admin.compras.update', $compra) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cantidad *</label>
                            <input type="number" name="cantidad" id="cantidad" min="1"
                                   value="{{ old('cantidad', $compra->cantidad) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="calcularTotal()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Precio de Compra *</label>
                            <input type="number" name="precio_compra" id="precio_compra" step="0.01"
                                   value="{{ old('precio_compra', $compra->precio_compra) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="calcularTotal()">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Total</label>
                            <div id="total_display"
                                 class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 font-bold text-lg text-green-700">
                                ${{ number_format($compra->total, 2) }}
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observaciones" rows="2"
                                      class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('observaciones', $compra->observaciones) }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.compras.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancelar</a>
                        <button type="submit"
                                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function calcularTotal() {
            const cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
            const precio   = parseFloat(document.getElementById('precio_compra').value) || 0;
            document.getElementById('total_display').textContent = '$' + (cantidad * precio).toFixed(2);
        }
    </script>
</x-app-layout>