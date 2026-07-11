<header class="bg-slate-950 text-white border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="{{ route('tramitanet.index') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center font-black">
                T
            </div>
            <div>
                <p class="font-extrabold text-lg leading-none">TramitaNet</p>
                <p class="text-xs text-slate-300">Servicios Digitales Berumen</p>
            </div>
        </a>

        <nav class="hidden md:flex items-center gap-6 text-sm font-semibold">
            <a href="{{ route('tramitanet.index') }}" class="hover:text-orange-400">Inicio</a>
            <a href="#instituciones" class="hover:text-orange-400">Trámites</a>
            <a href="{{ route('tramitanet.consulta') }}" class="hover:text-orange-400">Consultar folio</a>
        </nav>
    </div>
</header>