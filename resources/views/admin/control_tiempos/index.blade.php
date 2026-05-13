<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Control de Tiempos</h2>
            <a href="{{ route('admin.control-tiempos.reporte') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm">
                📊 Reporte
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Grid de equipos --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4" id="grid_equipos">
                @foreach($equipos as $equipo)

                <div class="equipo-card rounded-2xl p-3 shadow-md cursor-pointer transition-all hover:scale-105"
                id="card_{{ $equipo->id }}"
                data-equipo-id="{{ $equipo->id }}"
                data-tipo="{{ $equipo->tipo }}"
                data-numero="{{ $equipo->numero }}"
                data-estatus="{{ $equipo->estatus }}"
                onclick="clickEquipo({{ $equipo->id }})">

                {{-- Número y tipo --}}
                <div class="text-center mb-2">
                    <span class="text-2xl font-bold" id="num_{{ $equipo->id }}">
                        {{ $equipo->numero }}
                    </span>
                    <p class="text-xs opacity-75">
                        {{ $equipo->tipo === 'computadora' ? '💻' : '🎮' }}
                        {{ ucfirst($equipo->tipo) }}
                    </p>
                </div>

                {{-- Anillo circular --}}
                <div class="flex justify-center mb-2">
                    <svg width="90" height="90" viewBox="0 0 90 90">
                        <circle cx="45" cy="45" r="38" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="8"/>
                        <circle cx="45" cy="45" r="38" fill="none" stroke="white" stroke-width="8"
                                stroke-dasharray="238.76" stroke-dashoffset="238.76"
                                stroke-linecap="round" transform="rotate(-90 45 45)"
                                id="ring_outer_{{ $equipo->id }}" style="transition: stroke-dashoffset 1s linear;"/>
                        <circle cx="45" cy="45" r="26" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="6"/>
                        <circle cx="45" cy="45" r="26" fill="none" stroke="rgba(255,255,200,0.8)" stroke-width="6"
                                stroke-dasharray="163.36" stroke-dashoffset="163.36"
                                stroke-linecap="round" transform="rotate(-90 45 45)"
                                id="ring_inner_{{ $equipo->id }}" style="transition: stroke-dashoffset 1s linear;"/>
                        <text x="45" y="41" text-anchor="middle" font-size="10" font-weight="bold" fill="white"
                            id="ring_time_{{ $equipo->id }}">--:--</text>
                        <text x="45" y="54" text-anchor="middle" font-size="7" fill="rgba(255,255,255,0.8)"
                            id="ring_label_{{ $equipo->id }}">LIBRE</text>
                    </svg>
                </div>

                {{-- Tiempos detallados --}}
                <div class="text-center text-xs space-y-1" id="tiempos_div_{{ $equipo->id }}">
                    <div id="tiempo_inicio_row_{{ $equipo->id }}" class="hidden">
                        <span class="opacity-60">Inicio:</span>
                        <span class="font-mono font-medium" id="tiempo_inicio_{{ $equipo->id }}">--:--:--</span>
                    </div>
                    <div id="tiempo_trans_row_{{ $equipo->id }}" class="hidden">
                        <span class="opacity-60" id="tiempo_trans_label_{{ $equipo->id }}">Transcurrido:</span>
                        <span class="font-mono font-bold text-sm" id="tiempo_trans_{{ $equipo->id }}">00:00:00</span>
                    </div>
                    <div id="tiempo_reserva_row_{{ $equipo->id }}" class="hidden">
                        <span class="opacity-60">Reservado:</span>
                        <span class="font-mono font-medium" id="tiempo_reserva_{{ $equipo->id }}">00:00:00</span>
                    </div>
                    <div id="tiempo_restante_row_{{ $equipo->id }}" class="hidden">
                        <span class="opacity-60">Restante:</span>
                        <span class="font-mono font-bold text-sm" id="tiempo_restante_{{ $equipo->id }}">00:00:00</span>
                    </div>
                </div>

                {{-- Costo y productos --}}
                <div class="text-center text-xs mt-2">
                    <p class="font-medium" id="status_label_{{ $equipo->id }}">Disponible</p>
                    <p class="opacity-75 mt-1" id="costo_label_{{ $equipo->id }}">$0.00</p>
                    <p class="opacity-60 mt-1" id="productos_label_{{ $equipo->id }}"></p>
                </div>
            </div>
                
                @endforeach
            </div>

        </div>
    </div>

    {{-- Modal: Iniciar Renta --}}
    <div id="modal_iniciar" class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                🟢 Iniciar Renta — Equipo <span id="modal_iniciar_num"></span>
            </h3>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tiempo asignado (opcional)</label>
                <select id="tiempo_asignado" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">Sin límite de tiempo</option>
                    <option value="15">15 minutos — $5</option>
                    <option value="30">30 minutos — $10</option>
                    <option value="45">45 minutos — $15</option>
                    <option value="60">1 hora — $20 (comp) / $15 (vjuego)</option>
                    <option value="90">1:30 horas</option>
                    <option value="120">2 horas</option>
                    <option value="180">3 horas</option>
                    <option value="240">4 horas</option>
                    <option value="300">5 horas</option>
                    <option value="360">6 horas</option>
                    <option value="420">7 horas</option>
                    <option value="480">8 horas (máximo)</option>
                </select>
            </div>
            <div class="flex justify-end gap-3">
                <button onclick="cerrarModal('modal_iniciar')"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">
                    Cancelar
                </button>
                <button onclick="confirmarIniciarRenta()"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-medium">
                    ▶ Iniciar
                </button>
            </div>
        </div>
    </div>

    {{-- Modal: Opciones de equipo en uso --}}
    <div id="modal_opciones" class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">
                Equipo <span id="modal_opciones_num"></span>
            </h3>
            <p class="text-sm text-gray-500 mb-4" id="modal_opciones_tiempo"></p>

            <div class="space-y-2">
                <button onclick="accionEquipo('pausar')"
                        id="btn_pausar_reanudar"
                        class="w-full py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 text-sm font-medium">
                    ⏸ Pausar
                </button>
                <button onclick="abrirModalProductos()"
                        class="w-full py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm font-medium">
                    🛒 Agregar Producto
                </button>
                <button onclick="abrirModalCambioEquipo()"
                        class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                    🔄 Cambiar Equipo
                </button>
                <button onclick="abrirModalCobro()"
                        class="w-full py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">
                    💰 Cobrar
                </button>
                <button onclick="cerrarModal('modal_opciones')"
                        class="w-full py-2 bg-gray-200 text-gray-700 rounded-lg text-sm">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    {{-- Modal: Agregar Producto --}}
    <div id="modal_productos" class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">🛒 Agregar Producto Extra</h3>

            <div class="mb-3">
                <input type="text" id="buscar_producto_renta"
                       placeholder="Buscar producto (clave o descripción)..."
                       class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                <div id="resultados_productos_renta" class="mt-2 hidden max-h-40 overflow-y-auto border rounded"></div>
            </div>

            <div id="producto_seleccionado_renta" class="hidden mb-3 p-3 bg-blue-50 rounded text-sm">
                <p class="font-medium" id="prod_nombre_renta"></p>
                <p class="text-gray-500" id="prod_precio_renta"></p>
                <input type="hidden" id="prod_id_renta">
                <div class="mt-2 flex items-center gap-2">
                    <label class="text-xs text-gray-600">Cantidad:</label>
                    <input type="number" id="prod_cantidad_renta" value="1" min="1"
                           class="w-20 border-gray-300 rounded text-sm text-center">
                </div>
            </div>

            <div id="lista_productos_renta" class="mb-3 max-h-32 overflow-y-auto"></div>

            <div class="flex justify-end gap-3">
                <button onclick="cerrarModal('modal_productos')"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm">Cerrar</button>
                <button onclick="confirmarAgregarProducto()"
                        id="btn_agregar_prod"
                        class="hidden px-4 py-2 bg-purple-600 text-white rounded text-sm">
                    + Agregar
                </button>
            </div>
        </div>
    </div>

    {{-- Modal: Cambiar Equipo --}}
    <div id="modal_cambio" class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">🔄 Cambiar de Equipo</h3>
            <p class="text-sm text-gray-500 mb-3">Selecciona el equipo disponible al que deseas cambiar:</p>
            <div id="lista_equipos_disponibles" class="space-y-2 max-h-48 overflow-y-auto mb-4"></div>
            <button onclick="cerrarModal('modal_cambio')"
                    class="w-full py-2 bg-gray-200 text-gray-700 rounded text-sm">Cancelar</button>
        </div>
    </div>

    {{-- Modal: Cobro --}}
    <div id="modal_cobro" class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">
                💰 Cobro — Equipo <span id="cobro_num"></span>
            </h3>
            <p class="text-sm text-gray-500 mb-4" id="cobro_tiempo"></p>

            <div class="space-y-2 text-sm mb-4">
                <div class="flex justify-between">
                    <span class="text-gray-500">Tiempo de renta:</span>
                    <span class="font-medium" id="cobro_renta">$0.00</span>
                </div>
                <div id="cobro_productos_div" class="hidden">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Productos:</span>
                        <span class="font-medium" id="cobro_productos_total">$0.00</span>
                    </div>
                    <div id="cobro_productos_lista" class="mt-1 text-xs text-gray-400 pl-3"></div>
                </div>
                <div class="flex justify-between font-bold text-lg border-t pt-2">
                    <span>TOTAL:</span>
                    <span class="text-green-700" id="cobro_total">$0.00</span>
                </div>
                <div class="text-xs text-gray-500 italic" id="cobro_letras"></div>
            </div>

            <div class="flex gap-2">
                <button onclick="cerrarModal('modal_cobro')"
                        class="flex-1 py-2 bg-gray-200 text-gray-700 rounded text-sm">
                    ▶ Continuar usando
                </button>
                <button onclick="confirmarCobro()"
                        class="flex-1 py-2 bg-green-600 text-white rounded text-sm font-medium">
                    ✅ Finalizar y Cobrar
                </button>
            </div>
        </div>
    </div>

    <script>
    const CSRF = '{{ csrf_token() }}';
    const EQUIPOS_DATA = @json($equiposData);
    const SEGUNDOS_MAX = 8 * 3600;
    const TOLERANCIA_SEGUNDOS = 3 * 60; // 3 minutos de tolerancia

    let equiposState = {};
    let timers = {};
    let parpadeoTimers = {};
    let equipoActivo = null;
    let rentaActiva  = null;

    const COLORES = {
        disponible: '#22c55e',
        en_uso:     '#3b82f6',
        pausado:    '#f59e0b',
        alerta:     '#ef4444',
        inactivo:   '#6b7280',
    };

    document.addEventListener('DOMContentLoaded', () => {
        EQUIPOS_DATA.forEach(eq => {
            equiposState[eq.id] = {
                ...eq,
                segundos:   eq.segundos_acumulados,
                horaInicio: eq.hora_inicio ? new Date(eq.hora_inicio) : null,
            };
            renderEquipo(eq.id);
            if (eq.estatus === 'en_uso' && eq.renta_id) {
                iniciarTimer(eq.id);
            }
        });
    });

    function renderEquipo(id) {
        const eq  = equiposState[id];
        const card = document.getElementById(`card_${id}`);
        if (!card) return;

        const tiempoAgotado = eq.tiempo_asignado && eq.segundos >= eq.tiempo_asignado;

        // Color de fondo
        let color = COLORES[eq.estatus] || COLORES.disponible;
        if (tiempoAgotado) color = COLORES.alerta;
        card.style.backgroundColor = color;
        card.style.color = 'white';

        // Parpadeo si tiempo agotado
        if (tiempoAgotado && !parpadeoTimers[id]) {
            parpadeoTimers[id] = setInterval(() => {
                const c = document.getElementById(`card_${id}`);
                c.style.backgroundColor = c.style.backgroundColor === 'rgb(239, 68, 68)'
                    ? '#b91c1c' : '#ef4444';
            }, 500);
        } else if (!tiempoAgotado && parpadeoTimers[id]) {
            clearInterval(parpadeoTimers[id]);
            delete parpadeoTimers[id];
        }

        // Hora de inicio
        const inicioRow = document.getElementById(`tiempo_inicio_row_${id}`);
        if (eq.estatus !== 'disponible' && eq.horaInicio) {
            inicioRow.classList.remove('hidden');
            document.getElementById(`tiempo_inicio_${id}`).textContent =
                formatHora(new Date(eq.horaInicio));
        } else {
            inicioRow?.classList.add('hidden');
        }

        // Tiempo transcurrido y restante
        const transRow    = document.getElementById(`tiempo_trans_row_${id}`);
        const restanteRow = document.getElementById(`tiempo_restante_row_${id}`);
        const reservaRow  = document.getElementById(`tiempo_reserva_row_${id}`);

        if (eq.estatus !== 'disponible') {
            transRow.classList.remove('hidden');
            document.getElementById(`tiempo_trans_label_${id}`).textContent =
                eq.tiempo_asignado ? 'Transcurrido:' : 'Transcurrido:';
            document.getElementById(`tiempo_trans_${id}`).textContent =
                formatSegundos(eq.segundos);

            if (eq.tiempo_asignado) {
                reservaRow.classList.remove('hidden');
                restanteRow.classList.remove('hidden');
                document.getElementById(`tiempo_reserva_${id}`).textContent =
                    formatSegundos(eq.tiempo_asignado);
                const restante = Math.max(0, eq.tiempo_asignado - eq.segundos);
                document.getElementById(`tiempo_restante_${id}`).textContent =
                    formatSegundos(restante);
            } else {
                reservaRow.classList.add('hidden');
                restanteRow.classList.add('hidden');
            }
        } else {
            transRow?.classList.add('hidden');
            restanteRow?.classList.add('hidden');
            reservaRow?.classList.add('hidden');
        }

        // Texto del anillo central
        const ringTime = eq.estatus !== 'disponible'
            ? (eq.tiempo_asignado
                ? formatSegundos(Math.max(0, eq.tiempo_asignado - eq.segundos)).substring(0, 5)
                : formatSegundos(eq.segundos).substring(0, 5))
            : '--:--';
        document.getElementById(`ring_time_${id}`).textContent = ringTime;
        document.getElementById(`ring_label_${id}`).textContent =
            eq.estatus === 'disponible' ? 'LIBRE' :
            eq.estatus === 'pausado'    ? 'PAUSA' :
            eq.tiempo_asignado          ? 'RESTA' : 'USO';

        // Status label
        document.getElementById(`status_label_${id}`).textContent =
            eq.estatus === 'disponible' ? 'Disponible' :
            eq.estatus === 'en_uso'     ? 'En Uso'     :
            eq.estatus === 'pausado'    ? 'Pausado'     : 'Inactivo';

        // Costo con tolerancia
        if (eq.estatus !== 'disponible') {
            const costo = calcularCosto(eq.tipo, eq.segundos);
            document.getElementById(`costo_label_${id}`).textContent = '$' + costo.toFixed(2);
        } else {
            document.getElementById(`costo_label_${id}`).textContent = '$0.00';
        }

        // Productos
        document.getElementById(`productos_label_${id}`).textContent =
            eq.num_productos > 0 ? `🛒 ${eq.num_productos} prod.` : '';

        // Anillos
        actualizarAnillos(id);
    }

    function actualizarAnillos(id) {
        const eq = equiposState[id];
        const circOuter = 238.76;
        const circInner = 163.36;

        let pct = 0;
        if (eq.estatus !== 'disponible') {
            if (eq.tiempo_asignado) {
                const restante = Math.max(0, eq.tiempo_asignado - eq.segundos);
                pct = restante / eq.tiempo_asignado;
            } else {
                pct = Math.min(eq.segundos / SEGUNDOS_MAX, 1);
            }
        }

        document.getElementById(`ring_outer_${id}`).style.strokeDashoffset =
            circOuter - (pct * circOuter);

        const maxProd = 100;
        const pctProd = Math.min((eq.total_productos || 0) / maxProd, 1);
        document.getElementById(`ring_inner_${id}`).style.strokeDashoffset =
            circInner - (pctProd * circInner);
    }

    function iniciarTimer(id) {
        if (timers[id]) clearInterval(timers[id]);

        timers[id] = setInterval(() => {
            const eq = equiposState[id];
            if (eq.estatus !== 'en_uso') { clearInterval(timers[id]); return; }

            eq.segundos++;

            if (eq.tiempo_asignado && eq.segundos >= eq.tiempo_asignado && !eq._alarmaEmitida) {
                eq._alarmaEmitida = true;
                reproducirAlarma(id);
            }

            renderEquipo(id);
        }, 1000);
    }

    function reproducirAlarma(id) {
        const eq = equiposState[id];
        if ('speechSynthesis' in window) {
            const msg = new SpeechSynthesisUtterance(`Finalizó el tiempo en equipo ${eq.numero}`);
            msg.lang = 'es-MX';
            window.speechSynthesis.speak(msg);
        }
    }

    // ---- MEJORA 4: Cálculo con tolerancia de 3 minutos ----
    function calcularCosto(tipo, segundos) {
        if (segundos <= 0) return 0;

        // Aplicar tolerancia: descontar 3 minutos
        const segundosEfectivos = Math.max(0, segundos - TOLERANCIA_SEGUNDOS);
        if (segundosEfectivos === 0) return 0;

        const minutos = Math.ceil(segundosEfectivos / 60);

        if (tipo === 'computadora') {
            return Math.ceil(minutos / 15) * 5;
        } else {
            const horas        = Math.floor(minutos / 60);
            const minRestantes = minutos % 60;
            let costo = horas * 15;
            if (minRestantes > 0 && minRestantes <= 45) {
                costo += Math.ceil(minRestantes / 15) * 5;
            } else if (minRestantes > 45) {
                costo += 15;
            }
            return costo;
        }
    }

    function clickEquipo(id) {
        const eq = equiposState[id];
        equipoActivo = id;

        if (eq.estatus === 'disponible') {
            document.getElementById('modal_iniciar_num').textContent = eq.numero;
            document.getElementById('modal_iniciar').classList.remove('hidden');
        } else if (eq.estatus === 'en_uso' || eq.estatus === 'pausado') {
            rentaActiva = eq.renta_id;
            document.getElementById('modal_opciones_num').textContent = eq.numero;
            document.getElementById('modal_opciones_tiempo').textContent =
                'Tiempo: ' + formatSegundos(eq.segundos) +
                ' — Costo: $' + calcularCosto(eq.tipo, eq.segundos).toFixed(2);

            const btnPR = document.getElementById('btn_pausar_reanudar');
            if (eq.estatus === 'pausado') {
                btnPR.textContent = '▶ Reanudar';
                btnPR.className = 'w-full py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium';
            } else {
                btnPR.textContent = '⏸ Pausar';
                btnPR.className = 'w-full py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 text-sm font-medium';
            }

            // Mostrar botón asignar tiempo si no tiene tiempo asignado
            const btnAsignar = document.getElementById('btn_asignar_tiempo');
            if (btnAsignar) {
                btnAsignar.style.display = eq.tiempo_asignado ? 'none' : 'block';
            }

            document.getElementById('modal_opciones').classList.remove('hidden');
        }
    }

    function confirmarIniciarRenta() {
        const tiempoMin = document.getElementById('tiempo_asignado').value;

        fetch('{{ route("admin.control-tiempos.iniciar") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({
                equipo_id: equipoActivo,
                tiempo_asignado_minutos: tiempoMin || null,
            }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                cerrarModal('modal_iniciar');
                const eq = equiposState[equipoActivo];
                eq.estatus         = 'en_uso';
                eq.renta_id        = data.renta.id;
                eq.segundos        = 0;
                eq.tiempo_asignado = tiempoMin ? parseInt(tiempoMin) * 60 : null;
                eq.horaInicio      = new Date();
                eq._alarmaEmitida  = false;
                renderEquipo(equipoActivo);
                iniciarTimer(equipoActivo);
            } else {
                alert(data.error || 'Error al iniciar la renta.');
            }
        });
    }

    // ---- MEJORA 3: Asignar tiempo después de iniciar ----
    function abrirModalAsignarTiempo() {
        cerrarModal('modal_opciones');
        document.getElementById('modal_asignar_tiempo').classList.remove('hidden');
    }

    function confirmarAsignarTiempo() {
        const minutos = parseInt(document.getElementById('tiempo_asignar_post').value);
        if (!minutos) { alert('Selecciona un tiempo.'); return; }

        fetch(`{{ url('admin/control-tiempos/asignar-tiempo') }}/${rentaActiva}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ minutos }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const eq = equiposState[equipoActivo];
                eq.tiempo_asignado = minutos * 60;
                eq._alarmaEmitida  = false;
                renderEquipo(equipoActivo);
                cerrarModal('modal_asignar_tiempo');
            }
        });
    }

    function accionEquipo(accion) {
        const url = accion === 'pausar'
            ? `{{ url('admin/control-tiempos/pausar') }}/${rentaActiva}`
            : `{{ url('admin/control-tiempos/reanudar') }}/${rentaActiva}`;

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({}),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const eq = equiposState[equipoActivo];
                if (accion === 'pausar') {
                    eq.estatus  = 'pausado';
                    eq.segundos = data.segundos;
                    clearInterval(timers[equipoActivo]);
                } else {
                    eq.estatus    = 'en_uso';
                    eq.horaInicio = new Date();
                    iniciarTimer(equipoActivo);
                }
                renderEquipo(equipoActivo);
                cerrarModal('modal_opciones');
            }
        });
    }

    function abrirModalProductos() {
        cerrarModal('modal_opciones');
        cargarProductosRenta();
        document.getElementById('modal_productos').classList.remove('hidden');

        const buscarInput = document.getElementById('buscar_producto_renta');
        buscarInput.oninput = function() {
            const q = this.value.trim();
            if (q.length < 2) {
                document.getElementById('resultados_productos_renta').classList.add('hidden');
                return;
            }
            fetch(`{{ route('admin.ventas.buscar-producto') }}?q=${encodeURIComponent(q)}`)
                .then(r => r.json())
                .then(productos => {
                    const div = document.getElementById('resultados_productos_renta');
                    div.classList.remove('hidden');
                    div.innerHTML = productos.map(p => `
                        <div class="p-2 hover:bg-blue-50 cursor-pointer text-sm flex justify-between"
                            onclick="seleccionarProductoRenta(${p.id}, '${p.descripcion}', ${p.precio_unitario})">
                            <span><span class="font-mono text-xs text-gray-400">${p.clave}</span> ${p.descripcion}</span>
                            <span class="text-green-600">$${parseFloat(p.precio_unitario).toFixed(2)}</span>
                        </div>
                    `).join('') || '<p class="p-2 text-sm text-gray-400">Sin resultados</p>';
                });
        };
    }

    function seleccionarProductoRenta(id, nombre, precio) {
        document.getElementById('prod_id_renta').value    = id;
        document.getElementById('prod_nombre_renta').textContent = nombre;
        document.getElementById('prod_precio_renta').textContent = '$' + parseFloat(precio).toFixed(2);
        document.getElementById('producto_seleccionado_renta').classList.remove('hidden');
        document.getElementById('btn_agregar_prod').classList.remove('hidden');
        document.getElementById('resultados_productos_renta').classList.add('hidden');
        document.getElementById('buscar_producto_renta').value = '';
    }

    function cargarProductosRenta() {
        fetch(`{{ url('admin/control-tiempos/calcular-cobro') }}/${rentaActiva}`)
            .then(r => r.json())
            .then(data => {
                const lista = document.getElementById('lista_productos_renta');
                if (data.productos && data.productos.length > 0) {
                    lista.innerHTML = '<p class="text-xs text-gray-500 mb-1">Productos agregados:</p>' +
                        data.productos.map(p =>
                            `<div class="text-xs flex justify-between text-gray-600">
                                <span>${p.producto.descripcion} x${p.cantidad}</span>
                                <span>$${parseFloat(p.subtotal).toFixed(2)}</span>
                            </div>`
                        ).join('');
                } else {
                    lista.innerHTML = '<p class="text-xs text-gray-400">Sin productos agregados.</p>';
                }
            });
    }

    function confirmarAgregarProducto() {
        const prodId   = document.getElementById('prod_id_renta').value;
        const cantidad = document.getElementById('prod_cantidad_renta').value;
        if (!prodId) { alert('Selecciona un producto.'); return; }

        fetch(`{{ url('admin/control-tiempos/agregar-producto') }}/${rentaActiva}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ producto_id: prodId, cantidad }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const eq = equiposState[equipoActivo];
                eq.total_productos = data.total_productos;
                eq.num_productos   = (eq.num_productos || 0) + 1;
                renderEquipo(equipoActivo);
                document.getElementById('producto_seleccionado_renta').classList.add('hidden');
                document.getElementById('btn_agregar_prod').classList.add('hidden');
                document.getElementById('prod_id_renta').value = '';
                cargarProductosRenta();
            } else {
                alert(data.error || 'Error al agregar producto.');
            }
        });
    }

    function abrirModalCambioEquipo() {
        cerrarModal('modal_opciones');
        const lista = document.getElementById('lista_equipos_disponibles');
        lista.innerHTML = '';

        Object.values(equiposState).forEach(eq => {
            if (eq.estatus === 'disponible' && eq.id !== equipoActivo) {
                const btn = document.createElement('button');
                btn.className = 'w-full py-2 px-3 border rounded-lg text-sm text-left hover:bg-blue-50 flex justify-between items-center';
                btn.innerHTML = `
                    <span>${eq.tipo === 'computadora' ? '💻' : '🎮'} Equipo ${eq.numero}</span>
                    <span class="text-green-600 text-xs">Disponible</span>
                `;
                btn.onclick = () => confirmarCambioEquipo(eq.id);
                lista.appendChild(btn);
            }
        });

        if (!lista.children.length) {
            lista.innerHTML = '<p class="text-sm text-gray-400 text-center py-4">No hay equipos disponibles.</p>';
        }
        document.getElementById('modal_cambio').classList.remove('hidden');
    }

    function confirmarCambioEquipo(nuevoEquipoId) {
        fetch(`{{ url('admin/control-tiempos/cambiar-equipo') }}/${rentaActiva}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ nuevo_equipo_id: nuevoEquipoId }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const eqAnt  = equiposState[equipoActivo];
                const eqNuevo = equiposState[nuevoEquipoId];

                eqNuevo.estatus         = 'en_uso';
                eqNuevo.renta_id        = eqAnt.renta_id;
                eqNuevo.segundos        = eqAnt.segundos;
                eqNuevo.tiempo_asignado = eqAnt.tiempo_asignado;
                eqNuevo.total_productos = eqAnt.total_productos;
                eqNuevo.num_productos   = eqAnt.num_productos;
                eqNuevo.horaInicio      = new Date();

                eqAnt.estatus         = 'disponible';
                eqAnt.renta_id        = null;
                eqAnt.segundos        = 0;
                eqAnt.tiempo_asignado = null;
                eqAnt.total_productos = 0;
                eqAnt.num_productos   = 0;

                clearInterval(timers[equipoActivo]);
                rentaActiva  = eqNuevo.renta_id;
                equipoActivo = nuevoEquipoId;

                renderEquipo(equipoActivo);
                renderEquipo(nuevoEquipoId);
                iniciarTimer(nuevoEquipoId);
                cerrarModal('modal_cambio');
            } else {
                alert(data.error || 'Error al cambiar equipo.');
            }
        });
    }

    // ---- MEJORA 5: Bug cobro total en cero ----
    function abrirModalCobro() {
        cerrarModal('modal_opciones');
        const eq = equiposState[equipoActivo];

        if (timers[equipoActivo]) clearInterval(timers[equipoActivo]);

        // Calcular costo localmente con los segundos actuales
        const segundosActuales = eq.segundos;
        const costoRenta       = calcularCosto(eq.tipo, segundosActuales);
        const totalProductos   = eq.total_productos || 0;
        const total            = costoRenta + totalProductos;

        document.getElementById('cobro_num').textContent    = eq.numero;
        document.getElementById('cobro_tiempo').textContent = 'Tiempo: ' + formatSegundos(segundosActuales);
        document.getElementById('cobro_renta').textContent  = '$' + costoRenta.toFixed(2);
        document.getElementById('cobro_total').textContent  = '$' + total.toFixed(2);
        document.getElementById('cobro_letras').textContent = numeroALetras(total);

        // Cargar productos desde servidor para mostrar detalle
        fetch(`{{ url('admin/control-tiempos/calcular-cobro') }}/${rentaActiva}`)
            .then(r => r.json())
            .then(data => {
                if (data.total_productos > 0 && data.productos.length > 0) {
                    document.getElementById('cobro_productos_div').classList.remove('hidden');
                    document.getElementById('cobro_productos_total').textContent =
                        '$' + parseFloat(data.total_productos).toFixed(2);
                    document.getElementById('cobro_productos_lista').innerHTML =
                        data.productos.map(p =>
                            `${p.producto.descripcion} x${p.cantidad} = $${parseFloat(p.subtotal).toFixed(2)}`
                        ).join('<br>');
                } else {
                    document.getElementById('cobro_productos_div').classList.add('hidden');
                }
            });

        document.getElementById('modal_cobro').classList.remove('hidden');
    }

    function confirmarCobro() {
        fetch(`{{ url('admin/control-tiempos/cobrar') }}/${rentaActiva}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({}),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const eq = equiposState[equipoActivo];
                eq.estatus         = 'disponible';
                eq.renta_id        = null;
                eq.segundos        = 0;
                eq.tiempo_asignado = null;
                eq.total_productos = 0;
                eq.num_productos   = 0;
                eq._alarmaEmitida  = false;
                if (parpadeoTimers[equipoActivo]) {
                    clearInterval(parpadeoTimers[equipoActivo]);
                    delete parpadeoTimers[equipoActivo];
                }
                clearInterval(timers[equipoActivo]);
                renderEquipo(equipoActivo);
                cerrarModal('modal_cobro');
            } else {
                alert(data.error || 'Error al cobrar.');
            }
        });
    }

    function cerrarModal(id) {
        document.getElementById(id).classList.add('hidden');
        if (id === 'modal_cobro' && equipoActivo) {
            const eq = equiposState[equipoActivo];
            if (eq && eq.estatus === 'en_uso') iniciarTimer(equipoActivo);
        }
    }

    function formatSegundos(seg) {
        seg = Math.max(0, Math.floor(seg));
        const h = Math.floor(seg / 3600);
        const m = Math.floor((seg % 3600) / 60);
        const s = seg % 60;
        return `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
    }

    function formatHora(fecha) {
        const h = String(fecha.getHours()).padStart(2,'0');
        const m = String(fecha.getMinutes()).padStart(2,'0');
        const s = String(fecha.getSeconds()).padStart(2,'0');
        return `${h}:${m}:${s}`;
    }

    function numeroALetras(num) {
        const entero = Math.floor(num);
        const centavos = Math.round((num - entero) * 100);
        const unidades = ['','UN','DOS','TRES','CUATRO','CINCO','SEIS','SIETE','OCHO','NUEVE',
            'DIEZ','ONCE','DOCE','TRECE','CATORCE','QUINCE','DIECISÉIS','DIECISIETE','DIECIOCHO','DIECINUEVE','VEINTE'];
        const decenas = ['','DIEZ','VEINTE','TREINTA','CUARENTA','CINCUENTA','SESENTA','SETENTA','OCHENTA','NOVENTA'];

        function convertir(n) {
            if (n === 0) return 'CERO';
            if (n <= 20) return unidades[n];
            if (n < 30)  return 'VEINTI' + unidades[n-20];
            if (n < 100) return decenas[Math.floor(n/10)] + (n%10 ? ' Y ' + unidades[n%10] : '');
            if (n < 200) return 'CIEN' + (n > 100 ? 'TO ' + convertir(n-100) : '');
            if (n < 1000) return ['','DOSCIENTOS','TRESCIENTOS','CUATROCIENTOS','QUINIENTOS','SEISCIENTOS','SETECIENTOS','OCHOCIENTOS','NOVECIENTOS'][Math.floor(n/100)] + (n%100 ? ' ' + convertir(n%100) : '');
            if (n < 2000) return 'MIL' + (n > 1000 ? ' ' + convertir(n-1000) : '');
            return convertir(Math.floor(n/1000)) + ' MIL' + (n%1000 ? ' ' + convertir(n%1000) : '');
        }
        return `(${convertir(entero)} ${String(centavos).padStart(2,'0')}/100 M.N.)`;
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape')
            ['modal_iniciar','modal_opciones','modal_productos','modal_cambio','modal_cobro','modal_asignar_tiempo']
                .forEach(m => cerrarModal(m));
    });
    </script>


</x-app-layout>