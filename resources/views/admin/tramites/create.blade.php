<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nuevo Trámite</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

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
                    <div id="cliente_badge" class="mt-2 inline-flex items-center gap-2 bg-blue-50 border border-blue-200 rounded px-3 py-2 text-sm text-blue-800">
                        👤 <span id="cliente_badge_nombre">PÚBLICO EN GENERAL</span>
                        <button type="button" onclick="limpiarCliente()" class="text-blue-400 hover:text-blue-600">✕</button>
                    </div>
                </div>

                <form action="{{ route('admin.tramites.store') }}" method="POST" id="form_tramite">
                    @csrf
                    <input type="hidden" name="cliente_id" id="cliente_id_input">
                    <input type="hidden" name="cliente_nombre" id="cliente_nombre_input" value="PÚBLICO EN GENERAL">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Tipo de Trámite *</label>
                            <select name="tipo_tramite_id" id="tipo_tramite_id"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                    onchange="cargarPrecioSugerido(this)">
                                <option value="">— Selecciona un trámite —</option>
                                @foreach($tiposTramite as $tipo)
                                    <option value="{{ $tipo->id }}"
                                            data-precio="{{ $tipo->precio_sugerido }}"
                                        {{ old('tipo_tramite_id') == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->nombre }}
                                        {{ $tipo->precio_sugerido ? '— $'.number_format($tipo->precio_sugerido, 2) : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cantidad *</label>
                            <input type="number" name="cantidad" id="cantidad" min="1"
                                   value="{{ old('cantidad', 1) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="calcularSubtotal()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Importe * <span class="text-xs text-gray-400">(editable)</span>
                            </label>
                            <input type="number" name="importe" id="importe" step="0.01" min="0"
                                   value="{{ old('importe', 0) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="calcularSubtotal()">
                            <p class="text-xs text-gray-400 mt-1" id="precio_sugerido_text"></p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Subtotal</label>
                            <div id="subtotal_display"
                                 class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 font-bold text-lg text-green-700">
                                $0.00
                            </div>
                            <p class="text-xs text-gray-500 italic mt-1" id="subtotal_letras"></p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observaciones" rows="2"
                                      class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('observaciones') }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.tramites.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                            Cancelar
                        </a>
                        {{-- Solo cobrar sin ticket --}}
                        <button type="submit"
                                class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                            ✓ Solo Cobrar
                        </button>
                        {{-- Cobrar e imprimir ticket --}}
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
        // Cliente
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
                        div.innerHTML = `<div class="bg-yellow-50 border border-yellow-200 rounded p-3 text-sm text-yellow-700">
                            No se encontró ningún cliente.</div>`;
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

        // Precio sugerido
        function cargarPrecioSugerido(select) {
            const option  = select.options[select.selectedIndex];
            const precio  = option.dataset.precio;
            const txt     = document.getElementById('precio_sugerido_text');

            if (precio && precio !== 'null') {
                document.getElementById('importe').value = parseFloat(precio).toFixed(2);
                txt.textContent = `Precio sugerido: $${parseFloat(precio).toFixed(2)}`;
            } else {
                document.getElementById('importe').value = '0.00';
                txt.textContent = 'Este trámite no tiene precio fijo — ingresa el importe manualmente.';
            }
            calcularSubtotal();
        }

        // Cálculo subtotal
        function calcularSubtotal() {
            const importe  = parseFloat(document.getElementById('importe').value) || 0;
            const cantidad = parseInt(document.getElementById('cantidad').value) || 1;
            const subtotal = importe * cantidad;
            document.getElementById('subtotal_display').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('subtotal_letras').textContent  = numeroALetras(subtotal);
        }

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