@extends('publico.tramitanet.layouts.app')

@section(
    'title',
    ($servicio->titulo_publico ?? $servicio->nombre) . ' | TramitaNet'
)

@section('content')

<section class="bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 py-14 text-white">
    <div class="mx-auto max-w-5xl px-6">
        <a
            href="{{ route('tramitanet.index') }}"
            class="text-sm font-semibold text-blue-200 hover:text-white"
        >
            ← Volver al inicio
        </a>

        <div class="mt-8">
            <p class="text-sm font-bold uppercase tracking-wide text-orange-400">
                {{ $servicio->institucion->nombre ?? 'Servicio' }}
            </p>

            <h1 class="mt-2 text-4xl font-extrabold md:text-5xl">
                {{ $servicio->titulo_publico ?? $servicio->nombre }}
            </h1>

            <p class="mt-4 max-w-3xl text-slate-300">
                {{
                    $servicio->descripcion
                        ?? 'Servicio digital disponible en TramitaNet.'
                }}
            </p>
        </div>
    </div>
</section>

<section class="bg-slate-100 py-12">
    <div class="mx-auto grid max-w-5xl gap-8 px-6 lg:grid-cols-3">

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow lg:col-span-2">
            <h2 class="text-2xl font-extrabold text-slate-900">
                Elige cómo deseas realizar el trámite
            </h2>

            <p class="mt-2 text-slate-600">
                Selecciona la opción que corresponda con la información o
                documentación que tienes disponible.
            </p>

            @if($servicio->modalidades->isNotEmpty())
                <div class="mt-8 grid gap-5 md:grid-cols-2">
                    @foreach($servicio->modalidades as $modalidad)
                        <a
                            href="{{ route('tramitanet.servicio.modalidad', [
                                $servicio->slug,
                                $modalidad->slug,
                            ]) }}"
                            class="group block rounded-3xl border border-slate-200 bg-slate-50 p-6 transition hover:-translate-y-1 hover:border-blue-500 hover:shadow-xl"
                        >
                            <h3 class="text-xl font-extrabold text-slate-900">
                                {{ $modalidad->nombre }}
                            </h3>

                            @if($modalidad->descripcion)
                                <p class="mt-3 text-sm leading-relaxed text-slate-600">
                                    {{ $modalidad->descripcion }}
                                </p>
                            @endif

                            @if($modalidad->campos->isNotEmpty())
                                <div class="mt-5">
                                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                                        Esta opción requiere
                                    </p>

                                    <ul class="mt-3 space-y-2">
                                        @foreach($modalidad->campos as $campoServicio)
                                            @if($campoServicio->campoMaestro)
                                                <li class="flex items-start gap-2 text-sm text-slate-700">
                                                    <span class="font-black text-green-600">
                                                        ✓
                                                    </span>

                                                    <span>
                                                        {{ $campoServicio->campoMaestro->nombre }}

                                                        @unless($campoServicio->requerido)
                                                            <span class="text-xs text-slate-500">
                                                                (opcional)
                                                            </span>
                                                        @endunless
                                                    </span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mt-5 border-t border-slate-200 pt-5">
                                @if($modalidad->tiempo_estimado)
                                    <p class="text-sm font-semibold text-blue-700">
                                        {{ $modalidad->tiempo_estimado }}
                                    </p>
                                @endif

                                @if(!is_null($modalidad->precio))
                                    <p class="mt-3 text-2xl font-black text-slate-900">
                                        ${{ number_format($modalidad->precio, 2) }}
                                        <span class="text-sm font-semibold text-slate-500">
                                            MXN
                                        </span>
                                    </p>
                                @elseif($servicio->tipo_precio === 'por_entidad')
                                    <p class="mt-3 text-sm font-bold text-slate-700">
                                        Costo según la entidad de la CURP
                                    </p>
                                @elseif(!is_null($servicio->precio))
                                    <p class="mt-3 text-2xl font-black text-slate-900">
                                        ${{ number_format($servicio->precio, 2) }}
                                        <span class="text-sm font-semibold text-slate-500">
                                            MXN
                                        </span>
                                    </p>
                                @endif
                            </div>

                            <p class="mt-5 font-bold text-orange-600 group-hover:text-orange-700">
                                Continuar con esta opción →
                            </p>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="mt-8 rounded-2xl border border-amber-200 bg-amber-50 p-5">
                    <p class="font-bold text-amber-900">
                        Este servicio todavía no tiene modalidades disponibles.
                    </p>

                    <p class="mt-1 text-sm text-amber-800">
                        Estamos terminando su configuración. Intenta nuevamente más adelante.
                    </p>
                </div>
            @endif
        </div>

        <aside class="space-y-5">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow">
                <p class="text-sm font-bold uppercase text-slate-500">
                    Costo
                </p>

                @if($servicio->tipo_precio === 'por_entidad')
                    <p class="mt-3 text-slate-600">
                        El costo se calcula automáticamente según la entidad
                        identificada en la CURP.
                    </p>
                @elseif(!is_null($servicio->precio))
                    <p class="mt-3 text-4xl font-black text-slate-900">
                        ${{ number_format($servicio->precio, 2) }}
                    </p>

                    <p class="text-sm text-slate-500">
                        MXN
                    </p>
                @else
                    <p class="mt-3 text-slate-600">
                        El costo se mostrará al seleccionar una modalidad.
                    </p>
                @endif
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow">
                <p class="text-sm font-bold uppercase text-slate-500">
                    Tiempo estimado
                </p>

                <p class="mt-3 font-bold text-slate-900">
                    {{ $servicio->tiempo_estimado ?? 'Sujeto a validación' }}
                </p>

                <p class="mt-2 text-sm text-slate-600">
                    Los tiempos aplican dentro del horario de atención.
                </p>
            </div>

            @if($servicio->entrega_digital)
                <div class="rounded-3xl border border-green-200 bg-green-50 p-6">
                    <p class="font-extrabold text-green-900">
                        Entrega digital
                    </p>

                    <p class="mt-2 text-sm text-green-800">
                        Recibirás el documento por los medios de contacto registrados.
                    </p>
                </div>
            @endif
        </aside>

    </div>
</section>

@endsection