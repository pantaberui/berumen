<header
    x-data="{ menuMovilAbierto: false }"
    class="sticky top-0 z-50 border-b border-white/10 bg-slate-950/95 text-white shadow-lg backdrop-blur"
>
    <div class="mx-auto flex min-h-[76px] max-w-7xl items-center justify-between px-4 sm:px-6">

        <a
            href="{{ route('tramitanet.index') }}"
            class="group flex min-w-0 items-center gap-3"
        >


            {{-- Logo horizontal: solamente celular --}}
            <div class="flex items-center md:hidden">
                <img
                    src="{{ asset('images/logo-horizontal.png') }}"
                    alt="TramitaNet"
                    class="h-12 w-auto max-w-[190px] rounded-xl object-contain"
                >
            </div>

            {{-- Presentación actual para escritorio --}}
            <div class="hidden items-center gap-3 md:flex">
                <div class="flex h-14 w-14 flex-none items-center justify-center">
                    <img
                        src="{{ asset('images/tramitanet-icono.png') }}"
                        alt="Icono de TramitaNet"
                        class="h-12 w-auto rounded-xl"

                    >
                </div>

                <div class="min-w-0">
                    <p class="text-2xl font-black leading-none tracking-tight">
                        <span class="text-blue-400">Tramita</span><span class="text-orange-400">Net</span>
                    </p>

                    <p class="mt-1 text-xs font-semibold tracking-wide text-slate-300">
                        Servicios Digitales en Línea Berumen
                    </p>
                </div>
            </div>
        </a>

        {{-- Estado de atención: móvil --}}
        <div class="flex min-w-0 flex-1 justify-center px-2 md:hidden">
            <div
                class="inline-flex max-w-full items-center gap-2 rounded-full border px-3 py-2
                    text-[11px] font-bold leading-tight
                    {{ $servicioAbierto
                        ? 'border-green-400/30 bg-green-500/10 text-green-200'
                        : 'border-amber-400/30 bg-amber-500/10 text-amber-200'
                    }}"
            >
                <span
                    class="h-2 w-2 flex-none rounded-full
                        {{ $servicioAbierto ? 'bg-green-400' : 'bg-amber-400' }}"
                ></span>

                <span class="truncate">
                    @if($servicioAbierto)
                        Estamos atendiendo
                    @elseif($horarioAutomatico && $siguienteApertura)
                        Próx. {{ $siguienteApertura
                            ->locale('es')
                            ->translatedFormat('D H:i') }}
                    @else
                        Fuera de horario
                    @endif
                </span>
            </div>
        </div>

        <div class="hidden items-center md:flex">
            <div
                class="inline-flex items-center gap-2 rounded-full border px-3 py-2 text-xs font-bold
                    {{ $servicioAbierto
                        ? 'border-green-400/30 bg-green-500/10 text-green-200'
                        : 'border-amber-400/30 bg-amber-500/10 text-amber-200'
                    }}"
            >
                <span
                    class="h-2.5 w-2.5 rounded-full
                        {{ $servicioAbierto ? 'bg-green-400' : 'bg-amber-400' }}"
                ></span>

                @if($servicioAbierto)
                    Estamos atendiendo
                @elseif($horarioAutomatico && $siguienteApertura)
                    Próxima atención:
                    {{ $siguienteApertura
                        ->locale('es')
                        ->translatedFormat('D d/m H:i') }}
                @else
                    Fuera de horario
                @endif
            </div>
        </div>

        <nav class="hidden items-center gap-1 md:flex">
            <a
                href="{{ route('tramitanet.index') }}"
                class="rounded-xl px-4 py-2 text-sm font-bold transition
                    hover:bg-white/10 hover:text-orange-400
                    {{ request()->routeIs('tramitanet.index')
                        ? 'bg-white/10 text-orange-400'
                        : 'text-slate-200' }}"
            >
                Inicio
            </a>

            <a
                href="{{ route('tramitanet.index') }}#instituciones"
                class="rounded-xl px-4 py-2 text-sm font-bold text-slate-200 transition
                       hover:bg-white/10 hover:text-orange-400"
            >
                Trámites
            </a>

            <a
                href="{{ route('tramitanet.faq') }}"
                class="rounded-xl px-4 py-2 text-sm font-bold transition
                    hover:bg-white/10 hover:text-orange-400
                    {{ request()->routeIs('tramitanet.faq')
                        ? 'bg-white/10 text-orange-400'
                        : 'text-slate-200' }}"
            >
                Preguntas frecuentes
            </a>

            <a
                href="{{ route('tramitanet.consulta') }}"
                class="ml-2 rounded-xl border border-blue-400/40 bg-blue-500/10 px-4 py-2
                       text-sm font-bold text-blue-200 transition
                       hover:border-orange-400 hover:bg-orange-500 hover:text-white
                    {{ request()->routeIs('tramitanet.consulta')
                        ? 'border-orange-400 bg-orange-500 text-white'
                        : '' }}"
            >
                Consultar folio
            </a>
        </nav>

        {{-- Botón hamburguesa --}}
        <button
            type="button"
            @click.stop="menuMovilAbierto = !menuMovilAbierto"
            :aria-expanded="menuMovilAbierto.toString()"
            aria-controls="menu-movil-tramitanet"
            aria-label="Abrir menú de navegación"
            class="inline-flex h-11 w-11 items-center justify-center rounded-xl
                   border border-white/15 bg-white/5 text-slate-200 transition
                   hover:border-orange-400/60 hover:bg-white/10 hover:text-orange-400
                   focus:outline-none focus:ring-2 focus:ring-orange-400 md:hidden"
        >
            <svg
                x-show="!menuMovilAbierto"
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>

            <svg
                x-show="menuMovilAbierto"
                x-cloak
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>
        </button>
    </div>

    {{-- Menú móvil --}}
    <div
        id="menu-movil-tramitanet"
        x-show="menuMovilAbierto"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        @click.outside="if (menuMovilAbierto) menuMovilAbierto = false"
        @keydown.escape.window="menuMovilAbierto = false"
        x-cloak
        class="border-t border-white/10 bg-slate-950 px-4 pb-5 pt-4 shadow-xl md:hidden"
    >
        <div
            class="mb-4 rounded-xl border px-4 py-3
                {{ $servicioAbierto
                    ? 'border-green-400/30 bg-green-500/10 text-green-200'
                    : 'border-amber-400/30 bg-amber-500/10 text-amber-200'
                }}"
        >
            <div class="flex items-center gap-2 text-sm font-bold">
                <span
                    class="h-2.5 w-2.5 rounded-full
                        {{ $servicioAbierto ? 'bg-green-400' : 'bg-amber-400' }}"
                ></span>

                @if($servicioAbierto)
                    Estamos atendiendo
                @else
                    Fuera de horario
                @endif
            </div>

            @if(
                !$servicioAbierto &&
                $horarioAutomatico &&
                $siguienteApertura
            )
                <p class="mt-2 pl-4 text-xs font-semibold text-amber-100">
                    Próxima atención:
                    {{ $siguienteApertura
                        ->locale('es')
                        ->translatedFormat('l d/m \a \l\a\s H:i') }}
                </p>
            @endif
        </div>

                <nav class="space-y-2">
                @click.prevent="
                    menuMovilAbierto = false;
                    window.location = $el.href;
                "
                <span>Inicio</span>
                <span>›</span>
            </a>

            <a
                href="{{ route('tramitanet.index') }}#instituciones"
                @click="menuMovilAbierto = false"
                class="flex items-center justify-between rounded-xl px-4 py-3
                       text-sm font-bold text-slate-200 transition
                       hover:bg-white/10 hover:text-orange-400"
            >
                <span>Trámites</span>
                <span>›</span>
            </a>

            <a
                href="{{ route('tramitanet.consulta') }}"
                @click="menuMovilAbierto = false"
                class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-bold transition
                    {{ request()->routeIs('tramitanet.consulta')
                        ? 'bg-blue-500/20 text-blue-200'
                        : 'text-slate-200 hover:bg-white/10 hover:text-orange-400' }}"
            >
                <span>Consultar folio</span>
                <span>›</span>
            </a>

            <a
                href="{{ route('tramitanet.faq') }}"
                @click="menuMovilAbierto = false"
                class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-bold transition
                    {{ request()->routeIs('tramitanet.faq')
                        ? 'bg-white/10 text-orange-400'
                        : 'text-slate-200 hover:bg-white/10 hover:text-orange-400' }}"
            >
                <span>Preguntas frecuentes</span>
                <span>›</span>
            </a>

            <div class="my-3 border-t border-white/10"></div>

            <a
                href="{{ route('tramitanet.aviso-privacidad') }}"
                @click="menuMovilAbierto = false"
                class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-semibold transition
                    {{ request()->routeIs('tramitanet.aviso-privacidad')
                        ? 'bg-white/10 text-orange-400'
                        : 'text-slate-300 hover:bg-white/10 hover:text-orange-400' }}"
            >
                <span>Aviso de privacidad</span>
                <span>›</span>
            </a>

            <a
                href="{{ route('tramitanet.terminos') }}"
                @click="menuMovilAbierto = false"
                class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-semibold transition
                    {{ request()->routeIs('tramitanet.terminos')
                        ? 'bg-white/10 text-orange-400'
                        : 'text-slate-300 hover:bg-white/10 hover:text-orange-400' }}"
            >
                <span>Términos y condiciones</span>
                <span>›</span>
            </a>
        </nav>
    </div>
</header>
