<div class="mt-8 rounded-3xl border border-slate-200 bg-slate-50 p-6">
    <h3 class="text-xl font-extrabold text-slate-900">
        Datos de contacto
    </h3>

    <p class="mt-2 text-sm text-slate-600">
        Los utilizaremos únicamente para informarte sobre el avance de tu solicitud.
    </p>

    <div class="mt-5 grid gap-5 md:grid-cols-2">

        {{-- WhatsApp --}}
        <div class="min-w-0">
            <label for="whatsapp_numero"
                   class="mb-2 block text-sm font-bold text-slate-700">
                WhatsApp
                <span class="text-red-500">*</span>
            </label>

            <input
                type="tel"
                name="whatsapp_numero"
                id="whatsapp_numero"
                value="{{ old('whatsapp_numero') }}"
                autocomplete="tel"
                inputmode="tel"
                placeholder="311 123 4567"
                required
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            >

            <input
                type="hidden"
                name="whatsapp_codigo_pais"
                id="whatsapp_codigo_pais"
                value="{{ old('whatsapp_codigo_pais', '+52') }}"
            >

            <p class="mt-2 text-xs text-slate-500">
                Selecciona el país y captura tu número de WhatsApp.
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

        {{-- Correo --}}
        <div class="min-w-0">
            <label for="correo"
                   class="mb-2 block text-sm font-bold text-slate-700">
                Correo electrónico
                <span class="text-xs font-normal text-slate-500">
                    (opcional)
                </span>
            </label>

            <input
                type="email"
                id="correo"
                name="correo"
                value="{{ old('correo') }}"
                autocomplete="email"
                placeholder="correo@ejemplo.com"
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            >

            @error('correo')
                <p class="mt-2 text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
</div>