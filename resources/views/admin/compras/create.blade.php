<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Registrar Compra a Proveedor</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if($errors->any())
                <div class="bg-red-100 text-red-800 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">
                <form action="{{ route('admin.compras.store') }}" method="POST" id="form_compra">
                    @csrf

                    {{-- Encabezado --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Proveedor *</label>
                            <select name="proveedor" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">— Selecciona —</option>
                                @foreach($proveedores as $key => $label)
                                    <option value="{{ $key }}" {{ old('proveedor') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Compra *</label>
                            <input type="date" name="fecha_compra"
                                   value="{{ old('fecha_compra', now()->format('Y-m-d')) }}"
                                   max="{{ now()->format('Y-m-d') }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <input type="text" name="observaciones"
                                   value="{{ old('observaciones') }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    {{-- Agregar producto --}}
                    <div class="border rounded-lg p-4 bg-gray-50 mb-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Agregar Producto</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Producto</label>
                                <select id="sel_producto" class="w-full border-gray-300 rounded-md shadow-sm text-sm"
                                        onchange="cargarUltimoPrecio(this)">
                                    <option value="">— Selecciona —</option>
                                    @foreach($productos as $p)
                                        <option value="{{ $p->id }}"
                                                data-descripcion="{{ $p->descripcion }}"
                                                data-clave="{{ $p->clave }}"
                                                data-stock="{{ $p->stock }}">
                                            {{ $p->clave }} — {{ $p->descripcion }}
                                            (Stock: {{ $p->stock }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Cantidad</label>
                                <input type="number" id="sel_cantidad" value="1" min="1"
                                       class="w-full border-gray-300 rounded-md shadow-sm text-sm"
                                       oninput="calcularPreviewTotal()">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">
                                    Precio Compra
                                    <span class="text-gray-400 font-normal" id="ultimo_precio_label"></span>
                                </label>
                                <input type="number" id="sel_precio" step="0.01" min="0"
                                       placeholder="0.00"
                                       class="w-full border-gray-300 rounded-md shadow-sm text-sm"
                                       oninput="calcularPreviewTotal()">
                            </div>
                        </div>
                        <div class="flex items-center gap-4 mt-3">
                            <span class="text-sm text-gray-500">
                                Total: <strong id="preview_total" class="text-green-700">$0.00</strong>
                            </span>
                            <button type="button" onclick="agregarProducto()"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">
                                + Agregar a la lista
                            </button>
                        </div>
                    </div>

                    {{-- Tabla de productos --}}
                    <div class="overflow-x-auto mb-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Clave</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stock actual</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acc.</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_compra">
                                <tr id="fila_vacia">
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-400 text-sm">
                                        Agrega productos usando el formulario de arriba
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50">
                                    <td colspan="5" class="px-4 py-3 text-right text-sm font-medium text-gray-700">Total general:</td>
                                    <td class="px-4 py-3 text-lg font-bold text-green-700" id="total_general">$0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="flex justify-end gap-3">
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
        let productosLista = [];
        let filaIndex = 0;

        function cargarUltimoPrecio(select) {
            const id = select.value;
            if (!id) {
                document.getElementById('ultimo_precio_label').textContent = '';
                document.getElementById('sel_precio').value = '';
                return;
            }

            fetch(`{{ route('admin.compras.ultimo-precio') }}?producto_id=${id}`)
                .then(r => r.json())
                .then(data => {
                    const label = document.getElementById('ultimo_precio_label');
                    const input = document.getElementById('sel_precio');
                    if (data.precio) {
                        input.value = parseFloat(data.precio).toFixed(2);
                        label.textContent = `(última: $${parseFloat(data.precio).toFixed(2)})`;
                    } else {
                        input.value = '';
                        label.textContent = '(sin compras previas)';
                    }
                    calcularPreviewTotal();
                });
        }

        function calcularPreviewTotal() {
            const cantidad = parseInt(document.getElementById('sel_cantidad').value) || 0;
            const precio   = parseFloat(document.getElementById('sel_precio').value) || 0;
            document.getElementById('preview_total').textContent = '$' + (cantidad * precio).toFixed(2);
        }

        function agregarProducto() {
            const select      = document.getElementById('sel_producto');
            const id          = select.value;
            const option      = select.options[select.selectedIndex];
            const descripcion = option?.dataset.descripcion;
            const clave       = option?.dataset.clave;
            const stock       = option?.dataset.stock;
            const cantidad    = parseInt(document.getElementById('sel_cantidad').value) || 0;
            const precio      = parseFloat(document.getElementById('sel_precio').value) || 0;

            if (!id)       { alert('Selecciona un producto.'); return; }
            if (cantidad < 1) { alert('La cantidad debe ser al menos 1.'); return; }
            if (precio <= 0)  { alert('Ingresa un precio de compra válido.'); return; }

            document.getElementById('fila_vacia')?.remove();

            const idx   = filaIndex++;
            const total = cantidad * precio;
            const fila  = document.createElement('tr');
            fila.id     = `fila_${idx}`;
            fila.className = 'hover:bg-gray-50';
            fila.innerHTML = `
                <td class="px-4 py-2 text-sm font-mono text-gray-500">${clave}
                    <input type="hidden" name="productos[${idx}][id]" value="${id}">
                </td>
                <td class="px-4 py-2 text-sm text-gray-700">${descripcion}</td>
                <td class="px-4 py-2 text-sm text-gray-400">${stock}</td>
                <td class="px-4 py-2 text-sm text-gray-500">${cantidad}
                    <input type="hidden" name="productos[${idx}][cantidad]" value="${cantidad}">
                </td>
                <td class="px-4 py-2 text-sm text-gray-500">$${precio.toFixed(2)}
                    <input type="hidden" name="productos[${idx}][precio]" value="${precio}">
                </td>
                <td class="px-4 py-2 text-sm font-medium text-gray-900">$${total.toFixed(2)}</td>
                <td class="px-4 py-2">
                    <button type="button" onclick="eliminarFila(${idx}, ${total})"
                            class="text-red-500 hover:text-red-700 text-lg">✕</button>
                </td>
            `;

            document.getElementById('tbody_compra').appendChild(fila);
            productosLista.push({ idx, total });
            actualizarTotal();

            // Limpiar selección
            select.value = '';
            document.getElementById('sel_cantidad').value = '1';
            document.getElementById('sel_precio').value   = '';
            document.getElementById('preview_total').textContent = '$0.00';
            document.getElementById('ultimo_precio_label').textContent = '';
        }

        function eliminarFila(idx, total) {
            document.getElementById(`fila_${idx}`)?.remove();
            productosLista = productosLista.filter(p => p.idx !== idx);
            if (productosLista.length === 0) {
                const fila = document.createElement('tr');
                fila.id = 'fila_vacia';
                fila.innerHTML = `<td colspan="7" class="px-4 py-6 text-center text-gray-400 text-sm">Agrega productos usando el formulario de arriba</td>`;
                document.getElementById('tbody_compra').appendChild(fila);
            }
            actualizarTotal();
        }

        function actualizarTotal() {
            const total = productosLista.reduce((sum, p) => sum + p.total, 0);
            document.getElementById('total_general').textContent = '$' + total.toFixed(2);
        }

        document.getElementById('form_compra').addEventListener('submit', function(e) {
            if (productosLista.length === 0) {
                e.preventDefault();
                alert('Agrega al menos un producto a la lista.');
            }
        });
    </script>
</x-app-layout>