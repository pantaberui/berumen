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

                <a href="{{ route('tramitanet.institucion', $institucion->slug) }}"
                  class="block bg-white rounded-2xl p-6 shadow hover:shadow-lg transition border border-slate-200 hover:-translate-y-1">

                    <div
                        class="w-12 h-12 rounded-2xl flex items-center justify-center font-black text-white mb-4"
                        style="background-color: {{ $institucion->color_principal ?? '#2563EB' }}">
                        {{ mb_substr($institucion->nombre, 0, 1) }}
                    </div>

                    <h3 class="font-extrabold text-lg text-slate-900">
                        {{ $institucion->nombre }}
                    </h3>

                    <p class="text-sm text-slate-600 mt-2 min-h-[60px]">
                        {{ $institucion->descripcion }}
                    </p>

                    <p class="text-sm font-bold text-blue-700 mt-4">
                        {{ $institucion->servicios_count }} trámites disponibles
                    </p>

                </a>
            @endforeach
        </div>
    </div>
</section>