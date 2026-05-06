<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nuevo Cliente</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Buscador previo --}}
            <div class="bg-white shadow-sm rounded-lg p-6" id="buscador_section">
                <h3 class="text-base font-medium text-gray-800 mb-4">
                    Primero verifica si el cliente ya está registrado
                </h3>
                <div class="flex gap-3">
                    <input type="text" id="buscar_input"
                           placeholder="Escribe nombre, apellido, RFC o CURP (mínimo 3 caracteres)..."
                           class="flex-1 border-gray-300 rounded-md shadow-sm">
                    <button onclick="buscarCliente()"
                            class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                        Buscar
                    </button>
                </div>

                {{-- Resultados --}}
                <div id="resultados" class="mt-4 hidden">
                    <div id="lista_resultados"></div>
                </div>

                {{-- No encontrado --}}
                <div id="no_encontrado" class="hidden mt-4">
                    <div class="bg-green-50 border border-green-200 rounded p-4 flex items-center justify-between">
                        <div>
                            <p class="text-green-800 font-medium">✓ Cliente no registrado</p>
                            <p class="text-green-600 text-sm">Puedes proceder con el registro.</p>
                        </div>
                        <button onclick="habilitarFormulario()"
                                class="px-4 py-2 bg-blue-600 text-white font-medium rounded hover:bg-blue-700 shadow">
                            + Registrar nuevo cliente
                        </button>
                    </div>
                </div>
            </div>

            {{-- Formulario (deshabilitado por defecto) --}}
            <div id="formulario_section" class="hidden">
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-base font-medium text-gray-800 mb-4">Datos del nuevo cliente</h3>

                    @if($errors->any())
                        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.clientes.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombre *</label>
                                <input type="text" name="nombre" id="f_nombre" value="{{ old('nombre') }}"
                                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Apellido Paterno *</label>
                                <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno') }}"
                                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Apellido Materno</label>
                                <input type="text" name="apellido_materno" value="{{ old('apellido_materno') }}"
                                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                                <input type="text" name="telefono" value="{{ old('telefono') }}"
                                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Celular</label>
                                <input type="text" name="celular" value="{{ old('celular') }}"
                                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">CURP</label>
                                <input type="text" name="curp" id="curp" value="{{ old('curp') }}"
                                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm" maxlength="18"
                                       placeholder="BADD110313HCMLNS09">
                                <p id="error_curp" class="hidden text-red-600 text-xs mt-1">
                                    Formato inválido. Ejemplo: BADD110313HCMLNS09
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">RFC</label>
                                <input type="text" name="rfc" id="rfc" value="{{ old('rfc') }}"
                                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm" maxlength="13"
                                       placeholder="BADD110313AB3">
                                <p id="error_rfc" class="hidden text-red-600 text-xs mt-1">
                                    Formato inválido. Ejemplo: BADD110313AB3
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ciudad</label>
                                <select name="ciudad" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach([
                                        'SAN JOSÉ DE MOJARRAS','COLONIA MODERNA','CERRO BLANCO',
                                        'RINCÓN DE CALIMAYO','EL HUANACAXTLE','LAS CUEVAS',
                                        'MIGUEL HIDALGO','BUCKINGHAM','SANTA MARÍA DEL ORO','SAN LUIS DE LOZADA'
                                    ] as $ciudad)
                                        <option value="{{ $ciudad }}"
                                            {{ old('ciudad','SAN JOSÉ DE MOJARRAS') == $ciudad ? 'selected' : '' }}>
                                            {{ $ciudad }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Calle</label>
                                <input type="text" name="calle" value="{{ old('calle') }}"
                                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Número Exterior</label>
                                <input type="text" name="numero_exterior" value="{{ old('numero_exterior') }}"
                                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Colonia</label>
                                <input type="text" name="colonia" value="{{ old('colonia') }}"
                                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Código Postal</label>
                                <input type="text" name="codigo_postal" value="{{ old('codigo_postal') }}"
                                       class="mt-1 w-full border-gray-300 rounded-md shadow-sm" maxlength="10">
                            </div>

                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Referencias</label>
                                <textarea name="referencias" rows="3"
                                          class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('referencias') }}</textarea>
                            </div>

                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.clientes.index') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Guardar Cliente
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Si hay errores de validación, mostrar el formulario directamente
        @if($errors->any() || old('nombre'))
            document.addEventListener('DOMContentLoaded', function () {
                habilitarFormulario();
            });
        @endif

        function buscarCliente() {
            const termino = document.getElementById('buscar_input').value.trim();
            if (termino.length < 3) {
                alert('Escribe al menos 3 caracteres para buscar.');
                return;
            }

            fetch(`{{ route('admin.clientes.buscar') }}?q=${encodeURIComponent(termino)}`)
                .then(res => res.json())
                .then(clientes => {
                    const resultados  = document.getElementById('resultados');
                    const lista       = document.getElementById('lista_resultados');
                    const noEncontrado = document.getElementById('no_encontrado');

                    if (clientes.length === 0) {
                        resultados.classList.add('hidden');
                        noEncontrado.classList.remove('hidden');
                    } else {
                        noEncontrado.classList.add('hidden');
                        resultados.classList.remove('hidden');

                        lista.innerHTML = `
                            <p class="text-sm font-medium text-gray-700 mb-2">
                                Se encontraron ${clientes.length} cliente(s):
                            </p>
                            <div class="space-y-2">
                                ${clientes.map(c => `
                                    <div class="flex items-center justify-between border rounded p-3 bg-yellow-50">
                                        <div class="text-sm">
                                            <p class="font-medium text-gray-900">${c.nombre} ${c.apellido_paterno} ${c.apellido_materno ?? ''}</p>
                                            <p class="text-gray-500">RFC: ${c.rfc ?? '—'} | CURP: ${c.curp ?? '—'} | Ciudad: ${c.ciudad ?? '—'}</p>
                                        </div>
                                        <a href="/admin/clientes/${c.id}/edit"
                                           class="ml-4 px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm whitespace-nowrap">
                                            Ver / Editar
                                        </a>
                                    </div>
                                `).join('')}
                            </div>
                            <div class="mt-3 text-sm text-gray-500">
                                ¿No es ninguno de estos?
                                <button onclick="habilitarFormulario()"
                                        class="text-blue-600 hover:underline ml-1">
                                    Registrar como nuevo cliente
                                </button>
                            </div>
                        `;
                    }
                });
        }

        function habilitarFormulario() {
            document.getElementById('formulario_section').classList.remove('hidden');
            document.getElementById('formulario_section').scrollIntoView({ behavior: 'smooth' });
            setTimeout(() => document.getElementById('f_nombre').focus(), 400);
        }

        // Buscar también con Enter
        document.getElementById('buscar_input').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') buscarCliente();
        });

        // Validaciones CURP y RFC
        document.getElementById('curp')?.addEventListener('input', function () {
            const regex = /^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z0-9]\d$/;
            const error = document.getElementById('error_curp');
            if (this.value.length === 18 && !regex.test(this.value)) {
                error.classList.remove('hidden');
            } else {
                error.classList.add('hidden');
            }
        });

        document.getElementById('rfc')?.addEventListener('input', function () {
            const regex = /^[A-Z]{4}\d{6}[A-Z0-9]{3}$/;
            const error = document.getElementById('error_rfc');
            if (this.value.length === 13 && !regex.test(this.value)) {
                error.classList.remove('hidden');
            } else {
                error.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>