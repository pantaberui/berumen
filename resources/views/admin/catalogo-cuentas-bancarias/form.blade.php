@php
    $esEdicion = $cuenta->exists;
@endphp

<div class="space-y-6">

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4">
            <p class="font-bold text-red-800">
                Revisa la información capturada.
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-black text-gray-900">
            Identificación de la cuenta
        </h2>

        <div class="mt-5 grid gap-5 md:grid-cols-2">
            <div>
                <label for="alias" class="mb-1 block text-sm font-bold text-gray-700">
                    Alias
                </label>

                <input
                    id="alias"
                    type="text"
                    name="alias"
                    value="{{ old('alias', $cuenta->alias) }}"
                    maxlength="100"
                    required
                    placeholder="Ejemplo: Cuenta principal"
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

                <p class="mt-1 text-xs text-gray-500">
                    Nombre interno para identificar la cuenta.
                </p>
            </div>

            <div>
                <label for="slug" class="mb-1 block text-sm font-bold text-gray-700">
                    Slug
                </label>

                <input
                    id="slug"
                    type="text"
                    name="slug"
                    value="{{ old('slug', $cuenta->slug) }}"
                    maxlength="255"
                    required
                    placeholder="cuenta-principal"
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

                <p class="mt-1 text-xs text-gray-500">
                    Utiliza letras minúsculas, números y guiones.
                </p>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-black text-gray-900">
            Información bancaria
        </h2>

        <div class="mt-5 grid gap-5 md:grid-cols-2">
            <div>
                <label for="banco" class="mb-1 block text-sm font-bold text-gray-700">
                    Banco
                </label>

                <select
                    id="banco"
                    name="banco"
                    required
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                    <option value="">Selecciona un banco</option>

                    @foreach ([
                        'BBVA',
                        'Banorte',
                        'Santander',
                        'HSBC',
                        'Scotiabank',
                        'Citibanamex',
                        'Banco Azteca',
                        'BanCoppel',
                        'Inbursa',
                        'Afirme',
                        'Banregio',
                        'Banco del Bajío',
                        'Nu',
                        'Mercado Pago',
                        'Otro',
                    ] as $banco)
                        <option
                            value="{{ $banco }}"
                            @selected(old('banco', $cuenta->banco) === $banco)
                        >
                            {{ $banco }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="titular" class="mb-1 block text-sm font-bold text-gray-700">
                    Titular
                </label>

                <input
                    id="titular"
                    type="text"
                    name="titular"
                    value="{{ old('titular', $cuenta->titular) }}"
                    maxlength="150"
                    required
                    placeholder="Nombre completo del titular"
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            <div>
                <label for="numero_cuenta" class="mb-1 block text-sm font-bold text-gray-700">
                    Número de cuenta
                </label>

                <input
                    id="numero_cuenta"
                    type="text"
                    inputmode="numeric"
                    name="numero_cuenta"
                    value="{{ old('numero_cuenta', $cuenta->numero_cuenta) }}"
                    maxlength="30"
                    placeholder="Número de cuenta"
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            <div>
                <label for="clabe_interbancaria" class="mb-1 block text-sm font-bold text-gray-700">
                    CLABE interbancaria
                </label>

                <input
                    id="clabe_interbancaria"
                    type="text"
                    inputmode="numeric"
                    name="clabe_interbancaria"
                    value="{{ old('clabe_interbancaria', $cuenta->clabe_interbancaria) }}"
                    maxlength="18"
                    placeholder="18 dígitos"
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            <div>
                <label for="numero_tarjeta" class="mb-1 block text-sm font-bold text-gray-700">
                    Número de tarjeta
                </label>

                <input
                    id="numero_tarjeta"
                    type="text"
                    inputmode="numeric"
                    name="numero_tarjeta"
                    value="{{ old('numero_tarjeta', $cuenta->numero_tarjeta) }}"
                    maxlength="19"
                    placeholder="Número de tarjeta"
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            <div>
                <label for="tipo_cuenta" class="mb-1 block text-sm font-bold text-gray-700">
                    Tipo de cuenta
                </label>

                <input
                    id="tipo_cuenta"
                    type="text"
                    name="tipo_cuenta"
                    value="{{ old('tipo_cuenta', $cuenta->tipo_cuenta) }}"
                    maxlength="50"
                    placeholder="Débito, cheques, empresarial..."
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            <div>
                <label for="moneda" class="mb-1 block text-sm font-bold text-gray-700">
                    Moneda
                </label>

                <select
                    id="moneda"
                    name="moneda"
                    required
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                    <option value="MXN" @selected(old('moneda', $cuenta->moneda) === 'MXN')>
                        MXN
                    </option>

                    <option value="USD" @selected(old('moneda', $cuenta->moneda) === 'USD')>
                        USD
                    </option>
                </select>
            </div>

            <div>
                <label for="logo" class="mb-1 block text-sm font-bold text-gray-700">
                    Archivo del logo
                </label>

                <input
                    id="logo"
                    type="text"
                    name="logo"
                    value="{{ old('logo', $cuenta->logo) }}"
                    maxlength="255"
                    placeholder="bbva.webp"
                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >

                <p class="mt-1 text-xs text-gray-500">
                    El archivo debe existir en <code>public/images/bancos</code>.
                </p>

                @if ($cuenta->logo_url)
                    <div class="mt-3 rounded-xl border border-gray-200 bg-gray-50 p-3">
                        <img
                            src="{{ $cuenta->logo_url }}"
                            alt="Logo de {{ $cuenta->banco }}"
                            class="h-12 max-w-[220px] object-contain"
                        >
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-5 rounded-xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800">
            Debes proporcionar al menos uno de estos datos: número de cuenta, CLABE o número de tarjeta.
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-black text-gray-900">
            Configuración
        </h2>

        <div class="mt-5 grid gap-4 md:grid-cols-2">
            <label class="flex items-start gap-3 rounded-xl border border-gray-200 p-4">
                <input
                    type="checkbox"
                    name="acepta_transferencia"
                    value="1"
                    @checked(old('acepta_transferencia', $cuenta->acepta_transferencia))
                    class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                >

                <span>
                    <span class="block font-bold text-gray-900">
                        Acepta transferencia
                    </span>

                    <span class="text-sm text-gray-500">
                        Mostrar esta cuenta para pagos mediante transferencia.
                    </span>
                </span>
            </label>

            <label class="flex items-start gap-3 rounded-xl border border-gray-200 p-4">
                <input
                    type="checkbox"
                    name="acepta_deposito"
                    value="1"
                    @checked(old('acepta_deposito', $cuenta->acepta_deposito))
                    class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                >

                <span>
                    <span class="block font-bold text-gray-900">
                        Acepta depósito
                    </span>

                    <span class="text-sm text-gray-500">
                        Mostrar esta cuenta para depósitos bancarios.
                    </span>
                </span>
            </label>

            <label class="flex items-start gap-3 rounded-xl border border-gray-200 p-4">
                <input
                    type="checkbox"
                    name="es_principal"
                    value="1"
                    @checked(old('es_principal', $cuenta->es_principal))
                    class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                >

                <span>
                    <span class="block font-bold text-gray-900">
                        Cuenta principal
                    </span>

                    <span class="text-sm text-gray-500">
                        Al marcarla, las demás cuentas dejarán de ser principales.
                    </span>
                </span>
            </label>

            <label class="flex items-start gap-3 rounded-xl border border-gray-200 p-4">
                <input
                    type="checkbox"
                    name="activo"
                    value="1"
                    @checked(old('activo', $cuenta->activo))
                    class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                >

                <span>
                    <span class="block font-bold text-gray-900">
                        Cuenta activa
                    </span>

                    <span class="text-sm text-gray-500">
                        Solo las cuentas activas podrán mostrarse al cliente.
                    </span>
                </span>
            </label>
        </div>

        <div class="mt-5">
            <label for="orden" class="mb-1 block text-sm font-bold text-gray-700">
                Orden
            </label>

            <input
                id="orden"
                type="number"
                name="orden"
                value="{{ old('orden', $cuenta->orden ?? 1) }}"
                min="1"
                max="9999"
                required
                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 md:w-48"
            >
        </div>

        <div class="mt-5">
            <label for="instrucciones" class="mb-1 block text-sm font-bold text-gray-700">
                Instrucciones para el cliente
            </label>

            <textarea
                id="instrucciones"
                name="instrucciones"
                rows="5"
                maxlength="2000"
                placeholder="Ejemplo: Utiliza la referencia de pago como concepto de la transferencia."
                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >{{ old('instrucciones', $cuenta->instrucciones) }}</textarea>
        </div>
    </div>

    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
        <a
            href="{{ route('admin.catalogo-cuentas-bancarias.index') }}"
            class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 font-bold text-gray-700 hover:bg-gray-50"
        >
            Cancelar
        </a>

        <button
            type="submit"
            class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 font-bold text-white hover:bg-indigo-700"
        >
            {{ $esEdicion ? 'Actualizar cuenta' : 'Guardar cuenta' }}
        </button>
    </div>
</div>