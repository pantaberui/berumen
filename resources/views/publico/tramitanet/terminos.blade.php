@extends('publico.tramitanet.layouts.app')

@section('title', 'Términos y Condiciones | TramitaNet')

@section('content')

<section class="bg-slate-900 text-white">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

        <nav class="mb-6 text-sm text-slate-300" aria-label="Navegación">
            <a
                href="{{ route('tramitanet.index') }}"
                class="transition hover:text-orange-400"
            >
                Inicio
            </a>

            <span class="mx-2 text-slate-500">/</span>

            <span class="font-semibold text-white">
                Términos y Condiciones
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

                Información importante
            </div>

            <h1 class="text-3xl font-black tracking-tight sm:text-5xl">
                Términos y Condiciones
            </h1>

            <p class="mt-5 text-base leading-7 text-slate-300 sm:text-lg">
                Estos Términos y Condiciones regulan el acceso y uso de
                TramitaNet, así como la contratación de los servicios de
                gestión disponibles a través de la plataforma.
            </p>
        </div>
    </div>
</section>


<main class="bg-slate-50">
    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">

        <div class="rounded-2xl border border-slate-200 bg-white
                    p-6 shadow-sm sm:p-10">

            <div class="prose prose-slate max-w-none">

                <p class="text-sm text-slate-500">
                    Última actualización: agosto de 2026
                </p>


                <h2>1. Aceptación de los términos</h2>

                <p>
                    Al acceder a TramitaNet o solicitar cualquiera de los
                    servicios disponibles en la plataforma, la persona usuaria
                    declara haber leído, comprendido y aceptado los presentes
                    Términos y Condiciones.
                </p>

                <p>
                    Si la persona usuaria no está de acuerdo con estos términos,
                    deberá abstenerse de utilizar los servicios ofrecidos a
                    través de TramitaNet.
                </p>


                <h2>2. Naturaleza del servicio</h2>

                <p>
                    TramitaNet es una plataforma de servicios digitales operada
                    por Entretenimiento Berumen, mediante la cual se ofrecen
                    servicios de apoyo, orientación y gestión de trámites a
                    solicitud de las personas usuarias.
                </p>

                <div class="my-6 rounded-xl border border-amber-200
                            bg-amber-50 p-5 text-amber-900">

                    <strong>Importante:</strong>

                    TramitaNet y Entretenimiento Berumen son servicios
                    independientes y no forman parte, representan ni sustituyen
                    a las instituciones gubernamentales relacionadas con los
                    trámites ofrecidos.

                </div>

                <p>
                    Los nombres de instituciones que puedan aparecer en la
                    plataforma se utilizan únicamente para identificar la
                    institución relacionada con cada trámite o servicio.
                </p>


                <h2>3. Información proporcionada por la persona usuaria</h2>

                <p>
                    Para realizar determinados servicios puede ser necesario
                    proporcionar datos personales, identificadores, documentos
                    o información relacionada con el trámite solicitado.
                </p>

                <p>
                    La persona usuaria se compromete a proporcionar información
                    verdadera, completa, legible y actualizada.
                </p>

                <p>
                    TramitaNet no será responsable por retrasos, rechazos,
                    resultados incorrectos o imposibilidad de realizar un
                    servicio cuando éstos sean consecuencia de información
                    incorrecta, incompleta o ilegible proporcionada por la
                    persona usuaria.
                </p>


                <h2>4. Documentos proporcionados</h2>

                <p>
                    Cuando un servicio requiera documentos, archivos,
                    identificaciones, constancias u otros elementos digitales,
                    la persona usuaria será responsable de verificar que los
                    archivos enviados correspondan al trámite solicitado y sean
                    legibles.
                </p>

                <p>
                    TramitaNet podrá solicitar información o documentación
                    adicional cuando resulte necesaria para continuar con la
                    gestión.
                </p>


                <h2>5. Precios y pagos</h2>

                <p>
                    Antes de confirmar una solicitud, la plataforma mostrará el
                    importe correspondiente al servicio.
                </p>

                <p>
                    Dependiendo del trámite, dicho importe podrá incluir costos
                    asociados a la obtención del documento o servicio, así como
                    cargos correspondientes al servicio de gestión realizado
                    por TramitaNet.
                </p>

                <p>
                    Cuando el pago se realice mediante transferencia, depósito
                    u otro medio que requiera comprobación, el envío del
                    comprobante no implica por sí mismo que el pago haya sido
                    confirmado.
                </p>

                <p>
                    La solicitud continuará su procesamiento una vez que el pago
                    haya sido identificado y validado.
                </p>


                <h2>6. Referencia de pago</h2>

                <p>
                    Algunas solicitudes generan una referencia destinada a
                    facilitar la identificación del pago.
                </p>

                <p>
                    La persona usuaria deberá utilizar correctamente dicha
                    referencia cuando así se indique. La ausencia o captura
                    incorrecta de la referencia puede retrasar la identificación
                    del pago.
                </p>


                <h2>7. Tiempos estimados</h2>

                <p>
                    Los tiempos indicados en cada servicio son estimados y se
                    consideran dentro de los horarios de atención publicados
                    por TramitaNet.
                </p>

                <p>
                    Estos tiempos pueden variar debido a disponibilidad de
                    plataformas externas, mantenimiento de sistemas oficiales,
                    validaciones adicionales, saturación de servicios, días
                    inhábiles o cualquier otra circunstancia ajena al control
                    de TramitaNet.
                </p>

                <p>
                    Por lo anterior, los tiempos mostrados no constituyen una
                    garantía de entrega en un momento exacto.
                </p>


                <h2>8. Disponibilidad de plataformas externas</h2>

                <p>
                    Algunos servicios dependen total o parcialmente de sistemas,
                    plataformas o bases de datos administradas por terceros o
                    instituciones públicas.
                </p>

                <p>
                    TramitaNet no puede garantizar la disponibilidad permanente
                    de dichos sistemas y no será responsable por interrupciones,
                    mantenimientos, cambios técnicos o restricciones impuestas
                    por las instituciones correspondientes.
                </p>


                <h2>9. Imposibilidad de realizar un trámite</h2>

                <p>
                    En determinados casos puede no ser posible obtener el
                    documento o completar el servicio solicitado debido a
                    inexistencia del registro, inconsistencias en la información,
                    restricciones de la institución correspondiente o cualquier
                    otra circunstancia ajena a TramitaNet.
                </p>

                <p>
                    En estos casos se informará a la persona usuaria sobre la
                    situación y, cuando corresponda conforme a las condiciones
                    específicas del servicio, se indicarán las opciones
                    disponibles.
                </p>


                <h2>10. Cancelaciones y reembolsos</h2>

                <p>
                    La posibilidad de cancelar una solicitud o recibir un
                    reembolso dependerá del estado en que se encuentre el
                    servicio y de si ya se realizaron pagos, consultas,
                    derechos, gestiones o actividades necesarias para su
                    procesamiento.
                </p>

                <p>
                    Cuando un trámite no pueda realizarse por causas ajenas a la
                    persona usuaria, TramitaNet revisará el caso y determinará
                    el reembolso que corresponda de acuerdo con las
                    características particulares del servicio.
                </p>

                <p>
                    No procederá automáticamente un reembolso cuando el servicio
                    no pueda completarse debido a datos incorrectos, documentos
                    inválidos o información insuficiente proporcionada por la
                    persona usuaria.
                </p>


                <h2>11. Entrega de documentos</h2>

                <p>
                    Los documentos o resultados generados podrán entregarse por
                    los medios habilitados en TramitaNet, incluyendo la consulta
                    de la solicitud, descarga digital, correo electrónico u
                    otros medios indicados para cada servicio.
                </p>

                <p>
                    La persona usuaria es responsable de conservar su folio y
                    código de seguimiento.
                </p>


                <h2>12. Comunicaciones</h2>

                <p>
                    Al proporcionar un correo electrónico o número de WhatsApp,
                    la persona usuaria acepta que TramitaNet pueda utilizar
                    dichos medios para enviar información relacionada con su
                    solicitud, incluyendo confirmaciones, cambios de estado,
                    solicitudes de información adicional y avisos de
                    disponibilidad del resultado.
                </p>


                <h2>13. Uso adecuado de la plataforma</h2>

                <p>
                    La persona usuaria se compromete a utilizar TramitaNet
                    únicamente para fines lícitos y relacionados con los
                    servicios disponibles.
                </p>

                <p>
                    Queda prohibido intentar alterar el funcionamiento de la
                    plataforma, acceder sin autorización a información de otras
                    personas, proporcionar documentación deliberadamente falsa
                    o utilizar el servicio para realizar actividades ilícitas.
                </p>


                <h2>14. Protección de datos personales</h2>

                <p>
                    El tratamiento de los datos personales proporcionados
                    mediante TramitaNet se realizará conforme al Aviso de
                    Privacidad disponible en la plataforma.
                </p>

                <p>
                    Puedes consultar dicho documento en:
                </p>

                <p>
                    <a
                        href="{{ route('tramitanet.aviso-privacidad') }}"
                        class="font-semibold text-blue-600 hover:text-blue-800"
                    >
                        Aviso de Privacidad de TramitaNet
                    </a>
                </p>


                <h2>15. Modificaciones al servicio</h2>

                <p>
                    TramitaNet podrá modificar, actualizar, incorporar o retirar
                    servicios, modalidades, precios, requisitos y funcionalidades
                    de la plataforma cuando resulte necesario.
                </p>

                <p>
                    Las condiciones aplicables a una solicitud serán aquellas
                    mostradas al momento de su registro, salvo que exista una
                    modificación necesaria por disposición de la institución
                    responsable del trámite.
                </p>


                <h2>16. Limitación de responsabilidad</h2>

                <p>
                    TramitaNet realizará las gestiones correspondientes con la
                    diligencia razonablemente necesaria para prestar el servicio
                    solicitado.
                </p>

                <p>
                    Sin embargo, no puede garantizar resultados que dependan de
                    decisiones, validaciones, disponibilidad de información o
                    sistemas administrados por instituciones o terceros.
                </p>


                <h2>17. Contacto y aclaraciones</h2>

                <p>
                    Para cualquier duda, aclaración o incidencia relacionada con
                    una solicitud, la persona usuaria podrá utilizar los medios
                    de contacto publicados en TramitaNet.
                </p>

                <p>
                    Para facilitar la atención se recomienda proporcionar el
                    folio correspondiente a la solicitud.
                </p>


                <h2>18. Actualizaciones de estos términos</h2>

                <p>
                    Estos Términos y Condiciones podrán actualizarse cuando
                    existan cambios en los servicios, procesos o funcionamiento
                    de TramitaNet.
                </p>

                <p>
                    La versión vigente estará disponible permanentemente en esta
                    página.
                </p>


                <div class="mt-10 rounded-xl border border-blue-200
                            bg-blue-50 p-5 text-sm leading-6 text-blue-900">

                    Al registrar una solicitud en TramitaNet, la persona usuaria
                    reconoce haber leído y aceptado los presentes Términos y
                    Condiciones, así como el Aviso de Privacidad aplicable.

                </div>

            </div>
        </div>
    </div>
</main>

@endsection
