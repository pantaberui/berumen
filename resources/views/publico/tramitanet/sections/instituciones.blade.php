<section id="instituciones" class="bg-slate-100 py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <p class="text-blue-700 font-bold text-sm uppercase tracking-wide">
                    Instituciones
                </p>
                <h2 class="text-3xl font-extrabold text-slate-900">
                    Elige dónde iniciar
                </h2>
                <p class="text-slate-600 mt-2">
                    También puedes solicitar directamente los trámites más comunes.
                </p>
            </div>

            <a href="{{ route('tramitanet.consulta') }}"
               class="text-blue-700 font-semibold hover:underline">
                Ya tengo folio, consultar trámite →
            </a>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-5">

            @foreach($instituciones as $institucion)

                @php
                    $nombreLogo = $institucion->logo ?: $institucion->slug . '.png';

                    $rutaLogo = 'images/instituciones/' . $nombreLogo;

                    $logoExiste = file_exists(public_path($rutaLogo));
                @endphp

                <a href="{{ route('tramitanet.institucion', $institucion->slug) }}"
                    class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white text-center shadow-sm transition duration-300 hover:-translate-y-1 hover:border-blue-300 hover:shadow-xl">

                        {{-- Franja institucional --}}
                        <div
                            class="h-2 w-full"
                            style="background-color: {{ $institucion->color_principal ?? '#2563EB' }}">
                        </div>

                        <div class="p-6">

                            {{-- Logo --}}
                            <div class="mb-5 flex h-20 items-center justify-center">
                                @if($logoExiste)
                                    <div class="flex h-20 w-full items-center justify-center rounded-2xl border border-slate-100 bg-white px-4">
                                        <img
                                            src="{{ asset($rutaLogo) }}"
                                            alt="Logo de {{ $institucion->nombre }}"
                                            class="max-h-16 max-w-[170px] object-contain transition duration-300 group-hover:scale-105"
                                            loading="lazy"
                                        >
                                    </div>
                                @else
                                    <div
                                        class="flex h-16 w-16 items-center justify-center rounded-2xl text-2xl font-black text-white shadow-sm"
                                        style="background-color: {{ $institucion->color_principal ?? '#2563EB' }}">
                                        {{ mb_substr($institucion->nombre, 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            {{-- Nombre --}}
                            <h3 class="flex min-h-[56px] items-center justify-center text-lg font-extrabold leading-tight text-slate-900">
                                {{ $institucion->nombre }}
                            </h3>

                            {{-- Descripción --}}
                            <p class="mt-3 min-h-[72px] text-sm leading-relaxed text-slate-600">
                                {{ $institucion->descripcion }}
                            </p>

                            {{-- Contador --}}
                            <div class="mt-5 flex justify-center">
                                <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-4 py-2 text-sm font-bold text-blue-700">
                                    <span>📄</span>

                                    <span>
                                        {{ $institucion->servicios_count }}
                                        {{ $institucion->servicios_count === 1 ? 'trámite' : 'trámites' }}
                                    </span>
                                </span>
                            </div>

                            {{-- Acción --}}
                            <p class="mt-5 font-bold text-orange-600 transition group-hover:text-orange-700">
                                Ver trámites
                                <span class="inline-block transition-transform duration-300 group-hover:translate-x-1">
                                    →
                                </span>
                            </p>
                        </div>
                    </a>
            @endforeach
        </div>
    </div>
</section>
