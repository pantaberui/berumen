<footer class="mt-auto border-t border-slate-800 bg-slate-950 text-slate-300">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">

            {{-- Identidad --}}
            <div class="lg:col-span-1">
                <div class="flex items-center gap-3">
                    <img
                        src="{{ asset('images/tramitanet-logo.png') }}"
                        alt="TramitaNet"
                        class="h-12 w-auto"
                    >

                    <div>
                        <p class="text-xl font-bold text-white">
                            TramitaNet
                        </p>

                        <p class="text-xs text-slate-400">
                            Servicios Digitales en Línea Berumen
                        </p>
                    </div>
                </div>

                <p class="mt-5 max-w-sm text-sm leading-6 text-slate-400">
                    Servicios digitales confiables para realizar trámites
                    en línea de forma sencilla y segura.
                </p>
            </div>

            {{-- Navegación --}}
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white">
                    Navegación
                </h3>

                <ul class="mt-4 space-y-3 text-sm">
                    <li>
                        <a
                            href="{{ route('tramitanet.index') }}"
                            class="transition hover:text-blue-400"
                        >
                            Inicio
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('tramitanet.index') }}#servicios"
                            class="transition hover:text-blue-400"
                        >
                            Trámites
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('tramitanet.preguntas-frecuentes') }}"
                            class="transition hover:text-blue-400"
                        >
                            Preguntas frecuentes
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('tramitanet.consulta') }}"
                            class="transition hover:text-blue-400"
                        >
                            Consultar folio
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Información --}}
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white">
                    Información
                </h3>

                <ul class="mt-4 space-y-3 text-sm">
                    <li>
                        <span class="text-slate-500">
                            Aviso de privacidad
                        </span>
                    </li>

                    <li>
                        <span class="text-slate-500">
                            Términos y condiciones
                        </span>
                    </li>

                    <li>
                        <a
                            href="{{ route('tramitanet.preguntas-frecuentes') }}#contacto"
                            class="transition hover:text-blue-400"
                        >
                            Contacto
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Contacto --}}
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white">
                    Contacto
                </h3>

                <div class="mt-4 space-y-4 text-sm">

                    <a
                        href="mailto:tramitanet.berumen@gmail.com"
                        class="group flex items-start gap-3 transition hover:text-blue-400"
                    >
                        <svg
                            class="mt-0.5 h-5 w-5 shrink-0 text-blue-400"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21.75 6.75v10.5A2.25 2.25 0 0 1 19.5 19.5h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0-8.69 5.793a2.25 2.25 0 0 1-2.496 0L2.25 6.75"
                            />
                        </svg>

                        <span class="break-all">
                            tramitanet.berumen@gmail.com
                        </span>
                    </a>

                    <a
                        href="https://wa.me/523111650343"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="group flex items-start gap-3 transition hover:text-green-400"
                    >
                        <svg
                            class="mt-0.5 h-5 w-5 shrink-0 text-green-400"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.625 9.75h.008v.008h-.008V9.75Zm3.375 0h.008v.008H12V9.75Zm3.375 0h.008v.008h-.008V9.75ZM21 12c0 4.142-4.03 7.5-9 7.5a10.55 10.55 0 0 1-3.66-.642L3 20.25l1.546-4.122A6.6 6.6 0 0 1 3 12c0-4.142 4.03-7.5 9-7.5s9 3.358 9 7.5Z"
                            />
                        </svg>

                        <span>
                            +52 311 165 0343
                        </span>
                    </a>
                </div>
            </div>

        </div>

        {{-- Línea inferior --}}
        <div
            class="mt-10 flex flex-col gap-3 border-t border-slate-800 pt-6
                   text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between"
        >
            <p>
                © {{ now()->year }} TramitaNet.
                Operado por Entretenimiento Berumen.
            </p>

            <p>
                Versión 1.0
            </p>
        </div>

    </div>
</footer>