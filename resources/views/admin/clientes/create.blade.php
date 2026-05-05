<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nuevo Cliente</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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

                <form action="{{ route('admin.clientes.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre *</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}"
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
                            <input type="text" name="curp" id="curp"
                                value="{{ old('curp') }}"
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                maxlength="18" placeholder="BADD110313HCMLNS09">
                            <p id="error_curp" class="hidden text-red-600 text-xs mt-1">
                                Formato inválido. Ejemplo: BADD110313HCMLNS09
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">RFC</label>
                            <input type="text" name="rfc" id="rfc"
                                value="{{ old('rfc') }}"
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                maxlength="13" placeholder="BADD110313AB3">
                            <p id="error_rfc" class="hidden text-red-600 text-xs mt-1">
                                Formato inválido. Ejemplo: BADD110313AB3 (13 caracteres, persona física)
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ciudad / Localidad</label>
                            <select name="ciudad" id="ciudad" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach([
                                    'SAN JOSÉ DE MOJARRAS', 'COLONIA MODERNA', 'CERRO BLANCO',
                                    'RINCÓN DE CALIMAYO', 'EL HUANACAXTLE', 'LAS CUEVAS',
                                    'MIGUEL HIDALGO', 'BUCKINGHAM', 'SANTA MARÍA DEL ORO', 'SAN LUIS DE LOZADA'
                                ] as $ciudad)
                                    <option value="{{ $ciudad }}" {{ old('ciudad', 'SAN JOSÉ DE MOJARRAS') == $ciudad ? 'selected' : '' }}>
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

    <script>
        // Validar CURP en tiempo real
        document.getElementById('curp')?.addEventListener('input', function () {
            const val = this.value.toUpperCase();
            const regex = /^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z0-9]\d$/;
            const error = document.getElementById('error_curp');
            if (val.length === 18 && !regex.test(val)) {
                error.classList.remove('hidden');
            } else {
                error.classList.add('hidden');
            }
        });

        // Validar RFC en tiempo real
        document.getElementById('rfc')?.addEventListener('input', function () {
            const val = this.value.toUpperCase();
            const regex = /^[A-Z]{4}\d{6}[A-Z0-9]{3}$/;
            const error = document.getElementById('error_rfc');
            if (val.length === 13 && !regex.test(val)) {
                error.classList.remove('hidden');
            } else {
                error.classList.add('hidden');
            }
        });
    </script>


</x-app-layout>