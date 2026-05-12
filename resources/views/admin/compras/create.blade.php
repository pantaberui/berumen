<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Registrar Compra a Proveedor</h2>
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

                <form action="{{ route('admin.compras.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Producto *</label>
                            <select name="producto_id" id="producto_select"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">— Selecciona un producto —</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}"
                                            data-stock="{{ $producto->stock }}"
                                        {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                        {{ $producto->clave }} — {{ $producto->descripcion }}
                                        (Stock actual: {{ $producto->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cantidad *</label>
                            <input type="number" name="cantidad" id="cantidad" min="1"
                                   value="{{ old('cantidad', 1) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="calcularTotal()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Precio de Compra *</label>
                            <input type="number" name="precio_compra" id="precio_compra" step="0.01" min="0"
                                   value="{{ old('precio_compra') }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="calcularTotal()">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Total</label>
                            <div id="total_display"
                                 class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 font-bold text-lg text-green-700">
                                $0.00
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observaciones" rows="2"
                                      class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('observaciones') }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.compras.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancelar</a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Registrar Compra
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        new TomSelect('#producto_select', {
            searchField: ['text'],
            placeholder: '— Busca por clave o descripción —',
        });

        function calcularTotal() {
            const cantidad = parseFloat(document.getElementById('cantidad').value) || 0;
            const precio   = parseFloat(document.getElementById('precio_compra').value) || 0;
            document.getElementById('total_display').textContent = '$' + (cantidad * precio).toFixed(2);
        }
    </script>
</x-app-layout>