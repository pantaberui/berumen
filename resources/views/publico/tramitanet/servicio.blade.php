@extends('publico.tramitanet.layouts.app')

@section('title', ($servicio->titulo_publico ?? $servicio->nombre) . ' | TramitaNet')

@section('content')

<section class="bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 text-white py-14">
    <div class="max-w-5xl mx-auto px-6">
        <a href="{{ route('tramitanet.index') }}" class="text-blue-200 hover:text-white text-sm font-semibold">
            ← Volver al inicio
        </a>

        <div class="mt-8">
            <p class="text-orange-400 font-bold uppercase tracking-wide text-sm">
                {{ $servicio->institucion->nombre ?? 'Servicio' }}
            </p>

            <h1 class="text-4xl md:text-5xl font-extrabold mt-2">
                {{ $servicio->titulo_publico ?? $servicio->nombre }}
            </h1>

            <p class="text-slate-300 mt-4 max-w-3xl">
                {{ $servicio->descripcion ?? 'Servicio digital disponible en TramitaNet.' }}
            </p>
        </div>
    </div>
</section>

<section class="bg-slate-100 py-12">
    <div class="max-w-5xl mx-auto px-6 grid lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 bg-white rounded-3xl shadow border border-slate-200 p-8">
            <h2 class="text-2xl font-extrabold text-slate-900">
                Captura la información solicitada
            </h2>

            <p class="text-slate-600 mt-2">
                Solo te pediremos los datos necesarios para este trámite.
                Si cuentas con documentos de apoyo, podrás adjuntarlos más adelante cuando el servicio lo permita.
            </p>

            <p class="text-slate-600 mt-3">
                Para solicitar este trámite, revisa la información necesaria y continúa con la captura de datos.
            </p>

            <div class="mt-6 space-y-4">
                @foreach($servicio->campos as $campoServicio)
                    @php($campo = $campoServicio->campoMaestro)

                    <div class="flex items-start gap-3 bg-slate-50 border border-slate-200 rounded-2xl p-4">
                        <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                            ✓
                        </div>

                        <div>
                            <p class="font-bold text-slate-900">
                                {{ $campo->nombre }}
                            </p>

                            @if($campo->ayuda)
                                <p class="text-sm text-slate-600 mt-1">
                                    {{ $campo->ayuda }}
                                </p>
                            @endif

                            @if($campo->placeholder)
                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $campo->placeholder }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($servicio->modalidades->count())

                <div class="mt-8">
                    <h3 class="text-xl font-extrabold text-slate-900 mb-4">
                        ¿Cómo deseas realizar este trámite?
                    </h3>

                    <div class="grid md:grid-cols-2 gap-5">
                        @foreach($servicio->modalidades as $modalidad)
                            <a href="{{ route('tramitanet.servicio.modalidad', [$servicio->slug, $modalidad->slug]) }}"
                            class="block rounded-3xl border border-slate-200 bg-slate-50 p-6 hover:border-blue-500 hover:shadow-xl transition">

                                <h4 class="text-xl font-extrabold text-slate-900">
                                    {{ $modalidad->nombre }}
                                </h4>

                                <p class="text-sm text-slate-600 mt-3">
                                    {{ $modalidad->descripcion }}
                                </p>

                                <p class="text-sm font-bold text-blue-700 mt-4">
                                    {{ $modalidad->tiempo_estimado }}
                                </p>

                                @if($modalidad->precio)
                                    <p class="text-2xl font-black text-slate-900 mt-4">
                                        ${{ number_format($modalidad->precio, 2) }} MXN
                                    </p>
                                @endif

                                <p class="text-orange-600 font-bold mt-5">
                                    Continuar con esta opción →
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>

            @else

                <form method="POST"
                    action="{{ route('tramitanet.servicio.store', $servicio->slug) }}"
                    enctype="multipart/form-data"
                    class="mt-8"
                    id="form-solicitud-tramitanet">
                    @csrf

                    <div class="mb-8 rounded-2xl border border-slate-200 bg-slate-50 p-6">
                        <h3 class="text-lg font-extrabold text-slate-900">
                            Datos de contacto
                        </h3>

                        <p class="mt-1 text-sm text-slate-600">
                            Utilizaremos estos datos para informarte sobre el avance de tu solicitud.
                        </p>

                        <div class="mt-5 grid gap-5 md:grid-cols-2">
                            <div>
                                <label for="telefono_whatsapp"
                                    class="mb-2 block text-sm font-bold text-slate-700">
                                    WhatsApp de contacto
                                    <span class="text-red-600">*</span>
                                </label>

                                <input
                                    type="tel"
                                    id="telefono_whatsapp"
                                    name="telefono_whatsapp_visible"
                                    value="{{ old('telefono_whatsapp') }}"
                                    autocomplete="tel"
                                    inputmode="tel"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                >

                                <input
                                    type="hidden"
                                    id="telefono_whatsapp_completo"
                                    name="telefono_whatsapp"
                                    value="{{ old('telefono_whatsapp') }}"
                                >

                                <p id="telefono_whatsapp_error"
                                class="mt-2 hidden text-sm font-semibold text-red-600">
                                </p>

                                @error('telefono_whatsapp')
                                    <p class="mt-2 text-sm font-semibold text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="correo"
                                    class="mb-2 block text-sm font-bold text-slate-700">
                                    Correo electrónico
                                    <span class="font-normal text-slate-500">(opcional)</span>
                                </label>

                                <input
                                    type="email"
                                    id="correo"
                                    name="correo"
                                    value="{{ old('correo') }}"
                                    autocomplete="email"
                                    placeholder="correo@ejemplo.com"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                >

                                @error('correo')
                                    <p class="mt-2 text-sm font-semibold text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    @foreach($servicio->campos as $campoServicio)
                        <x-tramitanet.dynamic-field :campo-servicio="$campoServicio" />
                    @endforeach

                    <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-bold">
                        Continuar solicitud
                    </button>
                </form>

            @endif




        </div>

        <aside class="space-y-5">
            <div class="bg-white rounded-3xl shadow border border-slate-200 p-6">
                <p class="text-sm font-bold text-slate-500 uppercase">
                    Costo
                </p>

                @if($servicio->slug === 'acta-de-nacimiento')
                    <p class="text-sm text-slate-500 mt-3">Desde</p>
                    <p class="text-4xl font-black text-slate-900">$129.00</p>
                    <p class="text-sm text-slate-500">MXN</p>
                @elseif($servicio->precio)
                    <p class="text-4xl font-black text-slate-900 mt-3">
                        ${{ number_format($servicio->precio, 2) }}
                    </p>
                    <p class="text-sm text-slate-500">MXN</p>
                @else
                    <p class="text-slate-600 mt-3">
                        Costo según entidad o información capturada.
                    </p>
                @endif
            </div>

            <div class="bg-white rounded-3xl shadow border border-slate-200 p-6">
                <p class="text-sm font-bold text-slate-500 uppercase">
                    Tiempo estimado
                </p>

                <p class="text-slate-900 font-bold mt-3">
                    {{ $servicio->tiempo_estimado ?? 'Sujeto a validación' }}
                </p>

                <p class="text-sm text-slate-600 mt-2">
                    Los tiempos aplican dentro del horario de atención.
                </p>
            </div>
        </aside>

    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('form-solicitud-tramitanet');
        const telefonoInput = document.getElementById('telefono_whatsapp');
        const telefonoCompletoInput = document.getElementById('telefono_whatsapp_completo');
        const telefonoError = document.getElementById('telefono_whatsapp_error');

        if (!form || !telefonoInput || !window.intlTelInput) {
            return;
        }

        const iti = window.intlTelInput(telefonoInput, {
            initialCountry: 'mx',
            separateDialCode: true,
            nationalMode: true,
            formatAsYouType: true,
            countrySearch: true,
            loadUtils: () => import('intl-tel-input/utils'),
        });

        const telefonoAnterior = telefonoCompletoInput.value.trim();

        if (telefonoAnterior.startsWith('+')) {
            iti.setNumber(telefonoAnterior);
        }

        form.addEventListener('submit', (event) => {
            telefonoError.classList.add('hidden');
            telefonoError.textContent = '';

            const telefonoCapturado = telefonoInput.value.trim();

            if (!telefonoCapturado) {
                event.preventDefault();
                telefonoError.textContent = 'El número de WhatsApp es obligatorio.';
                telefonoError.classList.remove('hidden');
                telefonoInput.focus();
                return;
            }

            if (!iti.isValidNumber()) {
                event.preventDefault();
                telefonoError.textContent = 'Captura un número de WhatsApp válido para el país seleccionado.';
                telefonoError.classList.remove('hidden');
                telefonoInput.focus();
                return;
            }

            telefonoCompletoInput.value = iti.getNumber();
        });
    });
</script>
@endpush