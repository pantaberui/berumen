@extends('publico.tramitanet.layouts.app')

@section('title', 'Centro de Ayuda | TramitaNet')

@section('content')


{{-- HERO --}}
<section class="text-white" style="background-color: #0f172a;">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">

        <nav class="mb-4 text-sm text-slate-300">
            <a
                href="{{ route('tramitanet.index') }}"
                class="transition hover:text-white"
            >
                Inicio
            </a>

            <span class="mx-2">/</span>

            <span>Centro de Ayuda</span>
        </nav>

        <h1 class="text-3xl font-bold md:text-4xl">
            Centro de Ayuda
        </h1>

        <p class="mt-3 max-w-3xl leading-7 text-slate-300">
            Encuentra respuestas sobre solicitudes, pagos, tiempos de atención
            y el funcionamiento de TramitaNet.
        </p>

        <div class="mt-5 flex flex-wrap gap-3">

            {{-- Solicitudes --}}
            <a
                href="#solicitudes"
                class="inline-flex items-center gap-2 rounded-full border border-white/80
                    px-4 py-2 text-sm font-medium text-white transition
                    hover:bg-white hover:text-slate-900"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H6.75A2.25 2.25 0 0 0 4.5 4.5v15A2.25 2.25 0 0 0 6.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-5.25Z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M13.5 2.25V7.5a.75.75 0 0 0 .75.75h5.25"
                    />
                </svg>

                <span>Solicitudes</span>
            </a>

            {{-- Pagos --}}
            <a
                href="#pagos"
                class="inline-flex items-center gap-2 rounded-full border border-white/80
                    px-4 py-2 text-sm font-medium text-white transition
                    hover:bg-white hover:text-slate-900"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.25 8.25h19.5m-18 0V6.75A2.25 2.25 0 0 1 6 4.5h12a2.25 2.25 0 0 1 2.25 2.25v10.5A2.25 2.25 0 0 1 18 19.5H6a2.25 2.25 0 0 1-2.25-2.25v-9Z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6.75 15.75h3"
                    />
                </svg>

                <span>Pagos</span>
            </a>

            {{-- Entrega --}}
            <a
                href="#entrega"
                class="inline-flex items-center gap-2 rounded-full border border-white/80
                    px-4 py-2 text-sm font-medium text-white transition
                    hover:bg-white hover:text-slate-900"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                    />
                </svg>

                <span>Entrega</span>
            </a>

            {{-- Seguridad --}}
            <a
                href="#seguridad"
                class="inline-flex items-center gap-2 rounded-full border border-white/80
                    px-4 py-2 text-sm font-medium text-white transition
                    hover:bg-white hover:text-slate-900"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.96 11.96 0 0 1 3.598 6a11.99 11.99 0 0 0 8.402 15 11.99 11.99 0 0 0 8.402-15A11.96 11.96 0 0 1 12 2.714Z"
                    />
                </svg>

                <span>Seguridad</span>
            </a>

            {{-- Reembolsos --}}
            <a
                href="#reembolsos"
                class="inline-flex items-center gap-2 rounded-full border border-white/80
                    px-4 py-2 text-sm font-medium text-white transition
                    hover:bg-white hover:text-slate-900"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 14.25 4.5 9.75 9 5.25M4.5 9.75H15a4.5 4.5 0 0 1 0 9h-1.5"
                    />
                </svg>

                <span>Reembolsos</span>
            </a>

            {{-- Contacto --}}
            <a
                href="#contacto"
                class="inline-flex items-center gap-2 rounded-full border border-white/80
                    px-4 py-2 text-sm font-medium text-white transition
                    hover:bg-white hover:text-slate-900"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8.625 9.75h.008v.008h-.008V9.75Zm3.375 0h.008v.008H12V9.75Zm3.375 0h.008v.008h-.008V9.75ZM21 12c0 4.142-4.03 7.5-9 7.5a10.55 10.55 0 0 1-3.66-.642L3 20.25l1.546-4.122A6.6 6.6 0 0 1 3 12c0-4.142 4.03-7.5 9-7.5s9 3.358 9 7.5Z"
                    />
                </svg>

                <span>Contacto</span>
            </a>

        </div>

    </div>
</section>

