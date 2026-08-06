@extends('publico.tramitanet.layouts.app')

@section('title', 'Aviso de Privacidad | TramitaNet')

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

            <span>Aviso de Privacidad</span>
        </nav>

        <h1 class="text-3xl font-bold md:text-4xl">
            Aviso de Privacidad
        </h1>

        <p class="mt-3 max-w-3xl leading-7 text-slate-300">
            Conoce qué información recopilamos,
            cómo la utilizamos y las medidas que aplicamos para proteger
            tus datos personales cuando utilizas TramitaNet.
        </p>

        <div class="mt-5 flex flex-wrap gap-3">

            {{-- Quienes somos --}}
            <a
                href="#responsables"
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

                <span>¿Quiénes somos?</span>
            </a>

            {{-- Información --}}
            <a
                href="#informacion"
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

                <span>Información</span>
            </a>

            {{-- Uso --}}
            <a
                href="#uso"
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

                <span>Uso</span>
            </a>

            {{-- Conservación --}}
            <a
                href="#conservacion"
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

                <span>Conservación</span>
            </a>

            <a
                href="#compartimos"
                class="inline-flex items-center gap-2 rounded-full border border-white/80
                    px-4 py-2 text-sm font-medium text-white transition
                    hover:bg-white hover:text-slate-900"
            >
                <span>Uso de datos</span>
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
                        d="M9 14.25 4.5 9.75 9 5.25M4.5 9.75H15a4.5 4.5 0 0 1 0 9h-1.5"
                    />
                </svg>

                <span>Seguridad</span>
            </a>

            {{-- Derechos --}}
            <a
                href="#derechos"
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

                <span>Derechos</span>
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

    <div id="contenidoPrivacidad">

        {{-- Nuestro compromiso --}}
        <section class="mb-12">
            <div class="rounded-2xl border border-blue-200 bg-blue-50 p-6 sm:p-8">
                <div class="flex items-start gap-4">
                    <div class="flex h-11 w-11 flex-none items-center justify-center rounded-xl bg-blue-100 text-blue-700">
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
                                d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.96 11.96 0 0 1 3.598 6a11.99 11.99 0 0 0 8.402 15 11.99 11.99 0 0 0 8.402-15A11.96 11.96 0 0 1 12 2.714Z"
                            />
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-slate-900">
                            Nuestro compromiso
                        </h2>

                        <p class="mt-2 leading-7 text-slate-700">
                            En TramitaNet tratamos tu información con responsabilidad
                            y la utilizamos únicamente para gestionar los servicios que
                            solicitas y brindarte seguimiento.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Responsable --}}
        <section id="responsable" class="mb-12">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-2xl font-bold text-slate-900">
                    ¿Quiénes somos?
                </h2>

                <div class="mt-4 space-y-4 leading-7 text-slate-600">
                    <p>
                        <strong class="font-semibold text-slate-900">
                            Servicios Digitales Berumen
                        </strong>,
                        a través de TramitaNet, es responsable del uso de la
                        información que proporcionas al utilizar nuestros servicios.
                    </p>

                    <p>
                        Nuestro compromiso es tratar tus datos de forma responsable,
                        transparente y únicamente para las finalidades explicadas en
                        este Aviso de Privacidad.
                    </p>
                </div>
            </div>
        </section>

        {{-- Información recopilada --}}
        <section id="informacion" class="mb-12">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-slate-900">
                    ¿Qué información recopilamos?
                </h2>

                <p class="mt-2 text-slate-600">
                    La información solicitada depende del trámite seleccionado.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2">

                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900">
                        Datos de identificación
                    </h3>

                    <p class="mt-3 leading-7 text-slate-600">
                        Nombre, apellidos, CURP, RFC, NSS, fecha de nacimiento,
                        sexo y entidad de nacimiento, cuando el servicio los requiera.
                    </p>
                </article>

                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900">
                        Datos de contacto
                    </h3>

                    <p class="mt-3 leading-7 text-slate-600">
                        Correo electrónico y número de WhatsApp para mantenerte
                        informado sobre el avance de tu solicitud.
                    </p>
                </article>

                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900">
                        Información del trámite
                    </h3>

                    <p class="mt-3 leading-7 text-slate-600">
                        Datos específicos necesarios para realizar el servicio,
                        como domicilio, números de crédito o identificadores.
                    </p>
                </article>

                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900">
                        Documentos y archivos
                    </h3>

                    <p class="mt-3 leading-7 text-slate-600">
                        Comprobantes, identificaciones, archivos PDF, imágenes,
                        documentos del trámite o archivos de e.firma cuando sean necesarios.
                    </p>
                </article>

            </div>
        </section>

        {{-- Uso --}}
        <section id="uso" class="mb-12">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-2xl font-bold text-slate-900">
                    ¿Para qué utilizamos tu información?
                </h2>

                <ul class="mt-5 space-y-3 text-slate-600">
                    <li>• Registrar tu solicitud.</li>
                    <li>• Gestionar el trámite seleccionado.</li>
                    <li>• Validar el pago correspondiente.</li>
                    <li>• Dar seguimiento a tu expediente.</li>
                    <li>• Comunicarnos contigo cuando sea necesario.</li>
                    <li>• Entregarte el documento o resultado del servicio.</li>
                    <li>• Atender dudas y aclaraciones.</li>
                </ul>

                <div class="mt-6 rounded-xl bg-emerald-50 p-4 text-emerald-900">
                    <strong>
                        TramitaNet no vende, renta ni comercializa tu información personal.
                    </strong>
                </div>
            </div>
        </section>

        {{-- Conservación --}}
        <section id="conservacion" class="mb-12">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-slate-900">
                    ¿Durante cuánto tiempo conservamos tu información?
                </h2>

                <p class="mt-2 text-slate-600">
                    La conservamos únicamente durante el tiempo necesario para prestar
                    el servicio y atender posibles aclaraciones.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2">

                <article class="rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm">
                    <p class="text-sm font-semibold uppercase tracking-wider text-slate-500">
                        Expediente
                    </p>

                    <p class="mt-3 text-4xl font-extrabold text-blue-700">
                        60 días
                    </p>

                    <p class="mt-3 leading-7 text-slate-600">
                        Permanecerá disponible para consulta después de la conclusión
                        o cancelación de la solicitud.
                    </p>
                </article>

                <article class="rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm">
                    <p class="text-sm font-semibold uppercase tracking-wider text-slate-500">
                        Documentos
                    </p>

                    <p class="mt-3 text-4xl font-extrabold text-blue-700">
                        6 meses
                    </p>

                    <p class="mt-3 leading-7 text-slate-600">
                        Después de ese periodo, los archivos podrán eliminarse
                        de forma permanente.
                    </p>
                </article>

            </div>
        </section>

        {{-- Compartición --}}
        <section id="compartimos" class="mb-12">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-2xl font-bold text-slate-900">
                    ¿Compartimos tu información?
                </h2>

                <p class="mt-4 leading-7 text-slate-600">
                    Solo podrá compartirse cuando:
                </p>

                <ul class="mt-4 space-y-3 text-slate-600">
                    <li>• Sea necesario para gestionar el trámite solicitado.</li>
                    <li>• Exista una obligación legal.</li>
                    <li>• Lo solicite una autoridad competente.</li>
                </ul>
            </div>
        </section>

        {{-- Seguridad --}}
        <section id="seguridad" class="mb-12">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-2xl font-bold text-slate-900">
                    ¿Cómo protegemos tu información?
                </h2>

                <p class="mt-4 leading-7 text-slate-600">
                    Aplicamos medidas razonables para reducir riesgos y proteger
                    la información proporcionada.
                </p>

                <ul class="mt-5 space-y-3 text-slate-600">
                    <li>• Conexiones seguras mediante HTTPS.</li>
                    <li>• Acceso restringido a la información.</li>
                    <li>• Protección del expediente mediante datos de consulta.</li>
                    <li>• Controles internos para el uso de documentos y archivos.</li>
                </ul>
            </div>
        </section>

        {{-- Derechos --}}
        <section id="derechos" class="mb-12">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-2xl font-bold text-slate-900">
                    ¿Cuáles son tus derechos?
                </h2>

                <p class="mt-4 leading-7 text-slate-600">
                    Puedes comunicarte con nosotros para solicitar, cuando corresponda:
                </p>

                <ul class="mt-5 space-y-3 text-slate-600">
                    <li>• Consultar la información que conservamos.</li>
                    <li>• Corregir datos inexactos.</li>
                    <li>• Actualizar tu información.</li>
                    <li>• Solicitar su eliminación cuando sea legalmente posible.</li>
                </ul>

                <p class="mt-5 leading-7 text-slate-600">
                    Para realizar una solicitud necesitaremos identificar el expediente
                    correspondiente y verificar que la petición provenga de la persona autorizada.
                </p>
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

                                ¿Tienes dudas sobre tu información?
                            </span>

                            <h2 class="mt-5 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                                Puedes comunicarte con nosotros
                            </h2>

                            <p class="mt-4 max-w-3xl text-base leading-7 text-slate-600 sm:text-lg">
                                Si tienes dudas sobre este Aviso de Privacidad o deseas solicitar
                                una consulta, corrección o eliminación de información, comunícate
                                con nosotros por cualquiera de los siguientes medios.
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



        </div>


    </div>
</main>



<style>
    html {
        scroll-behavior: smooth;
    }

    section[id] {
        scroll-margin-top: 110px;
    }
</style>

@endsection
