<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nueva Venta</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if($errors->has('stock'))
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-4">
                    ⚠️ {{ $errors->first('stock') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">
                <form action="{{ route('admin.ventas.store') }}" method="POST" id="form_venta">
                    @csrf

                    {{-- Cliente --}}
                    <div class="mb-4">
                        <h3 class="text-base font-medium text-gray-800 mb-3">Cliente</h3>
                        <div class="flex gap-3 items-center">
                            <input type="text" id="buscar_cliente"
                                   placeholder="Buscar cliente (mín. 3 letras)..."
                                   class="flex-1 border-gray-300 rounded-md shadow-sm text-sm">
                            <button type="button" onclick="buscarCliente()"
                                    class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">
                                Buscar
                            </button>
                            <button type="button" onclick="usarPublicoGeneral()"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">
                                Público en General
                            </button>
                        </div>

                        <div id="resultados_clientes" class="mt-2 hidden"></div>

                        <input type="hidden" name="cliente_id" id="cliente_id_input">
                        <input type="hidden" name="cliente_nombre" id="cliente_nombre_input" value="PÚBLICO EN GENERAL">

                        <div id="cliente_badge" class="mt-2 inline-flex items-center gap-2 bg-blue-50 border border-blue-200 rounded px-3 py-2 text-sm text-blue-800">
                            👤 <span id="cliente_badge_nombre">PÚBLICO EN GENERAL</span>
                            <button type="button" onclick="limpiarCliente()" class="text-blue-400 hover:text-blue-600 ml-1">✕</button>
                        </div>
                    </div>

                    {{-- Venta rápida --}}
                    <div class="mb-4 border rounded-lg p-4 bg-indigo-50">
                        <h3 class="text-sm font-medium text-indigo-800 mb-2">
                            ⚡ Venta Rápida
                            <span class="text-xs font-normal text-indigo-500 ml-1">
                                Formato: cantidad+CLAVE (ej: 3DOR+RCH+5CPN)
                            </span>
                        </h3>
                        <div class="flex gap-3">
                            <input type="text" id="venta_rapida_input"
                                placeholder="Ej: 3DOR+RCH+5CPN"
                                class="flex-1 border-indigo-300 rounded-md shadow-sm text-sm bg-white"
                                onkeypress="if(event.key==='Enter'){event.preventDefault();procesarVentaRapida();}">
                            <button type="button" onclick="procesarVentaRapida()"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">
                                ⚡ Agregar
                            </button>
                        </div>
                        <div id="errores_venta_rapida" class="hidden mt-2 bg-red-50 border border-red-200 rounded p-2 text-sm text-red-700"></div>
                    </div>



                    {{-- Buscador de productos --}}
                    <div class="mb-4 border-t pt-4">
                        <h3 class="text-base font-medium text-gray-800 mb-3">Agregar Producto / Servicio</h3>
                        <div class="flex gap-3">
                            <input type="text" id="buscar_producto"
                                   placeholder="Buscar por clave o descripción..."
                                   class="flex-1 border-gray-300 rounded-md shadow-sm text-sm">
                            <button type="button" onclick="buscarProducto()"
                                    class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">
                                Buscar
                            </button>
                        </div>
                        <div id="resultados_productos" class="mt-2 hidden"></div>
                    </div>

                    {{-- Tabla de productos en la venta --}}
                    <div class="border-t pt-4">
                        <h3 class="text-base font-medium text-gray-800 mb-3">Detalle de la Venta</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200" id="tabla_venta">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Clave</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Descuento</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acc.</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_venta">
                                    <tr id="fila_vacia">
                                        <td colspan="7" class="px-4 py-6 text-center text-gray-400 text-sm">
                                            Agrega productos o servicios usando el buscador
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray-50">
                                        <td colspan="4" class="px-4 py-3 text-right text-sm font-medium text-gray-700">Total:</td>
                                        <td class="px-4 py-3 text-sm text-red-600" id="total_descuentos">-$0.00</td>
                                        <td class="px-4 py-3 text-lg font-bold text-green-700" id="total_venta">$0.00</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="px-4 py-2 text-sm text-gray-500 italic" id="total_letras"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- Tipo de pago y observaciones --}}
                    <div class="border-t pt-4 mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo de Pago *</label>
                            <select name="tipo_pago" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="efectivo">Efectivo</option>
                                <option value="transferencia">Transferencia</option>
                                <option value="tarjeta">Tarjeta</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observaciones" rows="2"
                                      class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('observaciones') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.ventas.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancelar</a>
                        <button type="button" onclick="confirmarVenta()"
                                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
                            Registrar Venta
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        let productosVenta = [];
        let filaIndex = 0;

        // ---- Cliente ----
        document.getElementById('buscar_cliente').addEventListener('keypress', e => {
            if (e.key === 'Enter') { e.preventDefault(); buscarCliente(); }
        });

        function buscarCliente() {
            const termino = document.getElementById('buscar_cliente').value.trim();
            if (termino.length < 3) { alert('Escribe al menos 3 caracteres.'); return; }

            fetch(`{{ route('admin.ventas.buscar-cliente') }}?q=${encodeURIComponent(termino)}`)
                .then(r => r.json())
                .then(clientes => {
                    const div = document.getElementById('resultados_clientes');
                    div.classList.remove('hidden');

                    if (clientes.length === 0) {
                        div.innerHTML = `<div class="bg-yellow-50 border border-yellow-200 rounded p-3 text-sm text-yellow-700">
                            No se encontró ningún cliente. Se usará Público en General.
                        </div>`;
                        return;
                    }

                    div.innerHTML = `<div class="space-y-1 max-h-40 overflow-y-auto">
                        ${clientes.map(c => `
                            <div class="flex items-center justify-between border rounded p-2 hover:bg-blue-50 cursor-pointer text-sm"
                                 onclick="seleccionarCliente(${c.id}, '${c.nombre} ${c.apellido_paterno} ${c.apellido_materno ?? ''}')">
                                <span>${c.nombre} ${c.apellido_paterno} ${c.apellido_materno ?? ''}</span>
                                <span class="text-blue-600 text-xs">Seleccionar →</span>
                            </div>
                        `).join('')}
                    </div>`;
                });
        }

        function seleccionarCliente(id, nombre) {
            document.getElementById('cliente_id_input').value = id;
            document.getElementById('cliente_nombre_input').value = nombre.trim().toUpperCase();
            document.getElementById('cliente_badge_nombre').textContent = nombre.trim().toUpperCase();
            document.getElementById('resultados_clientes').classList.add('hidden');
            document.getElementById('buscar_cliente').value = '';
        }

        function usarPublicoGeneral() {
            limpiarCliente();
        }

        function limpiarCliente() {
            document.getElementById('cliente_id_input').value = '';
            document.getElementById('cliente_nombre_input').value = 'PÚBLICO EN GENERAL';
            document.getElementById('cliente_badge_nombre').textContent = 'PÚBLICO EN GENERAL';
            document.getElementById('resultados_clientes').classList.add('hidden');
            document.getElementById('buscar_cliente').value = '';
        }

        function procesarVentaRapida() {
        const input  = document.getElementById('venta_rapida_input').value.trim().toUpperCase();
        const errDiv = document.getElementById('errores_venta_rapida');

        if (!input) return;

        // Separar por +
        const partes  = input.split('+').filter(p => p.trim());
        const errores = [];
        const validos = [];

        // Procesar cada parte
        const promesas = partes.map(parte => {
            // Detectar cantidad al inicio (ej: 3DOR → cantidad=3, clave=DOR)
            const match    = parte.match(/^(\d+)?([A-Z0-9]+)$/);
            if (!match) {
                errores.push(`"${parte}" — formato inválido`);
                return Promise.resolve(null);
            }

            const cantidad = parseInt(match[1] || '1');
            const clave    = match[2];

            return fetch(`{{ route('admin.ventas.buscar-producto') }}?q=${encodeURIComponent(clave)}`)
                .then(r => r.json())
                .then(productos => {
                    // Buscar coincidencia exacta por clave
                    const producto = productos.find(p =>
                        p.clave.toUpperCase() === clave.toUpperCase()
                    );

                    if (!producto) {
                        errores.push(`Clave "${clave}" — no encontrada`);
                        return null;
                    }

                    return { producto, cantidad };
                });
        });

        Promise.all(promesas).then(resultados => {
            // Mostrar errores
            if (errores.length > 0) {
                errDiv.classList.remove('hidden');
                errDiv.innerHTML = '⚠️ ' + errores.join(' | ');
            } else {
                errDiv.classList.add('hidden');
            }

            // Agregar los válidos a la tabla
            resultados.forEach(r => {
                if (r) {
                    agregarProducto(
                        r.producto.id,
                        r.producto.clave,
                        r.producto.descripcion,
                        r.producto.precio_unitario,
                        r.producto.categoria,
                        r.producto.stock,
                        r.cantidad
                    );
                }
            });

            // Limpiar input si todos fueron válidos
            if (errores.length === 0) {
                document.getElementById('venta_rapida_input').value = '';
            }
        });
    }

        // ---- Productos ----
        document.getElementById('buscar_producto').addEventListener('keypress', e => {
            if (e.key === 'Enter') { e.preventDefault(); buscarProducto(); }
        });

        function buscarProducto() {
            const termino = document.getElementById('buscar_producto').value.trim();
            if (termino.length < 2) { alert('Escribe al menos 2 caracteres.'); return; }

            fetch(`{{ route('admin.ventas.buscar-producto') }}?q=${encodeURIComponent(termino)}`)
                .then(r => r.json())
                .then(productos => {
                    const div = document.getElementById('resultados_productos');
                    div.classList.remove('hidden');

                    if (productos.length === 0) {
                        div.innerHTML = `<div class="text-sm text-gray-400 p-2">No se encontraron productos.</div>`;
                        return;
                    }

                    div.innerHTML = `<div class="space-y-1 max-h-40 overflow-y-auto border rounded">
                        ${productos.map(p => `
                            <div class="flex items-center justify-between p-2 hover:bg-green-50 cursor-pointer text-sm"
                                 onclick="agregarProducto(${p.id}, '${p.clave}', '${p.descripcion}', ${p.precio_unitario}, '${p.categoria}', ${p.stock})">
                                <span><span class="font-mono text-xs text-gray-400">${p.clave}</span> ${p.descripcion}</span>
                                <span class="text-green-600 font-medium">$${parseFloat(p.precio_unitario).toFixed(2)}</span>
                            </div>
                        `).join('')}
                    </div>`;
                });
        }

        function agregarProducto(id, clave, descripcion, precio, categoria, stock, cantidadInicial = 1) {
            document.getElementById('resultados_productos').classList.add('hidden');
            document.getElementById('buscar_producto').value = '';
            document.getElementById('fila_vacia')?.remove();

            const idx      = filaIndex++;
            const subtotal = precio * cantidadInicial;
            const fila     = document.createElement('tr');
            fila.id        = `fila_${idx}`;
            fila.className = 'hover:bg-gray-50';
            fila.innerHTML = `
                <td class="px-4 py-2 text-sm font-mono text-gray-500">${clave}</td>
                <td class="px-4 py-2 text-sm text-gray-700">${descripcion}</td>
                <td class="px-4 py-2 text-sm text-gray-900">$${parseFloat(precio).toFixed(2)}</td>
                <td class="px-4 py-2">
                    <input type="number" min="1" ${categoria === 'producto' ? `max="${stock}"` : ''}
                        value="${cantidadInicial}" class="w-20 border-gray-300 rounded text-sm text-center"
                        onchange="recalcularFila(${idx}, ${precio})"
                        id="cantidad_${idx}">
                    ${categoria === 'producto' ? `<span class="text-xs text-gray-400 ml-1">/${stock}</span>` : ''}
                </td>
                <td class="px-4 py-2">
                    <input type="number" min="0" step="0.01" value="0"
                        class="w-24 border-gray-300 rounded text-sm text-center"
                        onchange="recalcularFila(${idx}, ${precio})"
                        id="descuento_${idx}">
                </td>
                <td class="px-4 py-2 text-sm font-medium text-gray-900" id="subtotal_${idx}">
                    $${subtotal.toFixed(2)}
                </td>
                <td class="px-4 py-2">
                    <button type="button" onclick="eliminarFila(${idx})"
                            class="text-red-500 hover:text-red-700 text-lg">✕</button>
                </td>
                <input type="hidden" name="productos[${idx}][id]" value="${id}">
                <input type="hidden" name="productos[${idx}][cantidad]" id="h_cantidad_${idx}" value="${cantidadInicial}">
                <input type="hidden" name="productos[${idx}][descuento]" id="h_descuento_${idx}" value="0">
            `;

            document.getElementById('tbody_venta').appendChild(fila);
            productosVenta.push({ idx, id, precio, cantidad: cantidadInicial, subtotal });
            actualizarTotales();
        }

        function recalcularFila(idx, precio) {
            const cantidad  = parseFloat(document.getElementById(`cantidad_${idx}`).value) || 1;
            const descuento = parseFloat(document.getElementById(`descuento_${idx}`).value) || 0;
            const subtotal  = (precio * cantidad) - descuento;

            document.getElementById(`subtotal_${idx}`).textContent = '$' + subtotal.toFixed(2);
            document.getElementById(`h_cantidad_${idx}`).value = cantidad;
            document.getElementById(`h_descuento_${idx}`).value = descuento;
            actualizarTotales();
        }

        function eliminarFila(idx, id) {
            document.getElementById(`fila_${idx}`)?.remove();
            productosVenta = productosVenta.filter(p => p.idx !== idx);

            if (productosVenta.length === 0) {
                const fila = document.createElement('tr');
                fila.id = 'fila_vacia';
                fila.innerHTML = `<td colspan="7" class="px-4 py-6 text-center text-gray-400 text-sm">Agrega productos o servicios usando el buscador</td>`;
                document.getElementById('tbody_venta').appendChild(fila);
            }
            actualizarTotales();
        }

        function actualizarTotales() {
            let subtotalGeneral  = 0;
            let descuentoGeneral = 0;

            productosVenta.forEach(p => {
                const cantidad  = parseFloat(document.getElementById(`cantidad_${p.idx}`)?.value) || 1;
                const descuento = parseFloat(document.getElementById(`descuento_${p.idx}`)?.value) || 0;
                subtotalGeneral  += p.precio * cantidad;
                descuentoGeneral += descuento;
            });

            const total = subtotalGeneral - descuentoGeneral;
            document.getElementById('total_descuentos').textContent = '-$' + descuentoGeneral.toFixed(2);
            document.getElementById('total_venta').textContent = '$' + total.toFixed(2);
        }

        function confirmarVenta() {
            if (productosVenta.length === 0) {
                alert('Agrega al menos un producto o servicio.');
                return;
            }
            if (confirm('¿Confirmar la venta por ' + document.getElementById('total_venta').textContent + '?')) {
                document.getElementById('form_venta').submit();
            }
        }
    </script>
</x-app-layout>