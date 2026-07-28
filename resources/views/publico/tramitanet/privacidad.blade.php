@extends('publico.tramitanet.layouts.app')

@section('title', 'Aviso de Privacidad | TramitaNet')

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
                    Aviso de privacidad
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

                    Protección de datos personales
                </div>

                <h1 class="text-3xl font-black tracking-tight sm:text-5xl">
                    Aviso de Privacidad
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
        <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 sm:py-14">

            {{-- Introducción --}}
            <section class="rounded-2xl border border-blue-100 bg-blue-50 p-6 sm:p-8">
                <p class="leading-7 text-slate-700">
                    Este Aviso de Privacidad describe el tratamiento de los
                    datos personales proporcionados a través de TramitaNet,
                    plataforma operada por Entretenimiento Berumen para la
                    gestión y seguimiento de servicios digitales.
                </p>

                <p class="mt-4 text-sm font-semibold text-slate-600">
                    Última actualización: {{ now()->translatedFormat('d \d\e F \d\e Y') }}
                </p>
            </section>

            <div class="mt-8 space-y-6">

                {{-- Responsable --}}
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 flex-none items-center justify-center
                                    rounded-xl bg-blue-100 text-blue-700">
                            <span class="text-lg font-black">1</span>
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                Responsable del tratamiento
                            </h2>

                            <p class="mt-3 leading-7 text-slate-600">
                                Entretenimiento Berumen, a través de la plataforma
                                TramitaNet, es responsable de recibir, utilizar,
                                resguardar y, cuando corresponda, eliminar los datos
                                personales proporcionados por las personas usuarias.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Datos recopilados --}}
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 flex-none items-center justify-center
                                    rounded-xl bg-orange-100 text-orange-700">
                            <span class="text-lg font-black">2</span>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h2 class="text-xl font-black text-slate-900">
                                Datos personales que podemos solicitar
                            </h2>

                            <p class="mt-3 leading-7 text-slate-600">
                                Dependiendo del servicio seleccionado, TramitaNet
                                podrá solicitar algunos de los siguientes datos:
                            </p>

                            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                @foreach ([
                                    'Nombre completo',
                                    'CURP',
                                    'RFC',
                                    'Número de Seguridad Social',
                                    'Correo electrónico',
                                    'Número de WhatsApp',
                                    'Datos relacionados con el trámite',
                                    'Documentos de identificación',
                                    'Actas o documentos oficiales',
                                    'Archivos .cer y .key, cuando sean necesarios',
                                    'Comprobantes de pago',
                                    'Información necesaria para entregar el servicio',
                                ] as $dato)
                                    <div class="flex items-start gap-3 rounded-xl bg-slate-50 p-3">
                                        <svg
                                            class="mt-0.5 h-5 w-5 flex-none text-blue-600"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m4.5 12.75 6 6 9-13.5"
                                            />
                                        </svg>

                                        <span class="text-sm font-medium text-slate-700">
                                            {{ $dato }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Finalidades --}}
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 flex-none items-center justify-center
                                    rounded-xl bg-green-100 text-green-700">
                            <span class="text-lg font-black">3</span>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h2 class="text-xl font-black text-slate-900">
                                Finalidades del tratamiento
                            </h2>

                            <p class="mt-3 leading-7 text-slate-600">
                                Los datos personales serán tratados para las
                                siguientes finalidades relacionadas directamente
                                con el servicio solicitado:
                            </p>

                            <ul class="mt-4 space-y-3 text-slate-600">
                                <li class="flex gap-3">
                                    <span class="font-black text-blue-600">•</span>
                                    Registrar y gestionar la solicitud.
                                </li>

                                <li class="flex gap-3">
                                    <span class="font-black text-blue-600">•</span>
                                    Validar la información y documentación proporcionada.
                                </li>

                                <li class="flex gap-3">
                                    <span class="font-black text-blue-600">•</span>
                                    Elaborar, obtener o entregar el documento o servicio solicitado.
                                </li>

                                <li class="flex gap-3">
                                    <span class="font-black text-blue-600">•</span>
                                    Contactar a la persona usuaria para aclaraciones,
                                    notificaciones y seguimiento.
                                </li>

                                <li class="flex gap-3">
                                    <span class="font-black text-blue-600">•</span>
                                    Verificar y conciliar los pagos relacionados con la solicitud.
                                </li>

                                <li class="flex gap-3">
                                    <span class="font-black text-blue-600">•</span>
                                    Mantener un historial del avance y conclusión del expediente.
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>

                {{-- Archivos sensibles --}}
                <section class="rounded-2xl border border-amber-200 bg-amber-50 p-6 sm:p-8">
                    <div class="flex items-start gap-4">
                        <svg
                            class="mt-1 h-7 w-7 flex-none text-amber-600"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v3.75m9.303 3.376c.866
                                   1.5-.217 3.374-1.948 3.374H4.645
                                   c-1.73 0-2.813-1.874-1.948-3.374
                                   L10.052 3.38c.865-1.5 3.03-1.5
                                   3.896 0l7.355 12.746ZM12
                                   16.5h.008v.008H12V16.5Z"
                            />
                        </svg>

                        <div>
                            <h2 class="text-xl font-black text-amber-950">
                                Archivos y contraseñas de uso temporal
                            </h2>

                            <p class="mt-3 leading-7 text-amber-900/80">
                                Cuando un servicio requiera archivos electrónicos,
                                contraseñas, identificaciones o documentos oficiales,
                                estos deberán utilizarse únicamente para gestionar la
                                solicitud correspondiente. El acceso debe limitarse al
                                personal autorizado y evitarse cualquier uso distinto
                                al solicitado por la persona usuaria.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Seguridad --}}
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 flex-none items-center justify-center
                                    rounded-xl bg-violet-100 text-violet-700">
                            <span class="text-lg font-black">4</span>
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                Medidas de protección
                            </h2>

                            <p class="mt-3 leading-7 text-slate-600">
                                Se aplican medidas administrativas y técnicas
                                razonables para reducir el riesgo de pérdida,
                                alteración, acceso no autorizado o uso indebido de
                                los datos personales.
                            </p>

                            <p class="mt-3 leading-7 text-slate-600">
                                El acceso a expedientes, documentos y comprobantes
                                debe limitarse a las personas que intervienen en la
                                prestación y administración del servicio.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Conservación --}}
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 flex-none items-center justify-center
                                    rounded-xl bg-cyan-100 text-cyan-700">
                            <span class="text-lg font-black">5</span>
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                Conservación de la información
                            </h2>

                            <p class="mt-3 leading-7 text-slate-600">
                                Los datos y documentos serán conservados durante el
                                tiempo razonablemente necesario para gestionar,
                                concluir y dar seguimiento al servicio solicitado,
                                así como para atender responsabilidades
                                administrativas, fiscales o legales aplicables.
                            </p>

                            <p class="mt-3 leading-7 text-slate-600">
                                Cuando la información deje de ser necesaria, se
                                aplicarán los procedimientos correspondientes para
                                su eliminación o bloqueo, según resulte procedente.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Transferencias --}}
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 flex-none items-center justify-center
                                    rounded-xl bg-rose-100 text-rose-700">
                            <span class="text-lg font-black">6</span>
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                Comunicación de información a terceros
                            </h2>

                            <p class="mt-3 leading-7 text-slate-600">
                                Cuando sea indispensable para gestionar el servicio,
                                determinados datos podrán comunicarse a proveedores,
                                instituciones o plataformas que intervengan en la
                                realización del trámite solicitado.
                            </p>

                            <p class="mt-3 leading-7 text-slate-600">
                                No se comercializarán los datos personales de las
                                personas usuarias.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- ARCO --}}
                <section class="rounded-2xl border border-blue-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 flex-none items-center justify-center
                                    rounded-xl bg-blue-100 text-blue-700">
                            <span class="text-lg font-black">7</span>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h2 class="text-xl font-black text-slate-900">
                                Derechos ARCO
                            </h2>

                            <p class="mt-3 leading-7 text-slate-600">
                                La persona titular puede solicitar el acceso,
                                rectificación, cancelación u oposición respecto del
                                tratamiento de sus datos personales.
                            </p>

                            <p class="mt-3 leading-7 text-slate-600">
                                Para presentar una solicitud, deberá indicar su
                                nombre, medio de contacto, descripción de los datos
                                involucrados, derecho que desea ejercer y la
                                información necesaria para localizar su expediente.
                            </p>

                            <div class="mt-5 rounded-xl border border-blue-100 bg-blue-50 p-5">
                                <p class="text-sm font-bold uppercase tracking-wide text-blue-800">
                                    Medio de contacto
                                </p>

                                <a
                                    href="mailto:tramitanet.berumen@gmail.com"
                                    class="mt-2 inline-flex items-center gap-2 font-bold
                                           text-blue-700 transition hover:text-orange-600"
                                >
                                    tramitanet.berumen@gmail.com
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Cambios --}}
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 flex-none items-center justify-center
                                    rounded-xl bg-slate-100 text-slate-700">
                            <span class="text-lg font-black">8</span>
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                Modificaciones al Aviso de Privacidad
                            </h2>

                            <p class="mt-3 leading-7 text-slate-600">
                                Este aviso podrá actualizarse cuando cambien los
                                servicios, procesos internos o disposiciones
                                aplicables. La versión vigente permanecerá publicada
                                en este portal.
                            </p>
                        </div>
                    </div>
                </section>

            </div>

            {{-- Contacto final --}}
            <section class="mt-8 mb-6 rounded-2xl bg-slate-950 p-6 text-white sm:p-8">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-black">
                            ¿Tienes dudas sobre tus datos?
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-slate-300">
                            Comunícate con TramitaNet para solicitar orientación.
                        </p>
                    </div>

                    <a
                        href="{{ route('tramitanet.faq') }}#contacto"
                        class="inline-flex justify-center rounded-xl bg-orange-500
                               px-5 py-3 text-sm font-black text-white transition
                               hover:bg-orange-600"
                    >
                        Ir a contacto
                    </a>
                </div>
            </section>

        </div>
    </main>
@endsection