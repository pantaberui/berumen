@extends('publico.tramitanet.layouts.app')

@section('title', 'Terminos y Condiciones | TramitaNet')

@section('content')
    <section class="bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 text-white">
        <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">

            <nav class="mb-6 text-sm text-slate-300" aria-label="Navegación">
                <a
                    href="{{ route('tramitanet.index') }}"
                    class="transition hover:text-orange-400"
                >
                    Inicio
                </a>

                <span class="mx-2 text-slate-500">/</span>

                <span class="font-semibold text-white">
                    Terminos y Condiciones
                </span>
            </nav>

            <div class="max-w-3xl">
                <div class="mb-5 inline-flex items-center gap-2 rounded-full
                            border border-blue-400/30 bg-blue-500/10
                            px-4 py-2 text-sm font-bold text-blue-200">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M12 3.75
                               5.25 6v5.25c0 4.195 2.865 8.065
                               6.75 9 3.885-.935 6.75-4.805
                               6.75-9V6L12 3.75Z"
                        />
                    </svg>

                    Terminos y Condiciones
                </div>

                <h1 class="text-3xl font-black tracking-tight sm:text-5xl">
                    Terminos y Condiciones
                </h1>

                <p class="mt-5 text-base leading-7 text-slate-300 sm:text-lg">
                    Conoce cómo recopilamos, utilizamos y protegemos la
                    información que proporcionas al solicitar un servicio
                    mediante TramitaNet.
                </p>
            </div>
        </div>
    </section>

    <main class="bg-slate-50">
        <h1>Términos y condiciones</h1>

        <p>
            Estos términos regulan el uso de la plataforma TramitaNet y la solicitud
            de servicios digitales ofrecidos por Entretenimiento Berumen.
        </p>

        <h2>Uso de la plataforma</h2>

        <p>
            La persona usuaria se compromete a proporcionar información verdadera,
            completa y actualizada durante la solicitud de cualquier servicio.
        </p>

        <h2>Pagos y comprobantes</h2>

        <p>
            Los servicios sujetos a pago serán procesados después de la validación
            del comprobante correspondiente. El envío de un comprobante no implica
            por sí mismo la confirmación del pago.
        </p>

        <h2>Tiempos de atención</h2>

        <p>
            Los tiempos mostrados son estimados y pueden variar por causas ajenas a
            TramitaNet, incluyendo disponibilidad de plataformas oficiales,
            validaciones adicionales o días inhábiles.
        </p>

        <h2>Responsabilidad de la persona usuaria</h2>

        <p>
            La persona usuaria es responsable de verificar que los datos y documentos
            proporcionados sean correctos antes de enviar su solicitud.
        </p>

        <h2>Contacto</h2>

        <p>
            Para dudas relacionadas con una solicitud, se deberán utilizar los medios
            de contacto disponibles en la plataforma.
        </p>
    </main>
@endsection