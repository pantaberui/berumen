<div class="mt-8 rounded-3xl border border-slate-200 bg-slate-50 p-6">
    <h3 class="text-xl font-extrabold text-slate-900">
        Datos de contacto
    </h3>

    <p class="text-sm text-slate-600 mt-2">
        Los utilizaremos únicamente para informarte sobre el avance de tu solicitud.
    </p>

    <div class="mt-5 grid md:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">
                WhatsApp <span class="text-red-500">*</span>
            </label>

            <div class="grid grid-cols-[130px_minmax(0,1fr)] gap-2">
                <select
                    name="whatsapp_codigo_pais"
                    id="whatsapp_codigo_pais"
                    class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required
                >
                    <option value="+52" @selected(old('whatsapp_codigo_pais', '+52') === '+52')>
                        🇲🇽 +52
                    </option>

                    <option value="+1" @selected(old('whatsapp_codigo_pais') === '+1')>
                        🇺🇸 +1
                    </option>

                    <option value="+34" @selected(old('whatsapp_codigo_pais') === '+34')>
                        🇪🇸 +34
                    </option>

                    <option value="+502" @selected(old('whatsapp_codigo_pais') === '+502')>
                        🇬🇹 +502
                    </option>

                    <option value="+503" @selected(old('whatsapp_codigo_pais') === '+503')>
                        🇸🇻 +503
                    </option>

                    <option value="+504" @selected(old('whatsapp_codigo_pais') === '+504')>
                        🇭🇳 +504
                    </option>

                    <option value="+505" @selected(old('whatsapp_codigo_pais') === '+505')>
                        🇳🇮 +505
                    </option>

                    <option value="+506" @selected(old('whatsapp_codigo_pais') === '+506')>
                        🇨🇷 +506
                    </option>

                    <option value="+507" @selected(old('whatsapp_codigo_pais') === '+507')>
                        🇵🇦 +507
                    </option>

                    <option value="+57" @selected(old('whatsapp_codigo_pais') === '+57')>
                        🇨🇴 +57
                    </option>
                </select>

                <input
                    type="tel"
                    name="whatsapp_numero"
                    id="whatsapp_numero"
                    value="{{ old('whatsapp_numero') }}"
                    inputmode="numeric"
                    autocomplete="tel-national"
                    placeholder="3111234567"
                    required
                    class="min-w-0 w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            <p class="mt-2 text-xs text-slate-500">
                Selecciona el país y captura únicamente el número local.
            </p>

            @error('whatsapp_codigo_pais')
                <p class="mt-2 text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror

            @error('whatsapp_numero')
                <p class="mt-2 text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label for="correo" class="block text-sm font-bold text-slate-700 mb-2">
                Correo electrónico
                <span class="text-xs font-normal text-slate-500">(opcional)</span>
            </label>

            <input
                type="email"
                id="correo"
                name="correo"
                value="{{ old('correo') }}"
                autocomplete="email"
                placeholder="correo@ejemplo.com"
                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            >

            @error('correo')
                <p class="text-sm text-red-600 font-semibold mt-2">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
</div>