@php
    $campanias = [
        [
            'titulo' => 'Constancia de situación fiscal',
            'desktop' => 'images/tramitanet/publicidad/desktop/sat.webp',
            'mobile' => 'images/tramitanet/publicidad/mobile/sat.webp',
            'url' => route(
                'tramitanet.servicio',
                'constancia-de-situacion-fiscal-del-sat'
            ),
        ],
        [
            'titulo' => 'Acta de nacimiento certificada',
            'desktop' => 'images/tramitanet/publicidad/desktop/acta-nacimiento.webp',
            'mobile' => 'images/tramitanet/publicidad/mobile/acta-nacimiento.webp',
            'url' => route(
                'tramitanet.servicio',
                'acta-de-nacimiento'
            ),
        ],
        [
            'titulo' => 'Semanas cotizadas del IMSS',
            'desktop' => 'images/tramitanet/publicidad/desktop/semanas-imss.webp',
            'mobile' => 'images/tramitanet/publicidad/mobile/semanas-imss.webp',
            'url' => route(
                'tramitanet.servicio',
                'semanas-cotizadas-del-imss'
            ),
        ],
    ];
@endphp

<section
    class="bg-white py-6 sm:py-8"
    aria-label="Servicios destacados de TramitaNet"
>
    <div
        x-data="{
            actual: 0,
            total: {{ count($campanias) }},
            temporizador: null,
            intervalo: 5000,

            iniciar() {
                if (
                    window.matchMedia(
                        '(prefers-reduced-motion: reduce)'
                    ).matches
                ) {
                    return;
                }

                this.detener();

                this.temporizador = setInterval(() => {
                    this.siguiente();
                }, this.intervalo);
            },

            detener() {
                if (this.temporizador) {
                    clearInterval(this.temporizador);
                    this.temporizador = null;
                }
            },

            reiniciar() {
                this.detener();
                this.iniciar();
            },

            siguiente() {
                this.actual = (this.actual + 1) % this.total;
            },

            anterior() {
                this.actual =
                    (this.actual - 1 + this.total) % this.total;
            },

            mostrar(indice) {
                this.actual = indice;
                this.reiniciar();
            }
        }"
        x-init="iniciar()"
        @mouseenter="detener()"
        @mouseleave="iniciar()"
        @focusin="detener()"
        @focusout="iniciar()"
        class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
    >
        <div
            class="relative overflow-hidden rounded-2xl
                border border-slate-200 bg-white shadow-lg"
        >
           <div class="relative">
                <picture class="invisible block" aria-hidden="true">
                    <source
                        media="(min-width: 768px)"
                        srcset="{{ asset($campanias[0]['desktop']) }}"
                    >

                    <img
                        src="{{ asset($campanias[0]['mobile']) }}"
                        alt=""
                        class="block h-auto w-full"
                    >
                </picture>

                @foreach ($campanias as $indice => $campania)
                    <a
                        href="{{ $campania['url'] }}"
                        x-show="actual === {{ $indice }}"
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute inset-0 block"
                        @if ($indice !== 0)
                            style="display: none;"
                        @endif
                        aria-label="{{ $campania['titulo'] }}"
                    >
                        <picture class="block h-full w-full">
                            <source
                                media="(min-width: 768px)"
                                srcset="{{ asset($campania['desktop']) }}"
                            >

                            <img
                                src="{{ asset($campania['mobile']) }}"
                                alt="{{ $campania['titulo'] }}"
                                loading="{{ $indice === 0 ? 'eager' : 'lazy' }}"
                                fetchpriority="{{ $indice === 0 ? 'high' : 'auto' }}"
                                decoding="async"
                                class="block h-full w-full object-contain"
                            >
                        </picture>
                    </a>
                @endforeach
            </div>

            <button
                type="button"
                @click="anterior(); reiniciar()"
                class="absolute left-2 top-1/2
                       -translate-y-1/2 rounded-full
                       bg-slate-900/65 px-3 py-2 text-2xl
                       font-bold text-white shadow
                       transition hover:bg-slate-900/85
                       focus:outline-none focus:ring-2
                       focus:ring-white sm:left-4"
                aria-label="Mostrar anuncio anterior"
            >
                ‹
            </button>

            <button
                type="button"
                @click="siguiente(); reiniciar()"
                class="absolute right-2 top-1/2
                       -translate-y-1/2 rounded-full
                       bg-slate-900/65 px-3 py-2 text-2xl
                       font-bold text-white shadow
                       transition hover:bg-slate-900/85
                       focus:outline-none focus:ring-2
                       focus:ring-white sm:right-4"
                aria-label="Mostrar anuncio siguiente"
            >
                ›
            </button>
        </div>

        <div class="mt-4 flex justify-center gap-2">
            @foreach ($campanias as $indice => $campania)
                <button
                    type="button"
                    @click="mostrar({{ $indice }})"
                    class="h-2.5 rounded-full transition-all duration-300"
                    :class="
                        actual === {{ $indice }}
                            ? 'w-8 bg-blue-600'
                            : 'w-2.5 bg-slate-300 hover:bg-slate-400'
                    "
                    aria-label="Mostrar {{ strtolower($campania['titulo']) }}"
                    :aria-current="
                        actual === {{ $indice }} ? 'true' : 'false'
                    "
                ></button>
            @endforeach
        </div>

        <p class="mt-3 text-center text-sm text-slate-500">
            Selecciona una imagen para consultar el trámite.
        </p>
    </div>
</section>