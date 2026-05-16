<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nuevo Trámite</h2>
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

                {{-- Buscador de cliente --}}
                <div class="mb-6">
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
                    <div class="mt-2 inline-flex items-center gap-2 bg-blue-50 border border-blue-200 rounded px-3 py-2 text-sm text-blue-800">
                        👤 <span id="cliente_badge_nombre">PÚBLICO EN GENERAL</span>
                        <button type="button" onclick="limpiarCliente()" class="text-blue-400 hover:text-blue-600">✕</button>
                    </div>
                </div>

                {{-- Agregar trámite --}}
                <div class="border-t pt-4 mb-4">
                    <h3 class="text-base font-medium text-gray-800 mb-3">Agregar Trámite</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Tipo de Trámite</label>
                            <select id="sel_tipo_tramite"
                                    class="w-full border-gray-300 rounded-md shadow-sm text-sm"
                                    onchange="cargarPrecio(this)">
                                <option value="">— Selecciona —</option>
                                @foreach($tiposTramite as $tipo)
                                    <option value="{{ $tipo->id }}"
                                            data-nombre="{{ $tipo->nombre }}"
                                            data-precio="{{ $tipo->precio_sugerido }}">
                                        {{ $tipo->nombre }}
                                        {{ $tipo->precio_sugerido ? '— $'.number_format($tipo->precio_sugerido, 2) : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Cantidad</label>
                            <input type="number" id="sel_cantidad" value="1" min="1"
                                   class="w-full border-gray-300 rounded-md shadow-sm text-sm"
                                   oninput="calcularSubtotalPreview()">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Importe unitario</label>
                            <input type="number" id="sel_importe" value="0" step="0.01" min="0"
                                   class="w-full border-gray-300 rounded-md shadow-sm text-sm"
                                   oninput="calcularSubtotalPreview()">
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-2">
                        <span class="text-sm text-gray-500">
                            Subtotal: <strong id="preview_subtotal" class="text-green-700">$0.00</strong>
                        </span>
                        <button type="button" onclick="agregarTramite()"
                                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">
                            + Agregar a la lista
                        </button>
                    </div>
                </div>

                {{-- Tabla de trámites --}}
                <form action="{{ route('admin.tramites.store') }}" method="POST" id="form_tramite">
                    @csrf
                    <input type="hidden" name="cliente_id" id="cliente_id_input">
                    <input type="hidden" name="cliente_nombre" id="cliente_nombre_input" value="PÚBLICO EN GENERAL">

                    <div class="overflow-x-auto mb-4">
                        <table class="min-w-full divide-y divide-gray-200" id="tabla_tramites">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Trámite</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cant.</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Importe</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acc.</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_tramites">
                                <tr id="fila_vacia">
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-400 text-sm">
                                        Agrega trámites usando el formulario de arriba
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50">
                                    <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-700">Total:</td>
                                    <td class="px-4 py-3 text-lg font-bold text-green-700" id="total_tramites">$0.00</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="px-4 py-1 text-xs text-gray-500 italic" id="total_letras"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                        <textarea name="observaciones" rows="2"
                                  class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('observaciones') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.tramites.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                            ✓ Solo Cobrar
                        </button>
                        <button type="submit" name="imprimir" value="1"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            🖨 Cobrar e Imprimir Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let tramitesLista = [];
        let filaIndex = 0;

        // ---- Cliente ----
        document.getElementById('buscar_cliente').addEventListener('keypress', e => {
            if (e.key === 'Enter') { e.preventDefault(); buscarCliente(); }
        });

        function buscarCliente() {
            const termino = document.getElementById('buscar_cliente').value.trim();
            if (termino.length < 3) { alert('Escribe al menos 3 caracteres.'); return; }

            fetch(`{{ route('admin.tramites.buscar-cliente') }}?q=${encodeURIComponent(termino)}`)
                .then(r => r.json())
                .then(clientes => {
                    const div = document.getElementById('resultados_clientes');
                    div.classList.remove('hidden');
                    if (clientes.length === 0) {
                        div.innerHTML = `<div class="bg-yellow-50 border border-yellow-200 rounded p-3 text-sm text-yellow-700">No se encontró ningún cliente.</div>`;
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

        function usarPublicoGeneral() { limpiarCliente(); }

        function limpiarCliente() {
            document.getElementById('cliente_id_input').value = '';
            document.getElementById('cliente_nombre_input').value = 'PÚBLICO EN GENERAL';
            document.getElementById('cliente_badge_nombre').textContent = 'PÚBLICO EN GENERAL';
            document.getElementById('resultados_clientes').classList.add('hidden');
            document.getElementById('buscar_cliente').value = '';
        }

        // ---- Trámites ----
        function cargarPrecio(select) {
            const option = select.options[select.selectedIndex];
            const precio = option.dataset.precio;
            document.getElementById('sel_importe').value =
                precio && precio !== 'null' ? parseFloat(precio).toFixed(2) : '0.00';
            calcularSubtotalPreview();
        }

        function calcularSubtotalPreview() {
            const importe  = parseFloat(document.getElementById('sel_importe').value) || 0;
            const cantidad = parseInt(document.getElementById('sel_cantidad').value) || 1;
            document.getElementById('preview_subtotal').textContent = '$' + (importe * cantidad).toFixed(2);
        }

        function agregarTramite() {
            const select   = document.getElementById('sel_tipo_tramite');
            const tipoId   = select.value;
            const nombre   = select.options[select.selectedIndex]?.dataset.nombre;
            const cantidad = parseInt(document.getElementById('sel_cantidad').value) || 1;
            const importe  = parseFloat(document.getElementById('sel_importe').value) || 0;

            if (!tipoId) { alert('Selecciona un tipo de trámite.'); return; }

            document.getElementById('fila_vacia')?.remove();

            const idx      = filaIndex++;
            const subtotal = importe * cantidad;
            const fila     = document.createElement('tr');
            fila.id        = `fila_${idx}`;
            fila.className = 'hover:bg-gray-50';
            fila.innerHTML = `
                <td class="px-4 py-2 text-sm text-gray-700">${nombre}
                    <input type="hidden" name="tramites[${idx}][tipo_tramite_id]" value="${tipoId}">
                </td>
                <td class="px-4 py-2 text-sm text-gray-500">${cantidad}
                    <input type="hidden" name="tramites[${idx}][cantidad]" value="${cantidad}">
                </td>
                <td class="px-4 py-2 text-sm text-gray-500">$${importe.toFixed(2)}
                    <input type="hidden" name="tramites[${idx}][importe]" value="${importe}">
                </td>
                <td class="px-4 py-2 text-sm font-medium text-gray-900">$${subtotal.toFixed(2)}</td>
                <td class="px-4 py-2">
                    <button type="button" onclick="eliminarFila(${idx})"
                            class="text-red-500 hover:text-red-700 text-lg">✕</button>
                </td>
            `;

            document.getElementById('tbody_tramites').appendChild(fila);
            tramitesLista.push({ idx, subtotal });
            actualizarTotal();

            // Limpiar selector
            select.value = '';
            document.getElementById('sel_cantidad').value = '1';
            document.getElementById('sel_importe').value  = '0.00';
            document.getElementById('preview_subtotal').textContent = '$0.00';
        }

        function eliminarFila(idx) {
            document.getElementById(`fila_${idx}`)?.remove();
            tramitesLista = tramitesLista.filter(t => t.idx !== idx);

            if (tramitesLista.length === 0) {
                const fila = document.createElement('tr');
                fila.id = 'fila_vacia';
                fila.innerHTML = `<td colspan="5" class="px-4 py-6 text-center text-gray-400 text-sm">Agrega trámites usando el formulario de arriba</td>`;
                document.getElementById('tbody_tramites').appendChild(fila);
            }
            actualizarTotal();
        }

        function actualizarTotal() {
            const total = tramitesLista.reduce((sum, t) => sum + t.subtotal, 0);
            document.getElementById('total_tramites').textContent = '$' + total.toFixed(2);
            document.getElementById('total_letras').textContent   = numeroALetras(total);
        }

        // Validar antes de enviar
        document.getElementById('form_tramite').addEventListener('submit', function(e) {
            if (tramitesLista.length === 0) {
                e.preventDefault();
                alert('Agrega al menos un trámite a la lista.');
            }
        });

        function numeroALetras(num) {
            const entero   = Math.floor(num);
            const centavos = Math.round((num - entero) * 100);
            const unidades = ['','UN','DOS','TRES','CUATRO','CINCO','SEIS','SIETE','OCHO','NUEVE',
                'DIEZ','ONCE','DOCE','TRECE','CATORCE','QUINCE','DIECISÉIS','DIECISIETE','DIECIOCHO','DIECINUEVE','VEINTE'];
            const decenas  = ['','DIEZ','VEINTE','TREINTA','CUARENTA','CINCUENTA','SESENTA','SETENTA','OCHENTA','NOVENTA'];

            function conv(n) {
                if (n === 0) return 'CERO';
                if (n <= 20) return unidades[n];
                if (n < 30)  return 'VEINTI' + unidades[n-20];
                if (n < 100) return decenas[Math.floor(n/10)] + (n%10 ? ' Y ' + unidades[n%10] : '');
                if (n < 200) return 'CIEN' + (n > 100 ? 'TO ' + conv(n-100) : '');
                if (n < 1000) return ['','DOSCIENTOS','TRESCIENTOS','CUATROCIENTOS','QUINIENTOS',
                    'SEISCIENTOS','SETECIENTOS','OCHOCIENTOS','NOVECIENTOS'][Math.floor(n/100)] +
                    (n%100 ? ' ' + conv(n%100) : '');
                if (n < 2000) return 'MIL' + (n > 1000 ? ' ' + conv(n-1000) : '');
                return conv(Math.floor(n/1000)) + ' MIL' + (n%1000 ? ' ' + conv(n%1000) : '');
            }
            return `(${conv(entero)} ${String(centavos).padStart(2,'0')}/100 M.N.)`;
        }
    </script>
</x-app-layout>