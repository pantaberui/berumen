<div class="mt-8 rounded-3xl border border-slate-200 bg-slate-50 p-6">
    <h3 class="text-xl font-extrabold text-slate-900">
        Verificación de seguridad
    </h3>

    <p class="mt-2 text-sm text-slate-600">
        Confirma que la solicitud está siendo realizada por una persona.
    </p>

    <div class="mt-5">
        <label for="captcha"
               class="mb-2 block text-sm font-bold text-slate-700">
            Código de seguridad
            <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            id="captcha"
            name="captcha"
            value="{{ old('captcha') }}"
            autocomplete="off"
            required
            class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
        >

        @error('captcha')
            <p class="mt-2 text-sm font-semibold text-red-600">
                {{ $message }}
            </p>
        @enderror
    </div>
</div>