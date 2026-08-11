@extends('publico.tramitanet.layouts.app')

@section('title', 'Revisa tu solicitud | TramitaNet')

@section('content')

<section class="bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 text-white py-14">
    <div class="max-w-5xl mx-auto px-6">
        <a href="{{ route('tramitanet.servicio.modalidad', [$servicio->slug, $modalidad->slug]) }}"
           class="text-blue-200 hover:text-white text-sm font-semibold">
            ← Regresar y corregir
        </a>

        @if(!empty($entidadCurp['nombre']))
            <div class="flex justify-between gap-4 border-b border-slate-100 pb-3">
                <span class="text-sm text-slate-500">
                    Entidad detectada
                </span>

                <span class="text-sm font-bold text-slate-900 text-right">
                    {{ $entidadCurp['nombre'] }}
                </span>
            </div>
        @endif

        <h1 class="text-4xl font-black mt-8">
            Revisa tu solicitud
        </h1>

        <p class="text-slate-300 mt-3">
            Verifica que la información sea correcta antes de generar tu folio.
        </p>
    </div>
</section>

<section class="bg-slate-100 py-12">
    <div class="max-w-5xl mx-auto px-6 grid lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 bg-white rounded-3xl shadow border border-slate-200 p-8">
            <p class="text-sm font-bold text-blue-700 uppercase">
                {{ $servicio->institucion->nombre ?? 'Servicio' }}
            </p>

            <h2 class="text-2xl font-black text-slate-900 mt-2">
                {{ $servicio->titulo_publico ?? $servicio->nombre }}
            </h2>

            <p class="text-slate-600 mt-2">
                Modalidad: <strong>{{ $modalidad->nombre }}</strong>
            </p>

            <hr class="my-6">

            <h3 class="font-black text-slate-900 mb-4">
                Datos proporcionados
            </h3>

            <div class="space-y-3">
                @foreach($modalidad->campos as $campoModalidad)
                    @php
                        $campo = $campoModalidad->campoMaestro;
                        $valor = $campos[$campo->slug] ?? null;
                    @endphp

                    <div class="flex justify-between gap-4 border-b border-slate-100 pb-3">
                        <span class="text-sm text-slate-500">
                            {{ $campo->nombre }}
                        </span>

                        <span class="text-sm font-bold text-slate-900 text-right">
                            {{ $campo->tipo_campo === 'password' ? '********' : ($valor ?: 'Sin capturar') }}
                        </span>
                    </div>
                @endforeach

            </div>

            <form method="POST"
                  action="{{ route('tramitanet.servicio.store', $servicio->slug) }}"
                  enctype="multipart/form-data">
                @csrf


                <input type="hidden"
                    name="modalidad"
                    value="{{ $modalidad->id }}">

                <input type="hidden"
                    name="whatsapp_codigo_pais"
                    value="{{ $whatsappCodigoPais }}">

                <input type="hidden"
                    name="whatsapp_numero"
                    value="{{ $whatsappNumero }}">

                <input type="hidden"
                    name="correo"
                    value="{{ $correo }}">

                @foreach($campos as $slugCampo => $valor)
                    <input type="hidden" name="campos[{{ $slugCampo }}]" value="{{ $valor }}">
                @endforeach

                <label class="flex items-start gap-3 bg-orange-50 border border-orange-200 rounded-2xl p-4">
                    <input type="checkbox"
                           name="confirmacion_datos"
                           value="1"
                           required
                           class="mt-1 rounded border-orange-300 text-orange-600 focus:ring-orange-500">
                    <input
                        type="hidden"
                        name="precio_calculado"
                        value="{{ $precioCalculado }}"
                    >
                    <span class="text-sm text-orange-900">
                        Confirmo que revisé cuidadosamente la información y que los datos proporcionados son correctos.
                    </span>

                </label>

                <label class="mt-4 flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <input
                        type="checkbox"
                        name="aceptacion_legal"
                        value="1"
                        required
                        class="mt-1 rounded border-slate-300 text-orange-600 focus:ring-orange-500"
                    >

                    <span class="text-sm leading-6 text-slate-700">
                        He leído y acepto los
                        <a
                            href="{{ route('tramitanet.terminos') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="font-bold text-orange-600 hover:text-orange-700 hover:underline"
                        >
                            Términos y Condiciones
                        </a>
                        y el
                        <a
                            href="{{ route('tramitanet.aviso-privacidad') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="font-bold text-orange-600 hover:text-orange-700 hover:underline"
                        >
                            Aviso de Privacidad
                        </a>.
                    </span>
                </label>

                @error('aceptacion_legal')
                    <p class="mt-2 text-sm font-semibold text-red-600">
                        {{ $message }}
                    </p>
                @enderror

                <div class="flex flex-col sm:flex-row gap-3 mt-6">
                    <a href="{{ route('tramitanet.servicio.modalidad', [$servicio->slug, $modalidad->slug]) }}"
                       class="px-6 py-3 rounded-xl bg-slate-200 text-slate-700 font-bold text-center">
                        Regresar
                    </a>

                    <button type="submit"
                            onclick="this.disabled=true; this.innerHTML='⏳ Generando solicitud...'; this.form.submit();"
                            class="px-6 py-3 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-bold disabled:opacity-70 disabled:cursor-not-allowed">
                        Generar solicitud
                    </button>
                </div>
            </form>
        </div>

        <aside class="space-y-6">
            <div class="bg-white rounded-3xl shadow border border-slate-200 p-6">
                <p class="text-sm font-bold text-slate-500 uppercase">
                    Total
                </p>

                <p class="text-4xl font-black text-slate-900 mt-3">
                    ${{ number_format($precioCalculado, 2) }}
                </p>

                <p class="text-sm text-slate-500">MXN</p>
            </div>

            <div class="bg-white rounded-3xl shadow border border-slate-200 p-6">
                <p class="text-sm font-bold text-slate-500 uppercase">
                    Tiempo estimado
                </p>

                <p class="font-bold text-slate-900 mt-3">
                    {{ $modalidad->tiempo_estimado }}
                </p>

                <p class="text-sm text-slate-600 mt-2">
                    Los tiempos aplican dentro del horario de atención.
                </p>
            </div>
        </aside>

    </div>
</section>

@endsection
