<header class="sticky top-0 z-50 border-b border-white/10 bg-slate-950/95 text-white shadow-lg backdrop-blur">
    <div class="mx-auto flex min-h-[76px] max-w-7xl items-center justify-between px-4 sm:px-6">

        <a href="{{ route('tramitanet.index') }}"
           class="group flex min-w-0 items-center gap-3">

            <div class="flex h-14 w-14 flex-none items-center justify-center">
                <img
                    src="{{ asset('images/tramitanet-icono.png') }}"
                    alt="Icono de TramitaNet"
                    class="h-14 w-14 object-contain transition duration-200 group-hover:scale-105"
                >
            </div>

            <div class="min-w-0">
                <p class="text-xl font-black leading-none tracking-tight sm:text-2xl">
                    <span class="text-blue-400">Tramita</span><span class="text-orange-400">Net</span>
                </p>

                <p class="mt-1 hidden text-xs font-semibold tracking-wide text-slate-300 sm:block">
                    Servicios en Línea Berumen
                </p>
            </div>
        </a>

        <nav class="hidden items-center gap-1 md:flex">
            <a href="{{ route('tramitanet.index') }}"
               class="rounded-xl px-4 py-2 text-sm font-bold text-slate-200 transition hover:bg-white/10 hover:text-orange-400">
                Inicio
            </a>

            <a href="{{ route('tramitanet.index') }}#instituciones"
               class="rounded-xl px-4 py-2 text-sm font-bold text-slate-200 transition hover:bg-white/10 hover:text-orange-400">
                Trámites
            </a>

            <a href="{{ route('tramitanet.consulta') }}"
               class="ml-2 rounded-xl border border-blue-400/40 bg-blue-500/10 px-4 py-2 text-sm font-bold text-blue-200 transition hover:border-orange-400 hover:bg-orange-500 hover:text-white">
                Consultar folio
            </a>
        </nav>

        {{-- Navegación móvil compacta --}}
        <a href="{{ route('tramitanet.consulta') }}"
           class="rounded-xl border border-blue-400/40 px-3 py-2 text-xs font-bold text-blue-200 md:hidden">
            Consultar folio
        </a>

    </div>
</header>