{{-- CONTENIDO --}}
<main class="bg-slate-50">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">

        {{-- Buscador --}}
        <div class="mx-auto mb-12 max-w-2xl">

            <label for="buscarFaq" class="sr-only">
                Buscar una pregunta
            </label>

            <div class="relative">

                <svg
                    class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m21 21-4.35-4.35m1.85-5.65a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"
                    />
                </svg>

                <input
                    id="buscarFaq"
                    type="search"
                    placeholder="Busca por trámite, pago, folio o palabra clave..."
                    class="w-full rounded-xl border border-gray-300 bg-white py-4 pl-12 pr-4 shadow-sm outline-none transition focus:border-blue-600 focus:ring-4 focus:ring-blue-100"
                >

            </div>
        </div>

        <div id="faqContainer">

            <section id="general" class="mb-12">

                <div class="mb-6 flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M7.5 3.75h6.879c.398 0 .779.158 1.061.439l3.371 3.371c.281.282.439.663.439 1.061V19.5a.75.75 0 0 1-.75.75h-11.25a.75.75 0 0 1-.75-.75v-15a.75.75 0 0 1 .75-.75Z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14.25 3.75V8.25h4.5M9 12h6M9 15.75h6"
                            />
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">
                            Primeros Pasos
                        </h2>

                        <p class="text-sm text-slate-600">
                            Conoce cómo funciona TramitaNet y cómo comenzar.
                        </p>
                    </div>
                </div>

                <div class="space-y-4">

                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Qué es TramitaNet?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-200 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            TramitaNet es una plataforma donde puedes solicitar diversos trámites
                            en línea de forma sencilla y segura.
                        </div>

                    </details>

                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Cómo funciona TramitaNet?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-200 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Elige un trámite, completa el formulario, realiza el pago, sube tu
                            comprobante y da seguimiento a tu solicitud hasta recibir tu documento.
                        </div>

                    </details>

                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Quién puede solicitar un trámite?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-200 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Cualquier persona que cumpla con los requisitos del servicio seleccionado.
                        </div>

                    </details>

                </div>

            </section>

            <section id="solicitudes" class="mb-12">

                <div class="mb-6 flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-blue-700">

                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                            />
                        </svg>

                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">
                            Solicitudes
                        </h2>

                        <p class="text-sm text-slate-600">
                            Registro, folio y seguimiento de tu solicitud.
                        </p>
                    </div>

                </div>

                <div class="space-y-4">

                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Cómo puedo realizar una solicitud?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Selecciona el trámite, completa el formulario y confirma tu solicitud.
                            El sistema generará tu folio y referencia de pago.
                        </div>

                    </details>

                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Qué información necesito para solicitar un trámite?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Cada trámite indica los datos y documentos necesarios antes de comenzar.
                        </div>

                    </details>

                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Qué es el folio de solicitud?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Es el identificador único asignado a tu trámite. Debes conservarlo,
                            ya que te permitirá consultar el estado de la solicitud y acceder
                            a la información de seguimiento.
                        </div>

                    </details>

                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Cómo puedo consultar el estado de mi solicitud?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Utiliza la opción “Consultar folio” del menú principal e ingresa
                            los datos de seguimiento proporcionados al registrar la solicitud.
                        </div>

                    </details>

                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Puedo modificar una solicitud después de registrarla?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Si aún no ha sido atendida, comunícate con nosotros para revisar
                            si el cambio es posible.
                        </div>

                    </details>

                </div>

            </section>


            <section id="pagos" class="mb-12">

                <div class="mb-6 flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">

                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.25 8.25h19.5M3.75 5.25h16.5A1.5 1.5 0 0 1 21.75 6.75v10.5a1.5 1.5 0 0 1-1.5 1.5H3.75a1.5 1.5 0 0 1-1.5-1.5V6.75a1.5 1.5 0 0 1 1.5-1.5ZM6 15h3"
                            />
                        </svg>

                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">
                            Métodos de pago, comprobantes y validación.
                        </h2>

                        <p class="text-sm text-slate-600">
                            Puedes pagar mediante transferencia bancaria o depósito en efectivo
                            utilizando los datos y el número de tarjeta mostrados en tu solicitud.
                        </p>
                    </div>

                </div>

                <div class="space-y-4">

                    {{-- Pregunta 1 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Cómo puedo pagar mi solicitud?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Después de registrar tu solicitud, TramitaNet mostrará los datos
                            bancarios disponibles, el importe total y la referencia que debes
                            utilizar. Realiza la transferencia desde tu aplicación bancaria
                            y posteriormente carga el comprobante de pago en tu expediente.
                        </div>

                    </details>

                    {{-- Pregunta 2 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Qué referencia debo escribir al realizar la transferencia?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Debes utilizar la referencia bancaria de siete dígitos que aparece
                            en la información de pago de tu solicitud. Captúrala exactamente
                            como se muestra para facilitar la identificación de la transferencia.
                        </div>

                    </details>

                    {{-- Pregunta 3 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Dónde envío mi comprobante de pago?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Ingresa a tu expediente utilizando el folio y el código de
                            seguimiento. En la sección de pago encontrarás la opción para
                            seleccionar y cargar la imagen o archivo de tu comprobante.
                        </div>

                    </details>

                    {{-- Pregunta 4 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Qué sucede después de enviar el comprobante?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            El comprobante pasará a revisión. Mientras se valida, el expediente
                            mostrará el pago en revisión. Una vez confirmado, el estado de la
                            solicitud cambiará y podrá comenzar la gestión del trámite.
                        </div>

                    </details>

                    {{-- Pregunta 5 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Qué hago si mi comprobante fue rechazado?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Revisa el motivo indicado en tu expediente y carga un nuevo
                            comprobante con la información correcta y claramente visible.
                        </div>

                    </details>

                    {{-- Pregunta 6 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿El precio mostrado incluye comisión?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Sí. Antes de confirmar la solicitud verás el costo, la comisión
                            aplicable y el total exacto que debes pagar.
                        </div>

                    </details>

                </div>

            </section>



            <section id="entrega" class="mb-12">

                <div class="mb-6 flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-100 text-violet-700">

                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 6v6l4 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                            />
                        </svg>

                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">
                            Entrega
                        </h2>

                        <p class="text-sm text-slate-600">
                            Tiempos estimados, disponibilidad y entrega de documentos.
                        </p>
                    </div>

                </div>

                <div class="space-y-4">

                    {{-- Pregunta 1 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Cuánto tiempo tarda la entrega de mi trámite?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Cada servicio muestra un tiempo estimado. El plazo comienza cuando
                            el pago ha sido validado y la información está completa.
                        </div>

                    </details>

                    {{-- Pregunta 2 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿El tiempo de entrega está garantizado?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            No. Los tiempos mostrados son estimados y pueden variar. En
                            algunos trámites dependemos de la disponibilidad de los sistemas
                            o servicios de la institución correspondiente, así como del
                            volumen de solicitudes que se encuentren en atención en ese
                            momento.
                        </div>

                    </details>

                    {{-- Pregunta 3 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Qué puede ocasionar que mi trámite tarde más de lo estimado?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Puede haber demoras por datos incorrectos, documentos incompletos,
                            alta demanda o fallas temporales en plataformas externas.
                        </div>

                    </details>

                    {{-- Pregunta 4 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Cómo sabré que mi trámite está listo?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Puedes consultar en cualquier momento el estado de tu solicitud
                            desde la opción “Consultar folio”. Cuando el trámite sea concluido,
                            el expediente mostrará el estado correspondiente y las indicaciones
                            para acceder al documento o resultado.
                        </div>

                    </details>

                    {{-- Pregunta 5 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Cómo recibo el documento generado?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Cuando la entrega sea digital, el documento estará disponible en tu
                            expediente. Algunos servicios pueden mostrar instrucciones adicionales.
                        </div>

                    </details>

                    {{-- Pregunta 6 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Qué debo hacer si ya pasó el tiempo estimado?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Primero consulta el estado de tu expediente para verificar si
                            existe alguna nota o actualización. Si no encuentras información
                            suficiente, comunícate con soporte y proporciona tu folio para
                            revisar el avance de la solicitud.
                        </div>

                    </details>

                </div>

            </section>


            <section id="seguridad" class="mb-12">

                <div class="mb-6 flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-700">

                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 3 4.5 6v5.25c0 4.785 3.06 8.91 7.5 10.5 4.44-1.59 7.5-5.715 7.5-10.5V6L12 3Z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m9.75 12 1.5 1.5 3-3"
                            />
                        </svg>

                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">
                            Seguridad y privacidad
                        </h2>

                        <p class="text-sm text-slate-600">
                            Protección de tu información y uso seguro de la plataforma.
                        </p>
                    </div>

                </div>

                <div class="space-y-4">

                    {{-- Pregunta 1 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Es seguro proporcionar mis datos en TramitaNet?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Sí. Tus datos se utilizan únicamente para gestionar el trámite
                            solicitado y brindar seguimiento a tu solicitud.
                        </div>

                    </details>

                    {{-- Pregunta 2 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Para qué se utilizan mis datos personales?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Se utilizan exclusivamente para realizar el trámite solicitado,
                            comunicarnos contigo y entregar el resultado del servicio.
                        </div>

                    </details>

                    {{-- Pregunta 3 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Quién puede consultar mi expediente?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Solo quien cuente con el folio y el código de consulta podrá acceder
                            al expediente de la solicitud.
                        </div>

                    </details>

                    {{-- Pregunta 4 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Qué cuidados debo tener con mi folio y código de seguimiento?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Consérvalos en un lugar seguro y no los compartas con terceros si no
                            deseas que consulten tu expediente.
                        </div>

                    </details>

                    {{-- Pregunta 5 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿TramitaNet solicita contraseñas bancarias?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            No. Nunca solicitaremos contraseñas bancarias, códigos de seguridad
                            ni información para acceder a tus cuentas.
                        </div>

                    </details>

                    {{-- Pregunta 6 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Cómo identifico una comunicación legítima de TramitaNet?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Las comunicaciones relacionadas con tu solicitud deben coincidir
                            con los datos y el estado que aparecen en tu expediente. Ante
                            mensajes sospechosos, no abras enlaces ni compartas información;
                            consulta directamente tu folio o comunícate con soporte.
                        </div>

                    </details>

                    {{-- Pregunta 7 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Dónde puedo consultar el aviso de privacidad?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Puedes consultarlo desde el enlace "Aviso de privacidad" disponible
                            en el pie de página del sitio.
                        </div>

                    </details>

                </div>

            </section>


            <section id="reembolsos" class="mb-12">

                <div class="mb-6 flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-rose-100 text-rose-700">

                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 14.25 4.5 9.75 9 5.25M4.5 9.75H15a4.5 4.5 0 0 1 0 9h-1.5"
                            />
                        </svg>

                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">
                            Reembolsos y cancelaciones
                        </h2>

                        <p class="text-sm text-slate-600">
                            Cancelaciones, devoluciones y servicios no disponibles.
                        </p>
                    </div>

                </div>

                <div class="space-y-4">

                    {{-- Pregunta 1 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Puedo cancelar una solicitud?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Sí, siempre que la gestión del trámite aún no haya comenzado.
                            Contáctanos lo antes posible para revisar tu caso.
                        </div>

                    </details>

                    {{-- Pregunta 2 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿En qué casos puede proceder un reembolso?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Cuando el trámite no pueda realizarse por causas atribuibles a
                            TramitaNet o a la institución correspondiente.
                        </div>

                    </details>

                    {{-- Pregunta 3 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Qué sucede si la institución no tiene disponible el documento?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Te informaremos la situación y, cuando corresponda, iniciaremos el
                            proceso de reembolso conforme a nuestras políticas.
                        </div>

                    </details>

                    {{-- Pregunta 4 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿La comisión de servicio también se devuelve?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Dependerá del motivo de la cancelación o del reembolso. Consulta
                            nuestros Términos y Condiciones para conocer los casos aplicables.
                        </div>

                    </details>

                    {{-- Pregunta 5 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Cómo solicito un reembolso?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Comunícate con nosotros y proporciona tu folio para revisar la
                            solicitud y, en su caso, iniciar el proceso correspondiente.
                        </div>

                    </details>

                    {{-- Pregunta 6 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Cuánto tarda un reembolso?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            El tiempo puede variar según el método de pago utilizado y la
                            institución financiera correspondiente.
                        </div>

                    </details>

                    {{-- Pregunta 7 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Qué sucede si proporcioné información incorrecta?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Si el trámite aún no ha iniciado, contáctanos de inmediato. Una vez
                            comenzada la gestión, podría no ser posible realizar cambios.
                        </div>

                    </details>

                </div>

            </section>


            <section id="contacto" class="mb-12">

                <div class="mb-6 flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-100 text-sky-700">

                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M18 10.5c0 4.142-2.686 7.5-6 7.5a5.37 5.37 0 0 1-2.25-.49L6 18.75l.967-2.902A7.01 7.01 0 0 1 6 12c0-4.142 2.686-7.5 6-7.5s6 2.858 6 6Z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9.75 10.5h.008v.008H9.75V10.5Zm2.25 0h.008v.008H12V10.5Zm2.25 0h.008v.008h-.008V10.5Z"
                            />
                        </svg>

                    </div>

                    <h2 class="text-2xl font-bold text-slate-900">
                        Contacto
                    </h2>

                    <p class="text-sm text-slate-600">
                        Atención al usuario y medios de contacto.
                    </p>

                </div>

                <div class="space-y-4">

                    {{-- Pregunta 1 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Cuándo debo comunicarme con soporte?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Si tienes dudas sobre tu solicitud, un pago, el estado de tu trámite
                            o necesitas ayuda durante el proceso.
                        </div>

                    </details>

                    {{-- Pregunta 2 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Qué información debo proporcionar al solicitar ayuda?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Comparte tu folio de solicitud y describe brevemente la situación para
                            brindarte una atención más rápida.
                        </div>

                    </details>

                    {{-- Pregunta 3 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Puedo enviar documentos por WhatsApp?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Solo cuando nuestro equipo lo solicite como parte del seguimiento de
                            tu trámite.
                        </div>

                    </details>

                    {{-- Pregunta 4 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿En qué horario se atienden las solicitudes de soporte?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Atendemos en días y horarios hábiles. Las consultas recibidas fuera
                            de ese horario se responderán lo antes posible.
                        </div>

                    </details>

                    {{-- Pregunta 5 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Por qué soporte puede tardar en responder?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            El tiempo de respuesta puede variar según el volumen de consultas y
                            la complejidad de cada caso.
                        </div>

                    </details>

                    {{-- Pregunta 6 --}}
                    <details class="faq-item group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:border-blue-200 hover:shadow-md">

                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 font-semibold text-slate-900">

                            <span>¿Cómo puedo dar seguimiento a una aclaración?</span>

                            <svg
                                class="h-5 w-5 flex-none text-blue-600 transition-transform duration-300 group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19 9-7 7-7-7"
                                />
                            </svg>

                        </summary>

                        <div class="border-t border-slate-100 px-6 py-5 leading-7 text-slate-600">
                            Conserva tu folio y continúa la comunicación por el mismo medio para
                            facilitar el seguimiento de tu caso.
                        </div>

                    </details>

                </div>

            </section>


            <section class="mt-16">

                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl">

                    <div class="px-6 py-8 sm:px-8 lg:px-10 lg:py-10">

                        {{-- Encabezado --}}
                        <div class="mb-8">

                            <span
                                class="inline-flex items-center gap-2 rounded-full
                                    border border-blue-200 bg-blue-50
                                    px-4 py-1.5 text-sm font-semibold text-blue-700"
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M8.625 9.75h.008v.008h-.008V9.75Zm3.375 0h.008v.008H12V9.75Zm3.375 0h.008v.008h-.008V9.75ZM21 12c0 4.142-4.03 7.5-9 7.5a10.55 10.55 0 0 1-3.66-.642L3 20.25l1.546-4.122A6.6 6.6 0 0 1 3 12c0-4.142 4.03-7.5 9-7.5s9 3.358 9 7.5Z"
                                    />
                                </svg>

                                ¿No encontraste la respuesta?
                            </span>

                            <h2 class="mt-5 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                                Estamos para ayudarte
                            </h2>

                            <p class="mt-4 max-w-3xl text-base leading-7 text-slate-600 sm:text-lg">
                                Si tienes dudas sobre tu trámite o necesitas ayuda con tu
                                solicitud, comunícate con nosotros. Ten a la mano tu
                                <strong class="font-semibold text-slate-900">
                                    folio de seguimiento
                                </strong>
                                para brindarte una atención más rápida.
                            </p>

                        </div>

                        {{-- Contenido --}}
                        <div class="grid gap-8 lg:grid-cols-2">

                            {{-- Botones --}}
                            <div class="space-y-4">

                                <a
                                    href="https://wa.me/523111650343"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex w-full items-center justify-center gap-3
                                        rounded-xl bg-green-600 px-6 py-4
                                        font-semibold text-white shadow-sm
                                        transition hover:bg-green-500
                                        focus:outline-none focus:ring-4 focus:ring-green-200"
                                >
                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M8.625 6.75a.375.375 0 0 1 .375-.375h1.5a.375.375 0 0 1 .375.375v3a.375.375 0 0 1-.375.375H9.75a6 6 0 0 0 6 6v-.75a.375.375 0 0 1 .375-.375h3a.375.375 0 0 1 .375.375v1.5a.375.375 0 0 1-.375.375H18A11.25 11.25 0 0 1 6.75 6v-1.125A.375.375 0 0 1 7.125 4.5h1.5Z"
                                        />
                                    </svg>

                                    Contactar por WhatsApp
                                </a>

                                <a
                                    href="mailto:tramitanet.berumen@gmail.com"
                                    class="inline-flex w-full items-center justify-center gap-3
                                        rounded-xl border border-slate-300 bg-slate-50
                                        px-6 py-4 font-semibold text-slate-800
                                        transition hover:border-blue-300 hover:bg-blue-50
                                        hover:text-blue-700
                                        focus:outline-none focus:ring-4 focus:ring-blue-100"
                                >
                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M21.75 6.75v10.5A2.25 2.25 0 0 1 19.5 19.5h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0-8.69 5.517a2 2 0 0 1-2.12 0L2.25 6.75"
                                        />
                                    </svg>

                                    Enviar correo
                                </a>

                            </div>

                            {{-- Datos de contacto --}}
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">

                                <h3 class="text-lg font-bold text-slate-900">
                                    Datos de contacto
                                </h3>

                                <div class="mt-5 space-y-5">

                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                            Correo electrónico
                                        </p>

                                        <a
                                            href="mailto:tramitanet.berumen@gmail.com"
                                            class="mt-1 block break-all font-semibold text-blue-700 hover:text-blue-600"
                                        >
                                            tramitanet.berumen@gmail.com
                                        </a>
                                    </div>

                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                                            WhatsApp
                                        </p>

                                        <a
                                            href="https://wa.me/523111650343"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="mt-1 block font-semibold text-green-700 hover:text-green-600"
                                        >
                                            +52 311 165 0343
                                        </a>
                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- Horario --}}
                        <div class="mt-8 border-t border-slate-200 pt-6">

                            <p class="text-center text-sm leading-6 text-slate-500">
                                Nuestro horario de atención es en días hábiles. Las consultas
                                recibidas fuera de horario serán atendidas a la brevedad posible.
                            </p>

                        </div>

                    </div>

                </div>

            </section>

            <p class="mt-8 text-center text-sm text-slate-400">
                Nuestro horario de atención es en días hábiles. Las consultas recibidas
                fuera de horario serán atendidas a la brevedad posible.
            </p>



        </div>

        <div
            id="sinResultados"
            class="hidden rounded-xl border border-slate-200 bg-white p-8 text-center shadow-sm"
        >
            <h3 class="text-xl font-semibold text-slate-900">
                No encontramos resultados
            </h3>

            <p class="mt-2 text-slate-600">
                Intenta escribir otra palabra o consulta nuestras categorías.
            </p>
        </div>

    </div>
</main>


<script>

    document.addEventListener('DOMContentLoaded', () => {

        const buscador = document.getElementById('buscarFaq');

        buscador.addEventListener('keyup', () => {

            const texto = buscador.value.toLowerCase();

            const preguntas = document.querySelectorAll('.faq-item');

            let visibles = 0;

            preguntas.forEach(item => {

                const contenido = item.innerText.toLowerCase();

                if (contenido.includes(texto)) {

                    item.style.display = '';

                    visibles++;

                } else {

                    item.style.display = 'none';

                }

            });

            document
                .getElementById('sinResultados')
                .classList.toggle('hidden', visibles > 0);

        });

    });

</script>

<style>
    html {
        scroll-behavior: smooth;
    }

    section[id] {
        scroll-margin-top: 110px;
    }
</style>

@endsection
