<section class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 text-white">
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_top_right,#38bdf8,transparent_35%),radial-gradient(circle_at_bottom_left,#f97316,transparent_30%)]"></div>

    <div class="relative max-w-7xl mx-auto px-6 py-16 md:py-24 grid md:grid-cols-2 gap-10 items-center">
        <div>
            <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-2 text-sm mb-6">
                <span class="w-2 h-2 rounded-full bg-green-400"></span>
                Servicios Digitales Berumen
            </div>

            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">
                TramitaNet
            </h1>

            <p class="text-2xl md:text-3xl font-semibold mt-3 text-blue-100">
                Tus trámites oficiales, estés donde estés.
            </p>

            <p class="text-slate-300 mt-5 max-w-xl">
                Solicita documentos oficiales, pagos y servicios digitales desde México o el extranjero.
                Atención personalizada, seguimiento por folio y entrega digital.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 mt-8">
                <a href="#instituciones"
                   class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-bold text-center shadow-lg shadow-orange-500/20">
                    Solicitar trámite
                </a>

                <a href="{{ route('tramitanet.consulta') }}"
                   class="bg-white/10 hover:bg-white/20 border border-white/20 text-white px-6 py-3 rounded-xl font-bold text-center">
                    Consultar folio
                </a>
            </div>
        </div>

        <div class="bg-white/10 backdrop-blur border border-white/20 rounded-3xl p-6 shadow-2xl">
            <div class="bg-white text-slate-900 rounded-2xl p-6">
                <p class="text-sm text-slate-500 font-semibold mb-2">Proceso simple</p>

                <div class="space-y-4">
                    @foreach([
                        ['1', 'Elige tu trámite', 'Selecciona el servicio que necesitas.'],
                        ['2', 'Captura tus datos', 'Solo pediremos la información necesaria.'],
                        ['3', 'Realiza tu pago', 'Transferencia o depósito.'],
                        ['4', 'Recibe tu documento', 'Por correo electrónico o WhatsApp.'],
                    ] as [$numero, $titulo, $texto])
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                                {{ $numero }}
                            </div>
                            <div>
                                <h3 class="font-bold">{{ $titulo }}</h3>
                                <p class="text-sm text-slate-600">{{ $texto }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>