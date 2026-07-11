<section class="py-16 bg-white">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-12">

            <p class="text-blue-700 font-bold uppercase tracking-widest text-sm">
                Más solicitados
            </p>

            <h2 class="text-4xl font-extrabold text-slate-900 mt-2">
                Trámites más solicitados
            </h2>

            <p class="text-slate-600 mt-3 max-w-2xl mx-auto">
                Estos son los servicios que nuestros clientes solicitan con mayor frecuencia.
            </p>

        </div>

        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">

            @foreach($serviciosDestacados as $servicio)

                <div class="bg-slate-50 rounded-3xl border border-slate-200 hover:border-blue-500 hover:shadow-xl transition duration-300 overflow-hidden">

                    <div class="p-7">

                        <div class="flex justify-between items-start">

                            <div>

                                <span class="text-xs font-bold uppercase text-blue-700 tracking-wide">
                                    {{ $servicio->institucion->nombre }}
                                </span>

                                <h3 class="text-xl font-extrabold mt-2 text-slate-900">
                                    {{ $servicio->titulo_publico }}
                                </h3>

                            </div>

                            @if($servicio->es_documento_oficial)
                                <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-semibold">
                                    Oficial
                                </span>
                            @endif

                        </div>

                        <p class="text-slate-600 mt-4 min-h-[70px]">
                            {{ $servicio->descripcion_corta }}
                        </p>

                        <div class="mt-6 flex justify-between items-center">

                            <div>

                                @if($servicio->slug == 'acta-de-nacimiento')

                    <div class="leading-none">
                        <span class="text-sm font-semibold text-slate-500">
                            Desde
                        </span>

                        <p class="text-3xl font-black text-slate-900">
                            $119.00
                        </p>

                        <p class="text-sm text-slate-500">
                            MXN
                        </p>
                    </div>

                @elseif($servicio->mostrar_precio)

                    <div class="leading-none">
                        <p class="text-3xl font-black text-slate-900">
                            ${{ number_format($servicio->precio,2) }}
                        </p>

                        <p class="text-sm text-slate-500">
                            MXN
                        </p>
                    </div>

                @endif

                            </div>

                            <a href="{{ route('tramitanet.servicio', $servicio->slug) }}"
                               class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-xl font-bold">

                                Ver detalles

                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>