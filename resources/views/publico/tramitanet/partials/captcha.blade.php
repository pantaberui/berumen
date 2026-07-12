<div class="mt-8 rounded-3xl border border-slate-200 bg-slate-50 p-6">
    <h3 class="text-xl font-extrabold text-slate-900">
        Verificación de seguridad
    </h3>

    <p class="mt-2 text-sm text-slate-600">
        Escribe los caracteres mostrados para confirmar que eres una persona.
    </p>

    <div class="mt-5 grid gap-5 md:grid-cols-[260px_minmax(0,1fr)] md:items-end">
        <div>
            <div class="overflow-hidden rounded-2xl border border-slate-300 bg-white">
                <img
                    id="captcha-imagen"
                    src="{{ route('tramitanet.captcha') }}?v={{ now()->timestamp }}"
                    alt="Código de seguridad"
                    class="h-[90px] w-full object-cover"
                >
            </div>

            <button
                type="button"
                id="captcha-recargar"
                class="mt-2 inline-flex items-center gap-2 text-sm font-bold text-blue-700 hover:text-blue-900"
            >
                ↻ Mostrar otro código
            </button>
        </div>

        <div>
            <label for="captcha"
                   class="mb-2 block text-sm font-bold text-slate-700">
                Código de seguridad
                <span class="text-red-500">*</span>
            </label>

            <input
                type="text"
                id="captcha"
                name="captcha"
                value=""
                maxlength="5"
                autocomplete="off"
                autocapitalize="characters"
                spellcheck="false"
                required
                placeholder="Escribe los 5 caracteres"
                class="w-full rounded-xl border-slate-300 bg-white uppercase shadow-sm focus:border-violet-500 focus:ring-violet-500"
            >

            @error('captcha')
                <p class="mt-2 text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const imagen = document.getElementById('captcha-imagen');
                const boton = document.getElementById('captcha-recargar');
                const input = document.getElementById('captcha');

                if (!imagen || !boton) {
                    return;
                }

                boton.addEventListener('click', () => {
                    imagen.src =
                        @json(route('tramitanet.captcha')) +
                        '?v=' + Date.now();

                    if (input) {
                        input.value = '';
                        input.focus();
                    }
                });
            });
        </script>
    @endpush
@endonce