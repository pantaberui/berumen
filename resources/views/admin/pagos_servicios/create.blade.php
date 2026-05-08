<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Registrar Pago de Servicio</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Buscador de cliente --}}
            <div class="bg-white shadow-sm rounded-lg p-6" id="buscador_section">
                <h3 class="text-base font-medium text-gray-800 mb-4">Buscar cliente</h3>
                <div class="flex gap-3">
                    <input type="text" id="buscar_input"
                           placeholder="Escribe nombre o apellido (mínimo 3 caracteres)..."
                           class="flex-1 border-gray-300 rounded-md shadow-sm">
                    <button onclick="buscarCliente()"
                            class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                        Buscar
                    </button>
                </div>
                <div id="resultados_clientes" class="mt-4 hidden"></div>
            </div>

            {{-- Formulario --}}
            <div id="formulario_section" class="{{ $errors->any() ? '' : 'hidden' }}">
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

        document.getElementById('buscar_input').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') buscarCliente();
        });

        function buscarCliente() {
            const termino = document.getElementById('buscar_input').value.trim();
            if (termino.length < 3) { alert('Escribe al menos 3 caracteres.'); return; }

            fetch(`{{ route('admin.pagos-servicios.buscar-cliente') }}?q=${encodeURIComponent(termino)}`)
                .then(r => r.json())
                .then(clientes => {
                    const div = document.getElementById('resultados_clientes');
                    div.classList.remove('hidden');

                    if (clientes.length === 0) {
                        div.innerHTML = `<div class="bg-red-50 border border-red-200 rounded p-3 text-sm text-red-700">No se encontró ningún cliente con ese criterio.</div>`;
                        return;
                    }

                    div.innerHTML = `
                        <p class="text-sm font-medium text-gray-700 mb-2">Selecciona el cliente:</p>
                        <div class="space-y-2">
                            ${clientes.map(c => `
                                <div class="flex items-center justify-between border rounded p-3 bg-gray-50 hover:bg-blue-50 cursor-pointer"
                                     onclick="seleccionarCliente(${c.id}, '${c.nombre} ${c.apellido_paterno} ${c.apellido_materno ?? ''}')">
                                    <div class="text-sm">
                                        <p class="font-medium text-gray-900">${c.nombre} ${c.apellido_paterno} ${c.apellido_materno ?? ''}</p>
                                        <p class="text-gray-500">Tel: ${c.celular ?? c.telefono ?? '—'}</p>
                                    </div>
                                    <span class="text-blue-600 text-sm">Seleccionar →</span>
                                </div>
                            `).join('')}
                        </div>
                    `;
                });
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