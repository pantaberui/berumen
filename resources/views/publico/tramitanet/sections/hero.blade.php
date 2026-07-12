<section class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 text-white">

    {{-- Iluminación decorativa --}}
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(139,92,246,0.35),transparent_35%),radial-gradient(circle_at_bottom_left,rgba(249,115,22,0.30),transparent_30%)]">
    </div>

    {{-- Líneas decorativas --}}
    <div class="absolute -right-32 top-8 h-80 w-80 rounded-full border border-violet-400/20"></div>
    <div class="absolute -right-20 top-20 h-64 w-64 rounded-full border border-violet-400/10"></div>

    <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-6 py-16 md:grid-cols-2 md:py-24">

        {{-- Información principal --}}
        <div>
            <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-violet-400/30 bg-violet-500/10 px-5 py-2 text-sm font-semibold text-violet-200">
                <span class="h-2 w-2 rounded-full bg-violet-400"></span>
                Servicios en Línea Berumen
            </div>

            <h1 class="text-5xl font-black leading-none tracking-tight sm:text-6xl md:text-7xl">
                <span class="text-white">
                    Tramita
                </span><span class="text-orange-400">Net</span>
            </h1>

            <p class="mt-5 text-2xl font-bold leading-tight text-violet-200 md:text-3xl">
                Gestiona tus trámites desde cualquier lugar.
            </p>

            <p class="mt-6 max-w-xl text-base leading-relaxed text-slate-300 md:text-lg">
                Solicita documentos oficiales, realiza pagos y da seguimiento a tus solicitudes
                desde México o el extranjero, con atención personalizada y entrega digital.
            </p>

            <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                <a
                    href="#instituciones"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-7 py-3.5 font-bold text-white shadow-lg shadow-orange-500/20 transition hover:-translate-y-0.5 hover:bg-orange-600"
                >
                    <span>📄</span>
                    Solicitar trámite
                    <span>→</span>
                </a>

                <a
                    href="{{ route('tramitanet.consulta') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-violet-400/40 bg-violet-500/10 px-7 py-3.5 font-bold text-violet-100 transition hover:-translate-y-0.5 hover:border-violet-300 hover:bg-violet-500/20"
                >
                    <span>🔎</span>
                    Consultar folio
                </a>
            </div>

            {{-- Indicadores --}}
            <div class="mt-10 flex flex-wrap gap-x-6 gap-y-3 text-sm text-slate-300">
                <span class="inline-flex items-center gap-2">
                    <span class="text-green-400">✓</span>
                    Seguimiento por folio
                </span>

                <span class="inline-flex items-center gap-2">
                    <span class="text-green-400">✓</span>
                    Atención personalizada
                </span>

                <span class="inline-flex items-center gap-2">
                    <span class="text-green-400">✓</span>
                    Entrega digital
                </span>
            </div>
        </div>

        {{-- Proceso --}}
        <div class="rounded-3xl border border-white/20 bg-white/10 p-5 shadow-2xl backdrop-blur sm:p-6">

            <div class="rounded-2xl bg-white p-6 text-slate-900 sm:p-8">
                <div class="mb-6 flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-100 text-xl">
                        📋
                    </div>

                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-violet-600">
                            TramitaNet
                        </p>

                        <h2 class="text-xl font-black text-slate-900">
                            Proceso de solicitud
                        </h2>
                    </div>
                </div>

                <div class="space-y-5">
                    @foreach([
                        ['1', 'Elige tu trámite', 'Selecciona el servicio que necesitas.'],
                        ['2', 'Captura tus datos', 'Solo solicitaremos la información necesaria.'],
                        ['3', 'Realiza tu pago', 'Paga mediante transferencia o depósito.'],
                        ['4', 'Recibe tu documento', 'Consulta y descarga el resultado desde tu expediente.'],
                    ] as [$numero, $titulo, $texto])

                        <div class="group flex gap-4">
                            <div class="flex h-11 w-11 flex-none items-center justify-center rounded-full bg-violet-100 font-black text-violet-700 transition group-hover:bg-violet-600 group-hover:text-white">
                                {{ $numero }}
                            </div>

                            <div>
                                <h3 class="font-extrabold text-slate-900">
                                    {{ $titulo }}
                                </h3>

                                <p class="mt-1 text-sm leading-relaxed text-slate-600">
                                    {{ $texto }}
                                </p>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>