<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Registrar Pago de Servicio</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Cliente --}}
            <div class="mb-4">
                <h3 class="text-base font-medium text-gray-800 mb-3">Cliente</h3>
                <div class="flex gap-3 items-center">
                    <input type="text" id="buscar_cliente"
                        placeholder="Buscar cliente (mín. 3 letras)..."
                        class="flex-1 border-gray-300 rounded-md shadow-sm text-sm">
                    <button type="button" onclick="buscarClienteServicio()"
                            class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">
                        Buscar
                    </button>
                    <button type="button" onclick="usarPublicoGeneralServicio()"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">
                        Público en General
                    </button>
                </div>
                <div id="resultados_clientes_servicio" class="mt-2 hidden"></div>
                <div class="mt-2 inline-flex items-center gap-2 bg-blue-50 border border-blue-200 rounded px-3 py-2 text-sm text-blue-800">
                    👤 <span id="cliente_badge_servicio">PÚBLICO EN GENERAL</span>
                    <button type="button" onclick="limpiarClienteServicio()" class="text-blue-400 hover:text-blue-600">✕</button>
                </div>
                
            </div>

            {{-- Formulario --}}
            <div id="formulario_section">
                <div class="bg-white shadow-sm rounded-lg p-6">

                    @if($errors->any())
                        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            

                    {{-- Cliente seleccionado --}}
                    <div id="cliente_seleccionado" class="hidden mb-4 p-3 bg-blue-50 border border-blue-200 rounded">
                        <p class="text-sm font-medium text-blue-800" id="cliente_nombre"></p>
                        <input type="hidden" name="cliente_id" id="cliente_id" value="{{ old('cliente_id') }}">
                    </div>

                    <form action="{{ route('admin.pagos-servicios.store') }}" method="POST" id="form_pago">
                        @csrf                        
                        <input type="hidden" name="cliente_id" id="cliente_id_form" value="{{ old('cliente_id') }}">
                        <input type="hidden" name="cliente_nombre" id="cliente_nombre_servicio" value="PÚBLICO EN GENERAL">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Tipo de Servicio *</label>
                                <select name="tipo_servicio_id" id="tipo_servicio_id"
                                        class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                        onchange="buscarUltimaReferencia()">
                                    <option value="">— Selecciona un servicio —</option>
                                    @foreach($servicios as $servicio)
                                        <option value="{{ $servicio->id }}"
                                            {{ old('tipo_servicio_id') == $servicio->id ? 'selected' : '' }}>
                                            {{ $servicio->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Referencia *</label>
                                <input type="text" name="referencia" id="referencia"
                                       value="{{ old('referencia') }}"
                                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <div id="aviso_referencia" class="hidden mt-2 p-3 bg-yellow-50 border border-yellow-300 rounded text-sm">
                                    <p class="text-yellow-800 font-medium">⚠️ Última referencia encontrada</p>
                                    <p class="text-yellow-700" id="texto_referencia_anterior"></p>
                                    <div class="mt-2 flex gap-2">
                                        <button type="button" onclick="confirmarReferencia()"
                                                class="px-3 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">
                                            ✓ Sí, es correcta
                                        </button>
                                        <button type="button" onclick="rechazarReferencia()"
                                                class="px-3 py-1 bg-gray-400 text-white rounded text-xs hover:bg-gray-500">
                                            No, la cambiaré
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Importe *</label>
                                <input type="number" name="importe" id="importe" step="0.01" min="1"
                                       value="{{ old('importe') }}"
                                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                       oninput="calcularComisionAuto()">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Comisión * <span class="text-xs text-gray-400">(mín $10 — máx $100)</span>
                                </label>
                                <input type="number" name="comision" id="comision" step="0.01" min="10" max="100"
                                       value="{{ old('comision', 25) }}"
                                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                       oninput="calcularTotal()">
                                <p class="text-xs text-gray-400 mt-1" id="texto_comision_auto">
                                    Comisión sugerida según importe
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo de Pago *</label>
                                <select name="tipo_pago" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="efectivo">Efectivo</option>
                                    <option value="transferencia">Transferencia</option>
                                    <option value="tarjeta">Tarjeta</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total a Cobrar</label>
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
                            <a href="{{ route('admin.pagos-servicios.index') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Registrar Pago
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let clienteSeleccionadoId = '{{ old('cliente_id') }}';

        document.getElementById('buscar_cliente')?.addEventListener('keypress', e => {
            if (e.key === 'Enter') { e.preventDefault(); buscarClienteServicio(); }
        });

        function buscarClienteServicio() {
            const termino = document.getElementById('buscar_cliente').value.trim();
            if (termino.length < 3) { alert('Escribe al menos 3 caracteres.'); return; }

            fetch(`{{ route('admin.pagos-servicios.buscar-cliente') }}?q=${encodeURIComponent(termino)}`)
                .then(r => r.json())
                .then(clientes => {
                    const div = document.getElementById('resultados_clientes_servicio');
                    div.classList.remove('hidden');
                    if (clientes.length === 0) {
                        div.innerHTML = `<div class="bg-yellow-50 border border-yellow-200 rounded p-3 text-sm text-yellow-700">No se encontró ningún cliente.</div>`;
                        return;
                    }
                    div.innerHTML = `<div class="space-y-1 max-h-40 overflow-y-auto">
                        ${clientes.map(c => `
                            <div class="flex items-center justify-between border rounded p-2 hover:bg-blue-50 cursor-pointer text-sm"
                                onclick="seleccionarClienteServicio(${c.id}, '${c.nombre} ${c.apellido_paterno} ${c.apellido_materno ?? ''}')">
                                <span>${c.nombre} ${c.apellido_paterno} ${c.apellido_materno ?? ''}</span>
                                <span class="text-blue-600 text-xs">Seleccionar →</span>
                            </div>
                        `).join('')}
                    </div>`;
                });
        }

        function seleccionarClienteServicio(id, nombre) {
            document.getElementById('cliente_id_form').value = id;
            document.getElementById('cliente_nombre_servicio').value = nombre.trim().toUpperCase();
            document.getElementById('cliente_badge_servicio').textContent = nombre.trim().toUpperCase();
            document.getElementById('resultados_clientes_servicio').classList.add('hidden');
            document.getElementById('buscar_cliente').value = '';
            clienteSeleccionadoId = id;
            buscarUltimaReferencia();
        }

        function usarPublicoGeneralServicio() { 
            limpiarClienteServicio();
        }

        function limpiarClienteServicio() {
            document.getElementById('cliente_id_form').value = '';
            document.getElementById('cliente_nombre_servicio').value = 'PÚBLICO EN GENERAL';
            document.getElementById('cliente_badge_servicio').textContent = 'PÚBLICO EN GENERAL';
            document.getElementById('resultados_clientes_servicio').classList.add('hidden');
            document.getElementById('buscar_cliente').value = '';
            clienteSeleccionadoId = '';
        }

        function seleccionarCliente(id, nombre) {
            clienteSeleccionadoId = id;
            document.getElementById('cliente_id_form').value = id;
            document.getElementById('formulario_section').classList.remove('hidden');
            document.getElementById('formulario_section').scrollIntoView({ behavior: 'smooth' });

            // Mostrar nombre del cliente en el formulario
            const div = document.getElementById('cliente_seleccionado');
            div.classList.remove('hidden');
            document.getElementById('cliente_nombre').textContent = '👤 Cliente: ' + nombre;

            buscarUltimaReferencia();
        }

        function buscarUltimaReferencia() {
            const tipoId = document.getElementById('tipo_servicio_id').value;
            if (!clienteSeleccionadoId || !tipoId) return;

            fetch(`{{ route('admin.pagos-servicios.ultima-referencia') }}?cliente_id=${clienteSeleccionadoId}&tipo_servicio_id=${tipoId}`)
                .then(r => r.json())
                .then(data => {
                    if (data.referencia) {
                        document.getElementById('referencia').value = data.referencia;
                        document.getElementById('texto_referencia_anterior').textContent =
                            `La última referencia registrada fue: ${data.referencia}. ¿Es la misma?`;
                        document.getElementById('aviso_referencia').classList.remove('hidden');
                    } else {
                        document.getElementById('aviso_referencia').classList.add('hidden');
                        document.getElementById('referencia').value = '';
                    }
                });
        }

        function confirmarReferencia() {
            document.getElementById('aviso_referencia').classList.add('hidden');
        }

        function rechazarReferencia() {
            document.getElementById('referencia').value = '';
            document.getElementById('aviso_referencia').classList.add('hidden');
            document.getElementById('referencia').focus();
        }

        function calcularComisionAuto() {
            const importe = parseFloat(document.getElementById('importe').value) || 0;
            let comision = 25;
            if (importe >= 2000) comision = 100;
            else if (importe >= 1500) comision = 75;
            else if (importe >= 1000) comision = 50;

            document.getElementById('comision').value = comision.toFixed(2);
            document.getElementById('texto_comision_auto').textContent =
                `Comisión sugerida: $${comision.toFixed(2)} (según importe)`;
            calcularTotal();
        }

        function calcularTotal() {
            const importe  = parseFloat(document.getElementById('importe').value) || 0;
            const comision = parseFloat(document.getElementById('comision').value) || 0;
            document.getElementById('total_display').textContent = '$' + (importe + comision).toFixed(2);
        }
    </script>
</x-app-layout>