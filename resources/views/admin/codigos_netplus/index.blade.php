<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Gestión de Códigos NetPlus</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-800 px-4 py-3 rounded">{{ session('error') }}</div>
            @endif

            {{-- Estadísticas --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-green-700">{{ $stats['disponibles'] }}</p>
                    <p class="text-sm text-green-600">Disponibles</p>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-blue-700">{{ $stats['vendidos'] }}</p>
                    <p class="text-sm text-blue-600">Vendidos</p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-red-700">{{ $stats['cancelados'] }}</p>
                    <p class="text-sm text-red-600">Cancelados</p>
                </div>
            </div>

            {{-- Descargar de air.com.mt --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-base font-medium text-gray-800 mb-3">Paso 1 — Descargar códigos</h3>
                <p class="text-sm text-gray-500 mb-3">
                    Descarga el archivo CSV de códigos desde el generador oficial de NetPlus.
                </p>
                <a href="http://www.air.com.mt/tools/19-codes" target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                    🌐 Abrir generador de códigos
                </a>
            </div>

            {{-- Cargar CSV --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-base font-medium text-gray-800 mb-3">Paso 2 — Cargar archivo CSV</h3>

                <div id="zona_carga">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center mb-4"
                         id="drop_zone">
                        <p class="text-gray-500 text-sm mb-3">Arrastra el archivo CSV aquí o selecciónalo</p>
                        <input type="file" id="archivo_csv" accept=".csv,.txt" class="hidden">
                        <button onclick="document.getElementById('archivo_csv').click()"
                                class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800 text-sm">
                            Seleccionar archivo
                        </button>
                        <p id="nombre_archivo" class="text-sm text-gray-400 mt-2"></p>
                    </div>

                    <button id="btn_cargar" onclick="cargarArchivo()" disabled
                            class="w-full py-2 bg-green-600 text-white rounded hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed">
                        Cargar códigos al sistema
                    </button>
                </div>

                {{-- Progreso circular --}}
                <div id="zona_progreso" class="hidden text-center py-6">
                    <svg class="mx-auto" width="120" height="120" viewBox="0 0 120 120">
                        <circle cx="60" cy="60" r="50" fill="none" stroke="#e5e7eb" stroke-width="10"/>
                        <circle id="progreso_circle" cx="60" cy="60" r="50" fill="none"
                                stroke="#16a34a" stroke-width="10"
                                stroke-dasharray="314" stroke-dashoffset="314"
                                stroke-linecap="round"
                                transform="rotate(-90 60 60)"
                                style="transition: stroke-dashoffset 0.3s ease;"/>
                        <text x="60" y="65" text-anchor="middle"
                              font-size="20" font-weight="bold" fill="#16a34a"
                              id="progreso_texto">0%</text>
                    </svg>
                    <p class="text-gray-500 text-sm mt-2" id="progreso_mensaje">Cargando...</p>
                </div>

                {{-- Resultado --}}
                <div id="zona_resultado" class="hidden mt-4"></div>

                {{-- Botón listar recientes --}}
                <div id="zona_btn_listar" class="hidden mt-4 text-center">
                    <a href="{{ route('admin.codigos-netplus.recientes') }}"
                       class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        📋 Ver códigos cargados
                    </a>
                </div>
            </div>

            {{-- Cancelar ficha --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-base font-medium text-gray-800 mb-3">Cancelar una ficha</h3>
                <form action="{{ route('admin.fichas-wifi.buscar') }}" method="GET" class="flex gap-3">
                    <input type="number" name="folio" placeholder="Folio..."
                           class="flex-1 border-gray-300 rounded-md shadow-sm text-sm">
                    <input type="text" name="codigo" placeholder="Código..."
                           class="flex-1 border-gray-300 rounded-md shadow-sm text-sm">
                    <button type="submit"
                            class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800 text-sm">
                        Buscar
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        const inputArchivo = document.getElementById('archivo_csv');
        const btnCargar    = document.getElementById('btn_cargar');

        inputArchivo.addEventListener('change', function () {
            const nombre = this.files[0]?.name ?? '';
            document.getElementById('nombre_archivo').textContent = nombre ? `📄 ${nombre}` : '';
            btnCargar.disabled = !nombre;
        });

        // Drag & drop
        const dropZone = document.getElementById('drop_zone');
        dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-green-400'); });
        dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-green-400'));
        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            dropZone.classList.remove('border-green-400');
            const file = e.dataTransfer.files[0];
            if (file) {
                const dt = new DataTransfer();
                dt.items.add(file);
                inputArchivo.files = dt.files;
                document.getElementById('nombre_archivo').textContent = `📄 ${file.name}`;
                btnCargar.disabled = false;
            }
        });

        function cargarArchivo() {
            const archivo = inputArchivo.files[0];
            if (!archivo) return;

            document.getElementById('zona_carga').classList.add('hidden');
            document.getElementById('zona_progreso').classList.remove('hidden');
            document.getElementById('zona_resultado').classList.add('hidden');
            document.getElementById('zona_btn_listar').classList.add('hidden');

            // Simular progreso mientras sube
            let progreso = 0;
            const intervalo = setInterval(() => {
                progreso = Math.min(progreso + Math.random() * 15, 90);
                actualizarProgreso(progreso);
            }, 200);

            const formData = new FormData();
            formData.append('archivo', archivo);
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ route("admin.codigos-netplus.cargar") }}', {
                method: 'POST',
                body: formData,
            })
            .then(r => r.json())
            .then(data => {
                clearInterval(intervalo);
                actualizarProgreso(100);

                setTimeout(() => {
                    document.getElementById('zona_progreso').classList.add('hidden');
                    const resultado = document.getElementById('zona_resultado');
                    resultado.classList.remove('hidden');

                    if (data.success) {
                        let html = `<div class="bg-green-50 border border-green-200 rounded p-4">
                            <p class="text-green-800 font-medium">✅ ${data.mensaje}</p>`;
                        if (data.errores?.length > 0) {
                            html += `<p class="text-yellow-700 text-sm mt-2">⚠️ ${data.errores.length} advertencia(s):</p>
                            <ul class="text-xs text-yellow-600 list-disc list-inside mt-1">
                                ${data.errores.map(e => `<li>${e}</li>`).join('')}
                            </ul>`;
                        }
                        html += `</div>`;
                        resultado.innerHTML = html;
                        document.getElementById('zona_btn_listar').classList.remove('hidden');
                    } else {
                        resultado.innerHTML = `<div class="bg-red-50 border border-red-200 rounded p-4">
                            <p class="text-red-800 font-medium">❌ ${data.mensaje}</p>
                        </div>`;
                        document.getElementById('zona_carga').classList.remove('hidden');
                    }
                }, 500);
            })
            .catch(() => {
                clearInterval(intervalo);
                document.getElementById('zona_progreso').classList.add('hidden');
                document.getElementById('zona_carga').classList.remove('hidden');
                document.getElementById('zona_resultado').classList.remove('hidden');
                document.getElementById('zona_resultado').innerHTML = `
                    <div class="bg-red-50 border border-red-200 rounded p-4">
                        <p class="text-red-800">❌ Error de conexión. Intenta de nuevo.</p>
                    </div>`;
            });
        }

        function actualizarProgreso(pct) {
            const circunferencia = 314;
            const offset = circunferencia - (pct / 100) * circunferencia;
            document.getElementById('progreso_circle').style.strokeDashoffset = offset;
            document.getElementById('progreso_texto').textContent = Math.round(pct) + '%';
            document.getElementById('progreso_mensaje').textContent =
                pct < 100 ? 'Cargando códigos...' : '¡Completado!';
        }
    </script>
</x-app-layout>