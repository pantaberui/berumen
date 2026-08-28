<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Editar Trámite #{{ str_pad($tramite->id, 6, '0', STR_PAD_LEFT) }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Errores --}}
            @if($errors->any())
                <div class="bg-red-100 text-red-800 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">

                {{-- Información del folio --}}
                <div class="mb-6 p-4 bg-gray-50 rounded-lg text-sm grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <span class="font-medium text-gray-500">Folio:</span>
                        #{{ str_pad($tramite->id, 6, '0', STR_PAD_LEFT) }}
                    </div>

                    <div>
                        <span class="font-medium text-gray-500">Cliente:</span>
                        {{ $tramite->cliente_nombre }}
                    </div>

                    <div>
                        <span class="font-medium text-gray-500">Cajero:</span>
                        {{ $tramite->cajero?->name }}
                    </div>

                    <div>
                        <span class="font-medium text-gray-500">Fecha:</span>
                        {{ $tramite->fecha_hora_cobro?->format('d/m/Y H:i') }}
                    </div>
                </div>


                {{-- Agregar trámite --}}
                <div class="border-t pt-4 mb-5">

                    <h3 class="text-base font-medium text-gray-800 mb-3">
                        Agregar Trámite
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">

                        {{-- Tipo --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-500 mb-1">
                                Tipo de Trámite
                            </label>

                            <select id="sel_tipo_tramite"
                                    class="w-full border-gray-300 rounded-md shadow-sm text-sm"
                                    onchange="cargarPrecio(this)">

                                <option value="">
                                    — Selecciona —
                                </option>

                                @foreach($tiposTramite as $tipo)
                                    <option value="{{ $tipo->id }}"
                                            data-nombre="{{ $tipo->nombre }}"
                                            data-precio="{{ $tipo->precio_sugerido }}">

                                        {{ $tipo->nombre }}

                                        {{ $tipo->precio_sugerido
                                            ? '— $'.number_format($tipo->precio_sugerido, 2)
                                            : ''
                                        }}

                                    </option>
                                @endforeach

                            </select>
                        </div>


                        {{-- Cantidad --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">
                                Cantidad
                            </label>

                            <input type="number"
                                   id="sel_cantidad"
                                   value="1"
                                   min="1"
                                   class="w-full border-gray-300 rounded-md shadow-sm text-sm"
                                   oninput="calcularSubtotalPreview()">
                        </div>


                        {{-- Importe --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">
                                Importe unitario
                            </label>

                            <input type="number"
                                   id="sel_importe"
                                   value="0"
                                   step="0.01"
                                   min="0"
                                   class="w-full border-gray-300 rounded-md shadow-sm text-sm"
                                   oninput="calcularSubtotalPreview()">
                        </div>

                    </div>


                    {{-- Preview --}}
                    <div class="flex items-center gap-4 mt-2">

                        <span class="text-sm text-gray-500">
                            Subtotal:
                            <strong id="preview_subtotal"
                                    class="text-green-700">
                                $0.00
                            </strong>
                        </span>

                        <button type="button"
                                onclick="agregarTramite()"
                                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">

                            + Agregar a la lista

                        </button>

                    </div>

                </div>


                {{-- Formulario --}}
                <form action="{{ route('admin.tramites.update', $tramite) }}"
                      method="POST"
                      id="form_tramite">

                    @csrf
                    @method('PUT')


                    {{-- Tabla --}}
                    <div class="overflow-x-auto mb-4">

                        <table class="min-w-full divide-y divide-gray-200"
                               id="tabla_tramites">

                            <thead class="bg-gray-50">

                                <tr>

                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Trámite
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Cant.
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Importe
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Subtotal
                                    </th>

                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        Acc.
                                    </th>

                                </tr>

                            </thead>


                            <tbody id="tbody_tramites">

                                @forelse($tramite->detalles as $detalle)

                                    <tr id="fila_existente_{{ $detalle->id }}"
                                        class="hover:bg-gray-50">

                                        {{-- Tipo --}}
                                        <td class="px-4 py-2 text-sm text-gray-700">

                                            {{ $detalle->tipoTramite?->nombre }}

                                            <input type="hidden"
                                                   name="detalles[{{ $detalle->id }}][id]"
                                                   value="{{ $detalle->id }}">

                                            <input type="hidden"
                                                   name="detalles[{{ $detalle->id }}][tipo_tramite_id]"
                                                   value="{{ $detalle->tipo_tramite_id }}">

                                        </td>


                                        {{-- Cantidad --}}
                                        <td class="px-4 py-2">

                                            <input type="number"
                                                   name="detalles[{{ $detalle->id }}][cantidad]"
                                                   value="{{ old('detalles.'.$detalle->id.'.cantidad', $detalle->cantidad) }}"
                                                   min="1"
                                                   class="w-24 border-gray-300 rounded-md shadow-sm text-sm campo-cantidad"
                                                   data-id="{{ $detalle->id }}"
                                                   oninput="actualizarFila({{ $detalle->id }})">

                                        </td>


                                        {{-- Importe --}}
                                        <td class="px-4 py-2">

                                            <input type="number"
                                                   name="detalles[{{ $detalle->id }}][importe]"
                                                   value="{{ old('detalles.'.$detalle->id.'.importe', $detalle->importe) }}"
                                                   step="0.01"
                                                   min="0"
                                                   class="w-28 border-gray-300 rounded-md shadow-sm text-sm campo-importe"
                                                   data-id="{{ $detalle->id }}"
                                                   oninput="actualizarFila({{ $detalle->id }})">

                                        </td>


                                        {{-- Subtotal --}}
                                        <td class="px-4 py-2 text-sm font-medium text-gray-900">

                                            <span id="subtotal_{{ $detalle->id }}">
                                                ${{ number_format($detalle->subtotal, 2) }}
                                            </span>

                                        </td>


                                        {{-- Acción --}}
                                        <td class="px-4 py-2">

                                            <button type="button"
                                                    onclick="eliminarFila({{ $detalle->id }})"
                                                    class="text-red-500 hover:text-red-700 text-lg"
                                                    title="Eliminar">

                                                ✕

                                            </button>

                                        </td>

                                    </tr>

                                @empty

                                    <tr id="fila_vacia">

                                        <td colspan="5"
                                            class="px-4 py-6 text-center text-gray-400 text-sm">

                                            Agrega trámites usando el formulario de arriba

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>


                            {{-- Total --}}
                            <tfoot>

                                <tr class="bg-gray-50">

                                    <td colspan="3"
                                        class="px-4 py-3 text-right text-sm font-medium text-gray-700">

                                        Total:

                                    </td>

                                    <td class="px-4 py-3 text-lg font-bold text-green-700"
                                        id="total_tramites">

                                        ${{ number_format($tramite->subtotal, 2) }}

                                    </td>

                                    <td></td>

                                </tr>

                                <tr>

                                    <td colspan="5"
                                        class="px-4 py-1 text-xs text-gray-500 italic"
                                        id="total_letras">
                                    </td>

                                </tr>

                            </tfoot>

                        </table>

                    </div>


                    {{-- Estatus --}}
                    @if(auth()->user()->hasRole('admin'))

                        <div class="mb-4">

                            <label class="block text-sm font-medium text-gray-700">
                                Estatus
                            </label>

                            <select name="estatus"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm">

                                <option value="cobrado"
                                    {{ $tramite->estatus === 'cobrado' ? 'selected' : '' }}>
                                    Cobrado
                                </option>

                                <option value="cancelado"
                                    {{ $tramite->estatus === 'cancelado' ? 'selected' : '' }}>
                                    Cancelado
                                </option>

                            </select>

                            @if($tramite->estatus === 'cancelado')

                                <p class="text-xs text-red-600 mt-1">

                                    Cancelado el
                                    {{ $tramite->fecha_hora_cancelacion?->format('d/m/Y H:i') }}

                                    por
                                    {{ $tramite->canceladoPor?->name }}

                                </p>

                            @endif

                        </div>

                    @else

                        <input type="hidden"
                               name="estatus"
                               value="{{ $tramite->estatus }}">

                    @endif


                    {{-- Observaciones --}}
                    <div class="mb-4">

                        <label class="block text-sm font-medium text-gray-700">
                            Observaciones
                        </label>

                        <textarea name="observaciones"
                                  rows="2"
                                  class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('observaciones', $tramite->observaciones) }}</textarea>

                    </div>


                    {{-- Botones --}}
                    <div class="flex justify-end gap-3">

                        <a href="{{ route('admin.tramites.show', $tramite) }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">

                            Cancelar

                        </a>

                        <button type="submit"
                                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">

                            Actualizar

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <script>

        // ============================================================
        // VARIABLES
        // ============================================================

        let filaIndex = 100000;


        // ============================================================
        // AGREGAR NUEVO TRÁMITE
        // ============================================================

        function cargarPrecio(select) {

            const option = select.options[select.selectedIndex];

            const precio = option.dataset.precio;

            document.getElementById('sel_importe').value =
                precio && precio !== 'null'
                    ? parseFloat(precio).toFixed(2)
                    : '0.00';

            calcularSubtotalPreview();
        }


        function calcularSubtotalPreview() {

            const importe =
                parseFloat(document.getElementById('sel_importe').value) || 0;

            const cantidad =
                parseInt(document.getElementById('sel_cantidad').value) || 1;

            const subtotal = importe * cantidad;

            document.getElementById('preview_subtotal').textContent =
                '$' + subtotal.toFixed(2);
        }


        function agregarTramite() {

            const select =
                document.getElementById('sel_tipo_tramite');

            const tipoId = select.value;

            if (!tipoId) {

                alert('Selecciona un tipo de trámite.');

                return;
            }


            const option =
                select.options[select.selectedIndex];

            const nombre =
                option.dataset.nombre;

            const cantidad =
                parseInt(document.getElementById('sel_cantidad').value) || 1;

            const importe =
                parseFloat(document.getElementById('sel_importe').value) || 0;

            const subtotal =
                cantidad * importe;


            const idx =
                filaIndex++;


            document.getElementById('fila_vacia')?.remove();


            const fila =
                document.createElement('tr');

            fila.id =
                `fila_nueva_${idx}`;

            fila.className =
                'hover:bg-gray-50';


            fila.innerHTML = `

                <td class="px-4 py-2 text-sm text-gray-700">

                    ${nombre}

                    <input type="hidden"
                           name="detalles[nuevo_${idx}][tipo_tramite_id]"
                           value="${tipoId}">

                </td>


                <td class="px-4 py-2">

                    <input type="number"
                           name="detalles[nuevo_${idx}][cantidad]"
                           value="${cantidad}"
                           min="1"
                           class="w-24 border-gray-300 rounded-md shadow-sm text-sm campo-cantidad-nuevo"
                           data-id="nuevo_${idx}"
                           oninput="actualizarFilaNueva('${idx}')">

                </td>


                <td class="px-4 py-2">

                    <input type="number"
                           name="detalles[nuevo_${idx}][importe]"
                           value="${importe.toFixed(2)}"
                           step="0.01"
                           min="0"
                           class="w-28 border-gray-300 rounded-md shadow-sm text-sm campo-importe-nuevo"
                           data-id="nuevo_${idx}"
                           oninput="actualizarFilaNueva('${idx}')">

                </td>


                <td class="px-4 py-2 text-sm font-medium text-gray-900">

                    <span id="subtotal_nuevo_${idx}">
                        $${subtotal.toFixed(2)}
                    </span>

                </td>


                <td class="px-4 py-2">

                    <button type="button"
                            onclick="eliminarFilaNueva('${idx}')"
                            class="text-red-500 hover:text-red-700 text-lg"
                            title="Eliminar">

                        ✕

                    </button>

                </td>

            `;


            document.getElementById('tbody_tramites')
                .appendChild(fila);


            actualizarTotal();


            // Limpiar formulario superior

            select.value = '';

            document.getElementById('sel_cantidad').value = '1';

            document.getElementById('sel_importe').value = '0.00';

            document.getElementById('preview_subtotal').textContent =
                '$0.00';
        }


        // ============================================================
        // ACTUALIZAR DETALLE EXISTENTE
        // ============================================================

        function actualizarFila(id) {

            const fila =
                document.getElementById(`fila_existente_${id}`);

            const cantidad =
                parseInt(
                    fila.querySelector('.campo-cantidad').value
                ) || 1;

            const importe =
                parseFloat(
                    fila.querySelector('.campo-importe').value
                ) || 0;

            const subtotal =
                cantidad * importe;


            document.getElementById(`subtotal_${id}`)
                .textContent =
                '$' + subtotal.toFixed(2);


            actualizarTotal();
        }


        // ============================================================
        // ACTUALIZAR DETALLE NUEVO
        // ============================================================

        function actualizarFilaNueva(idx) {

            const fila =
                document.getElementById(`fila_nueva_${idx}`);

            const cantidad =
                parseInt(
                    fila.querySelector('.campo-cantidad-nuevo').value
                ) || 1;

            const importe =
                parseFloat(
                    fila.querySelector('.campo-importe-nuevo').value
                ) || 0;

            const subtotal =
                cantidad * importe;


            document.getElementById(`subtotal_nuevo_${idx}`)
                .textContent =
                '$' + subtotal.toFixed(2);


            actualizarTotal();
        }


        // ============================================================
        // ELIMINAR DETALLE EXISTENTE
        // ============================================================

        function eliminarFila(id) {

            const filas =
                document.querySelectorAll('#tbody_tramites > tr');

            if (filas.length <= 1) {

                alert(
                    'El folio debe contener al menos un trámite.'
                );

                return;
            }


            const fila =
                document.getElementById(`fila_existente_${id}`);

            if (fila) {

                // Marcamos la fila para eliminación
                const input =
                    document.createElement('input');

                input.type =
                    'hidden';

                input.name =
                    `eliminar_detalles[]`;

                input.value =
                    id;

                document.getElementById('form_tramite')
                    .appendChild(input);


                fila.remove();

            }


            actualizarTotal();

            verificarTablaVacia();
        }


        // ============================================================
        // ELIMINAR DETALLE NUEVO
        // ============================================================

        function eliminarFilaNueva(idx) {

            const fila =
                document.getElementById(`fila_nueva_${idx}`);

            if (fila) {

                fila.remove();

            }

            actualizarTotal();

            verificarTablaVacia();
        }


        // ============================================================
        // VERIFICAR TABLA
        // ============================================================

        function verificarTablaVacia() {

            const filas =
                document.querySelectorAll(
                    '#tbody_tramites > tr'
                );

            if (filas.length === 0) {

                const fila =
                    document.createElement('tr');

                fila.id =
                    'fila_vacia';

                fila.innerHTML = `

                    <td colspan="5"
                        class="px-4 py-6 text-center text-gray-400 text-sm">

                        Agrega trámites usando el formulario de arriba

                    </td>

                `;

                document.getElementById('tbody_tramites')
                    .appendChild(fila);

            }

        }


        // ============================================================
        // TOTAL
        // ============================================================

        function actualizarTotal() {

            let total = 0;


            document.querySelectorAll(
                '#tbody_tramites > tr'
            ).forEach(fila => {

                if (fila.id === 'fila_vacia') {
                    return;
                }


                const cantidadInput =
                    fila.querySelector(
                        'input[name*="[cantidad]"]'
                    );

                const importeInput =
                    fila.querySelector(
                        'input[name*="[importe]"]'
                    );


                if (!cantidadInput || !importeInput) {
                    return;
                }


                const cantidad =
                    parseInt(cantidadInput.value) || 1;

                const importe =
                    parseFloat(importeInput.value) || 0;


                total += cantidad * importe;

            });


            document.getElementById('total_tramites')
                .textContent =
                '$' + total.toFixed(2);


            document.getElementById('total_letras')
                .textContent =
                numeroALetras(total);

        }


        // ============================================================
        // VALIDACIÓN
        // ============================================================

        document
            .getElementById('form_tramite')
            .addEventListener('submit', function(e) {

                const filas =
                    document.querySelectorAll(
                        '#tbody_tramites > tr'
                    );


                let cantidadFilas = 0;

                filas.forEach(fila => {

                    if (fila.id !== 'fila_vacia') {
                        cantidadFilas++;
                    }

                });


                if (cantidadFilas === 0) {

                    e.preventDefault();

                    alert(
                        'El folio debe contener al menos un trámite.'
                    );

                }

            });


        // ============================================================
        // NÚMERO A LETRAS
        // ============================================================

        function numeroALetras(num) {

            const entero =
                Math.floor(num);

            const centavos =
                Math.round(
                    (num - entero) * 100
                );


            const unidades = [
                '',
                'UN',
                'DOS',
                'TRES',
                'CUATRO',
                'CINCO',
                'SEIS',
                'SIETE',
                'OCHO',
                'NUEVE',
                'DIEZ',
                'ONCE',
                'DOCE',
                'TRECE',
                'CATORCE',
                'QUINCE',
                'DIECISÉIS',
                'DIECISIETE',
                'DIECIOCHO',
                'DIECINUEVE',
                'VEINTE'
            ];


            const decenas = [
                '',
                'DIEZ',
                'VEINTE',
                'TREINTA',
                'CUARENTA',
                'CINCUENTA',
                'SESENTA',
                'SETENTA',
                'OCHENTA',
                'NOVENTA'
            ];


            function conv(n) {

                if (n === 0)
                    return 'CERO';

                if (n <= 20)
                    return unidades[n];

                if (n < 30)
                    return 'VEINTI' + unidades[n - 20];

                if (n < 100)
                    return decenas[Math.floor(n / 10)] +
                        (n % 10
                            ? ' Y ' + unidades[n % 10]
                            : '');

                if (n < 200)
                    return 'CIEN' +
                        (n > 100
                            ? 'TO ' + conv(n - 100)
                            : '');

                if (n < 1000)
                    return [
                        '',
                        'DOSCIENTOS',
                        'TRESCIENTOS',
                        'CUATROCIENTOS',
                        'QUINIENTOS',
                        'SEISCIENTOS',
                        'SETECIENTOS',
                        'OCHOCIENTOS',
                        'NOVECIENTOS'
                    ][Math.floor(n / 100)] +
                        (n % 100
                            ? ' ' + conv(n % 100)
                            : '');

                if (n < 2000)
                    return 'MIL' +
                        (n > 1000
                            ? ' ' + conv(n - 1000)
                            : '');

                return conv(Math.floor(n / 1000)) +
                    ' MIL' +
                    (n % 1000
                        ? ' ' + conv(n % 1000)
                        : '');

            }


            return `(${conv(entero)} ${String(centavos).padStart(2, '0')}/100 M.N.)`;

        }


        // ============================================================
        // INICIALIZAR TOTAL
        // ============================================================

        document.addEventListener('DOMContentLoaded', function() {

            actualizarTotal();

        });

    </script>

</x-app-layout>