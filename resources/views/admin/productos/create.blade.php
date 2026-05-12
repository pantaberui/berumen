<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nuevo Producto / Servicio</h2>
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

                <form action="{{ route('admin.productos.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Clave *</label>
                            <input type="text" name="clave" value="{{ old('clave') }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   maxlength="20" placeholder="Ej: MEMSD">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Categoría *</label>
                            <select name="categoria" id="categoria"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                    onchange="toggleStock()">
                                <option value="producto" {{ old('categoria') == 'producto' ? 'selected' : '' }}>Producto</option>
                                <option value="servicio" {{ old('categoria') == 'servicio' ? 'selected' : '' }}>Servicio</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Descripción *</label>
                            <input type="text" name="descripcion" value="{{ old('descripcion') }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   maxlength="200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Precio Unitario *</label>
                            <input type="number" name="precio_unitario" step="0.01" min="0"
                                   value="{{ old('precio_unitario') }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div id="div_stock">
                            <label class="block text-sm font-medium text-gray-700">Stock Inicial</label>
                            <input type="number" name="stock" min="0"
                                   value="{{ old('stock', 0) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div id="div_stock_minimo">
                            <label class="block text-sm font-medium text-gray-700">Stock Mínimo</label>
                            <input type="number" name="stock_minimo" min="0"
                                   value="{{ old('stock_minimo', 0) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="flex items-center mt-2">
                            <input type="checkbox" name="activo" value="1" id="activo" checked
                                   class="rounded border-gray-300 text-blue-600">
                            <label for="activo" class="ml-2 text-sm text-gray-700">Activo</label>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.productos.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancelar</a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleStock() {
            const cat = document.getElementById('categoria').value;
            const show = cat === 'producto';
            document.getElementById('div_stock').style.display = show ? '' : 'none';
            document.getElementById('div_stock_minimo').style.display = show ? '' : 'none';
        }
        toggleStock();
    </script>
</x-app-layout>