<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Registrar Pago</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
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

                <form action="{{ route('admin.pagos.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Contrato *</label>
                            <select name="contrato_id" id="contrato_id"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                    onchange="cargarMensualidad(this)">
                                <option value="">— Selecciona un contrato —</option>
                                @foreach($contratos as $contrato)
                                    <option value="{{ $contrato->id }}"
                                            data-mensualidad="{{ $contrato->mensualidad }}"
                                        {{ old('contrato_id') == $contrato->id ? 'selected' : '' }}>
                                        {{ $contrato->numero_contrato }} — {{ $contrato->cliente->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Pago *</label>
                            <input type="date" name="fecha_pago"
                                   value="{{ old('fecha_pago', date('Y-m-d')) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
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
                            <label class="block text-sm font-medium text-gray-700">Periodo Desde *</label>
                            <input type="date" name="periodo_desde" id="periodo_desde"
                                value="{{ old('periodo_desde') }}"
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                oninput="actualizarFechaFin(this.value)"
                                onchange="actualizarFechaFin(this.value)">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Periodo Hasta *</label>
                            <input type="date" name="periodo_hasta" id="periodo_hasta"
                                   value="{{ old('periodo_hasta') }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Importe *</label>
                            <input type="number" name="importe" id="importe" step="0.01"
                                   value="{{ old('importe') }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="calcularTotal()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descuento</label>
                            <input type="number" name="descuento" id="descuento" step="0.01"
                                   value="{{ old('descuento', 0) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                   oninput="calcularTotal()">
                            <p id="error_descuento" class="hidden text-red-600 text-xs mt-1">
                                El descuento no puede ser mayor al importe.
                            </p
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Total a Cobrar</label>
                            <div id="total_display"
                                 class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 bg-gray-50 font-bold text-lg text-green-700">
                                $0.00
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observaciones" rows="2"
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                oninput="this.value = this.value.toUpperCase()">{{ old('observaciones') }}</textarea>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.pagos.index') }}"
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

    <script>
        // Al cargar la página, establecer fechas por defecto
        document.addEventListener('DOMContentLoaded', function () {
            establecerFechasPorDefecto();
        });

        function cargarMensualidad(select) {
            const option = select.options[select.selectedIndex];
            const mensualidad = option.dataset.mensualidad || 0;
            document.getElementById('importe').value = parseFloat(mensualidad).toFixed(2);
            calcularTotal();
        }

        
        function establecerFechasPorDefecto() {
            const hoy = new Date();
            const desde = formatoInput(hoy);
            document.getElementById('periodo_desde').value = desde;
            actualizarFechaFin(desde);
        }
        


        function formatoInput(fecha) {
            const y = fecha.getFullYear();
            const m = String(fecha.getMonth() + 1).padStart(2, '0');
            const d = String(fecha.getDate()).padStart(2, '0');
            return `${y}-${m}-${d}`;
        }

        function calcularTotal() {
            const importe   = parseFloat(document.getElementById('importe').value) || 0;
            const descuento = parseFloat(document.getElementById('descuento').value) || 0;

            // Validación: descuento no puede ser mayor al importe
            if (descuento > importe) {
                document.getElementById('error_descuento').classList.remove('hidden');
                document.getElementById('total_display').textContent = '$0.00';
                return;
            }

            document.getElementById('error_descuento').classList.add('hidden');
            const total = importe - descuento;
            document.getElementById('total_display').textContent = '$' + total.toFixed(2);
        }

        new TomSelect('#contrato_id', {
            searchField: ['text'],
            placeholder: '— Busca por nombre o número de contrato —',
            maxOptions: 50,
        });

        // Al seleccionar contrato, cargar fecha periodo desde automáticamente
        document.addEventListener('DOMContentLoaded', function() {
            const contratoSelect = document.getElementById('contrato_id');
            if (contratoSelect) {
                contratoSelect.addEventListener('change', function() {
                    const contratoId = this.value;
                    if (!contratoId) return;

                    fetch(`{{ url('admin/pagos/ultimo-periodo') }}/${contratoId}`)
                        .then(r => r.json())
                        .then(data => {
                            if (data.periodo_hasta) {
                                // periodo desde = periodo hasta anterior + 1 día
                                const fechaDesde = new Date(data.periodo_hasta);
            
                                fechaDesde.setDate(fechaDesde.getDate() + 1);
                                const hasta = new Date(fechaDesde);

                                hasta.setMonth(hasta.getMonth() + 1);
                                hasta.setDate(hasta.getDate() - 1);
                                document.getElementById('periodo_hasta').value = formatoInput(hasta);

                                const yyyy = fechaDesde.getFullYear();
                                const mm   = String(fechaDesde.getMonth() + 1).padStart(2, '0');
                                const dd   = String(fechaDesde.getDate()).padStart(2, '0');
                                document.getElementById('periodo_desde').value = `${yyyy}-${mm}-${dd}`;
                                //actualizarFechaFin(fechaDesde);
                            }
                        });
                });

                //actualizarFechaFin(fechaDesde);

                // Si ya hay contrato seleccionado (por old())
                if (contratoSelect.value) {
                    contratoSelect.dispatchEvent(new Event('change'));
                    
                }
            }
        });

        function actualizarFechaFin(desdeStr) {
            if (!desdeStr) return;
            const desde = new Date(desdeStr + 'T00:00:00');
            const hasta = new Date(desde);
            hasta.setMonth(hasta.getMonth() + 1);
            hasta.setDate(hasta.getDate() - 1);
            document.getElementById('periodo_hasta').value = formatoInput(hasta);
        }
        
    </script>
</x-app-layout>