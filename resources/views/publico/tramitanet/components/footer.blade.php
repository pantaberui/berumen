<footer class="bg-slate-950 text-slate-300">
    <div class="mx-auto max-w-7xl px-6 py-10">

        <div class="grid gap-8 md:grid-cols-3">

            {{-- Identidad --}}
            <div>
                <p class="text-lg font-black text-white">
                    <span class="text-blue-400">Tramita</span><span class="text-orange-400">Net</span>
                </p>

                <p class="mt-3 max-w-sm text-sm leading-6 text-slate-400">
                    Servicios digitales confiables para realizar trámites,
                    pagos y solicitudes en línea con atención personalizada.
                </p>
            </div>

            {{-- Información --}}
            <div>
                <h3 class="text-sm font-black uppercase tracking-wider text-white">
                    Información
                </h3>

                <ul class="mt-4 space-y-3 text-sm">
                    <li>
                        <a
                            href="{{ route('tramitanet.faq') }}"
                            class="transition hover:text-orange-400"
                        >
                            Preguntas frecuentes
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('tramitanet.aviso-privacidad') }}"
                            class="transition hover:text-orange-400"
                        >
                            Aviso de privacidad
                        </a>
                    </li>

                    <li>
                        <span class="text-slate-500">
                            Términos y condiciones
                        </span>
                    </li>
                </ul>
            </div>

            {{-- Contacto --}}
            <div>
                <h3 class="text-sm font-black uppercase tracking-wider text-white">
                    Contacto
                </h3>

                <div class="mt-4 space-y-3 text-sm">

                    <a
                        href="mailto:tramitanet.berumen@gmail.com"
                        class="block transition hover:text-orange-400"
                    >
                        tramitanet.berumen@gmail.com
                    </a>

                    <a
                        href="https://wa.me/523111650343"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="block transition hover:text-green-400"
                    >
                        +52 311 165 0343
                    </a>

                </div>
            </div>

        </div>

        <div class="mt-8 flex flex-col gap-3 border-t border-slate-800 pt-6
                    text-xs text-slate-500 md:flex-row md:items-center md:justify-between">

            <p>
                © {{ date('Y') }} TramitaNet. Servicios Digitales Berumen.
            </p>

            <p>
                Trámites, pagos y servicios digitales con atención personalizada.
            </p>

        </div>

    </div>
</footer>
