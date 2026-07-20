@php
    use App\Support\TramitaNet\EstadosSolicitud;

    $ordenEstados = EstadosSolicitud::orden();
    $pasoActual = $ordenEstados[$solicitud->estatus] ?? 1;
@endphp

@extends('publico.tramitanet.layouts.app')

@section('title', 'Mi trámite | TramitaNet')

@section('content')



<section class="bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 text-white py-14">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 overflow-x-hidden">
        <a href="{{ route('tramitanet.index') }}" class="text-blue-200 hover:text-white text-sm font-semibold">
            ← Volver al inicio
        </a>

        <h1 class="text-4xl md:text-5xl font-extrabold mt-8">
            Mi trámite
        </h1>

        <p class="text-slate-300 mt-3">
            Folio {{ $solicitud->folio }}
        </p>
    </div>
</section>


<section class="bg-slate-100 py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 grid lg:grid-cols-3 gap-6 lg:gap-8 overflow-hidden">
        <div class="lg:col-span-2 space-y-6 min-w-0">

            <div class="bg-white rounded-3xl shadow border border-slate-200 p-8">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                    <div>
                        <p class="text-sm font-bold text-slate-500 uppercase">Folio</p>

                        <p class="text-2xl sm:text-3xl font-black text-slate-900 mt-2 break-all">
                            {{ $solicitud->folio }}
                        </p>
                    </div>

                    <span class="inline-flex px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 text-sm font-bold">
                        {{ strtoupper(str_replace('_', ' ', $solicitud->estatus)) }}
                    </span>
                </div>



                <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-6 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="text-3xl">✅</div>

                        <div class="flex-1">

                            <h2 class="text-xl font-black text-green-800">
                                Solicitud registrada correctamente
                            </h2>

                            @if($solicitud->correo)
                                <p class="mt-2 text-sm text-green-700">
                                    Conserva estos datos en un lugar seguro. También fueron enviados a tu correo electrónico y te permitirán consultar el estado de tu solicitud en cualquier momento.
                                </p>
                            @else
                                <p class="mt-2 text-sm text-green-700">
                                    Conserva estos datos en un lugar seguro. Los necesitarás para consultar el estado de tu solicitud.
                                </p>
                            @endif

                            <div class="mt-5 grid gap-4 md:grid-cols-2">

                                <div class="rounded-xl border border-green-100 bg-white p-4">
                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-500">
                                        Folio de solicitud
                                    </p>

                                    <p class="mt-2 font-mono text-2xl font-black text-gray-900">
                                        {{ $solicitud->folio }}
                                    </p>
                                </div>

                                <div class="rounded-xl border border-green-100 bg-white p-4">
                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-500">
                                        Código de seguimiento
                                    </p>

                                    <p class="mt-2 font-mono text-2xl font-black text-gray-900">
                                        {{ $solicitud->codigo_consulta }}
                                    </p>
                                </div>

                            </div>

                            @if($solicitud->correo)
                                <p class="mt-4 text-sm text-green-700">
                                    📧 También enviamos esta información a
                                    <strong>{{ $solicitud->correo }}</strong>.
                                </p>
                            @endif

                            <div class="mt-5 rounded-xl border border-blue-200 bg-blue-50 p-4">
                                <p class="text-sm text-blue-800">
                                    <strong>ℹ Importante:</strong><br>
                                    El folio y el código de seguimiento son necesarios para consultar el avance de tu trámite desde la opción
                                    <strong>"Consultar solicitud"</strong>.
                                </p>
                            </div>

                        
                            <div class="mt-5 flex flex-col sm:flex-row gap-3">
                                <a
                                    href="{{ route('tramitanet.acuse', $solicitud->folio) }}"
                                    class="inline-flex w-full sm:w-auto items-center justify-center gap-2
                                        rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white
                                        shadow-sm transition hover:bg-blue-700
                                        focus:outline-none focus:ring-2 focus:ring-blue-500
                                        focus:ring-offset-2"
                                >
                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 10v6m0 0 3-3m-3 3-3-3m9 6H6a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2z"
                                        />
                                    </svg>

                                    Descargar acuse PDF
                                </a>
                                <a
                                    href="javascript:void(0)"
                                    onclick="abrirModalWhatsApp()"
                                    class="inline-flex w-full sm:w-auto items-center justify-center gap-2
                                        rounded-xl bg-green-600 px-5 py-3 text-sm font-bold text-white
                                        shadow-sm transition hover:bg-green-700
                                        focus:outline-none focus:ring-2 focus:ring-green-500
                                        focus:ring-offset-2"
                                >
                                    <svg class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H8l-5 5V5z"/>
                                    </svg>

                                    Enviar por WhatsApp
                                </a>

                            </div>
                        



                        </div>

                    </div>

                </div>





                <div class="bg-blue-50 border border-blue-200 rounded-3xl p-5 sm:p-8 overflow-hidden">
                    <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                        <div class="text-4xl flex-shrink-0">
                            {{ $estadoActual['icono'] }}
                        </div>

                        <div class="min-w-0 flex-1">
                            <h2 class="text-2xl font-extrabold text-blue-900 break-words">
                                {{ $estadoActual['titulo'] }}
                            </h2>

                            <p class="text-blue-800 mt-3 leading-relaxed break-words">
                                {{ $estadoActual['mensaje'] }}
                            </p>

                            @if(!empty($estadoActual['siguiente_paso']))
                                <div class="mt-5 w-full rounded-2xl border border-blue-200 bg-white/70 p-4">
                                    <p class="text-sm font-extrabold text-blue-900">
                                        Siguiente paso
                                    </p>

                                    <p class="text-sm text-blue-800 mt-1 leading-relaxed break-words">
                                        {{ $estadoActual['siguiente_paso'] }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-8 grid md:grid-cols-2 gap-5">
                    <div>
                        <p class="text-sm text-slate-500">Institución</p>
                        <p class="font-bold text-slate-900">
                            {{ $solicitud->servicio->institucion->nombre ?? 'Servicio' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Servicio</p>
                        <p class="font-bold text-slate-900">
                            {{ $solicitud->servicio->titulo_publico ?? $solicitud->servicio->nombre }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Modalidad</p>
                        <p class="font-bold text-slate-900">
                            {{ $solicitud->modalidad->nombre ?? 'No especificada' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Fecha de solicitud</p>
                        <p class="font-bold text-slate-900">
                            {{ $solicitud->created_at->format('d/m/Y H:i') }} hrs
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow border border-slate-200 p-8">
                <h2 class="text-2xl font-extrabold text-slate-900">
                    Información recibida
                </h2>

                @php
                    $titulosGrupo = [
                        'datos' => 'Datos capturados',
                        'documentos' => 'Documentos recibidos',
                        'credenciales' => 'Credenciales',
                        'autorizaciones' => 'Autorizaciones',
                    ];
                @endphp

                <div class="mt-6 space-y-8">
                    @foreach($datosAgrupados as $grupo => $datos)
                        <div>
                            <h3 class="text-sm font-black text-slate-500 uppercase mb-4">
                                {{ $titulosGrupo[$grupo] ?? ucfirst($grupo) }}
                            </h3>

                            <div class="space-y-3">
                                @foreach($datos as $dato)
                                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                        <p class="text-xs font-bold text-slate-500 uppercase">
                                            {{ $dato->etiqueta }}
                                        </p>

                                        <p class="text-base font-bold text-slate-900 mt-1 break-words">
                                            @if($dato->es_archivo)
                                                {{ $dato->nombre_original_archivo ?? 'Documento recibido' }}
                                            @elseif($dato->tipo_campo === 'password')
                                                ********
                                            @elseif($dato->tipo_campo === 'checkbox')
                                                Aceptado
                                            @else
                                                {{ $dato->valor ?: 'Sin capturar' }}
                                            @endif
                                        </p>

                                        @if($dato->es_archivo)
                                            <p class="text-sm text-green-700 font-bold mt-2">
                                                Documento recibido correctamente
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow border border-slate-200 p-8">
                <h2 class="text-2xl font-extrabold text-slate-900">
                    Documentos
                </h2>


                @if($solicitud->documentosGenerados->where('visible_cliente', true)->count())
                    <div class="bg-white rounded-3xl shadow border border-slate-200 p-8">
                        <h2 class="text-2xl font-extrabold text-slate-900">
                            Documentos disponibles
                        </h2>

                        <div class="mt-6 space-y-3">
                            @foreach($solicitud->documentosGenerados->where('visible_cliente', true) as $documento)
                                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                    <p class="font-bold text-slate-900">
                                        {{ $documento->titulo }}
                                    </p>

                                    <p class="text-sm text-slate-500 mt-1">
                                        {{ $documento->nombre_original_archivo }}
                                    </p>
                                    <a href="{{ route('tramitanet.documentos-generados.descargar', [$solicitud->folio, $documento]) }}"
                                    class="inline-flex mt-4 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold">
                                        Descargar documento
                                    </a>
                                </div>
                            @endforeach
                        </div>

                    </div>

                @endif

                <div class="mt-6 space-y-3">
                    @php
                        $documentos = $solicitud->datos->where('es_archivo', true);
                    @endphp

                    @forelse($documentos as $documento)
                        <div class="flex justify-between gap-4 border-b border-slate-100 pb-3">
                            <div>
                                <p class="font-bold text-slate-900">
                                    {{ $documento->etiqueta }}
                                </p>
                                <p class="text-sm text-slate-500">
                                    {{ $documento->nombre_original_archivo }}
                                </p>
                                @if($documento->tamano_archivo)
                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ number_format($documento->tamano_archivo / 1024, 1) }} KB
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        Recibido el {{ $documento->created_at->format('d/m/Y H:i') }} hrs
                                    </p>
                                @endif
                            </div>

                            <span class="text-sm font-bold text-green-700">
                                Recibido
                            </span>
                        </div>
                    @empty
                        <p class="text-slate-500 text-sm">
                            No se recibieron documentos para esta modalidad.
                        </p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow border border-slate-200 p-8">

                @php

                    $pasoActual = $ordenEstados[$solicitud->estatus] ?? 1;

                @endphp

                <h3 class="text-xl font-extrabold text-slate-900">
                    Avance de la solicitud
                </h3>

                <div class="mt-6 space-y-4">
                    @foreach(\App\Support\TramitaNet\EstadosSolicitud::timeline() as [$estatus, $texto])
                        @php
                            $paso = $ordenEstados[$estatus] ?? 0;
                            $completado = $paso <= $pasoActual;
                        @endphp

                        <div class="flex gap-3 items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold
                                {{ $completado ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-400' }}">
                                {{ $completado ? '✓' : '○' }}
                            </div>

                            <p class="font-semibold {{ $completado ? 'text-slate-900' : 'text-slate-400' }}">
                                {{ $texto }}
                            </p>                        
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <aside class="space-y-6 min-w-0">
            <div class="bg-white rounded-3xl shadow border border-slate-200 p-6">
                <p class="text-sm font-bold text-slate-500 uppercase">Total a pagar</p>

                <p class="text-4xl font-black text-slate-900 mt-3">
                    ${{ number_format($solicitud->total_pagar, 2) }}
                </p>

                <p class="text-sm text-slate-500">MXN</p>
            </div>

            <div class="bg-white rounded-3xl shadow border border-slate-200 p-6">
                <p class="text-sm font-bold text-slate-500 uppercase">
                    Tiempo estimado
                </p>

                <p class="text-slate-900 font-bold mt-3 leading-relaxed break-words">
                    {{ $solicitud->modalidad->tiempo_estimado
                        ?? $solicitud->servicio->tiempo_estimado
                        ?? 'Sujeto a validación' }}
                </p>

                <p class="text-sm text-slate-600 mt-2">
                    Los tiempos aplican dentro del horario de atención.
                </p>
            </div>

            <div class="bg-white rounded-3xl shadow border border-slate-200 p-6">
                <p class="text-sm font-bold text-slate-500 uppercase">Referencia</p>

                <p class="text-2xl sm:text-3xl font-black text-blue-700 mt-3 break-all">
                    {{ $solicitud->referencia_pago }}
                </p>

                <p class="text-sm text-slate-600 mt-2">
                    Usa esta referencia para identificar tu pago.
                </p>
            </div>

            @if($ultimoPago)
                <div class="bg-white rounded-3xl shadow border border-slate-200 p-6">
                    <p class="text-sm font-bold text-slate-500 uppercase">
                        Datos para realizar el pago
                    </p>

                    <div class="mt-5 space-y-4">

                        <div>
                            <p class="text-xs font-bold uppercase text-slate-500">
                                Banco
                            </p>

                            <p class="font-black text-slate-900 mt-1">
                                {{ $ultimoPago->banco ?: 'No especificado' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-bold uppercase text-slate-500">
                                Titular
                            </p>

                            <p class="font-black text-slate-900 mt-1 break-words">
                                {{ $ultimoPago->titular ?: 'No especificado' }}
                            </p>
                        </div>

                        @if($ultimoPago->numero_cuenta)
                            <div>
                                <p class="text-xs font-bold uppercase text-slate-500">
                                    Número de cuenta
                                </p>

                                <p class="font-mono text-lg font-black text-slate-900 mt-1 break-all">
                                    {{ $ultimoPago->numero_cuenta }}
                                </p>
                            </div>
                        @endif

                        @if($ultimoPago->clabe_interbancaria)
                            <div>
                                <p class="text-xs font-bold uppercase text-slate-500">
                                    CLABE interbancaria
                                </p>

                                <p class="font-mono text-lg font-black text-blue-700 mt-1 break-all">
                                    {{ $ultimoPago->clabe_interbancaria }}
                                </p>
                            </div>
                        @endif

                        <div class="rounded-2xl border border-blue-200 bg-blue-50 p-4">
                            <p class="text-xs font-bold uppercase text-blue-700">
                                Referencia obligatoria
                            </p>

                            <p class="font-mono text-2xl font-black text-blue-900 mt-2 break-all">
                                {{ $solicitud->referencia_pago }}
                            </p>

                            <p class="text-xs text-blue-700 mt-2">
                                Incluye esta referencia en el concepto de tu transferencia.
                            </p>
                        </div>

                    </div>
                </div>
            @endif


            <div class="bg-white rounded-3xl shadow border border-slate-200 p-6">
                <p class="text-sm font-bold text-slate-500 uppercase">
                    Comprobante de pago
                </p>


                

                @if(session('success'))
                    <div class="mt-4 rounded-xl bg-green-50 border border-green-200 p-3">
                        <p class="text-sm font-bold text-green-800">
                            {{ session('success') }}
                        </p>
                    </div>
                @endif



                @if($solicitud->estatus === 'esperando_pago')
                    @php
                        $puedeSubirComprobante =
                            $solicitud->estatus === EstadosSolicitud::ESPERANDO_PAGO
                            && $ultimoPago
                            && in_array($ultimoPago->estatus, [
                                'esperando_comprobante',
                                'pendiente',
                                'rechazado',
                            ]);
                    @endphp

                    @if($puedeSubirComprobante)

                        @if($ultimoPago?->estatus === 'rechazado')
                            <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-5">
                                <div class="flex items-start gap-3">
                                    <div class="text-2xl">
                                        ⚠️
                                    </div>

                                    <div>
                                        <p class="font-black text-red-800">
                                            El comprobante de pago fue rechazado
                                        </p>

                                        <p class="mt-1 text-sm text-red-700">
                                            Revisa el motivo indicado y envía un nuevo comprobante.
                                        </p>

                                        @if($ultimoPago->observacion)
                                            <div class="mt-3 rounded-xl border border-red-200 bg-white p-4">
                                                <p class="text-xs font-bold uppercase text-red-600">
                                                    Motivo del rechazo
                                                </p>

                                                <p class="mt-1 text-sm font-semibold text-red-900">
                                                    {{ $ultimoPago->observacion }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif



                        <form
                            method="POST"
                            action="{{ route('tramitanet.pago.subir', $solicitud->folio) }}"
                            enctype="multipart/form-data"
                            class="mt-4"
                        >
                            @csrf

                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Selecciona tu comprobante
                            </label>

                            <input
                                type="file"
                                name="comprobante"
                                accept=".pdf,.jpg,.jpeg,.png"
                                required
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm"
                            >

                            @error('comprobante')
                                <p class="text-sm text-red-600 font-semibold mt-2">
                                    {{ $message }}
                                </p>
                            @enderror

                            <p class="text-xs text-slate-500 mt-2">
                                Formatos permitidos: PDF, JPG, JPEG o PNG. Tamaño máximo: 10 MB.
                            </p>

                            <button
                                type="submit"
                                class="mt-4 w-full rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold py-3"
                            >
                                Subir comprobante
                            </button>
                        </form>

                    @elseif(
                        $solicitud->estatus === EstadosSolicitud::PAGO_EN_REVISION
                        || $ultimoPago?->estatus === 'en_revision'
                    )
                        <div class="mt-4 rounded-2xl border border-blue-200 bg-blue-50 p-4">
                            <p class="font-bold text-blue-900">
                                Comprobante recibido
                            </p>

                            <p class="text-sm text-blue-800 mt-2">
                                Nuestro personal revisará el pago en breve.
                            </p>

                            @if($ultimoPago?->fecha_subida)
                                <p class="text-xs text-blue-600 mt-2">
                                    Recibido el
                                    {{ $ultimoPago->fecha_subida->format('d/m/Y H:i') }}
                                    hrs.
                                </p>
                            @endif
                        </div>

                    @elseif(in_array($solicitud->estatus, [
                        EstadosSolicitud::PAGO_CONFIRMADO,
                        EstadosSolicitud::EN_GESTION,
                        EstadosSolicitud::ENTREGADO,
                    ]))
                        <div class="mt-4 rounded-2xl border border-green-200 bg-green-50 p-4">
                            <p class="font-bold text-green-900">
                                ✅ Pago validado
                            </p>

                            <p class="text-sm text-green-800 mt-2">
                                Tu pago fue validado correctamente.
                            </p>
                        </div>

                    @else
                        <p class="text-sm text-slate-600 mt-4">
                            El comprobante podrá enviarse cuando la solicitud se encuentre en espera de pago.
                        </p>
                    @endif
                @endif
            </div>

            
            @if($notasVisibles->isNotEmpty())
                <div class="bg-white rounded-3xl shadow border border-slate-200 p-8">
                    <h2 class="text-2xl font-extrabold text-slate-900">
                        Mensajes de seguimiento
                    </h2>

                    <div class="mt-6 space-y-4">
                        @foreach($notasVisibles as $nota)
                            <div class="rounded-2xl border border-blue-200 bg-blue-50 p-4">
                                <p class="text-sm text-blue-900 whitespace-pre-line">
                                    {{ $nota->nota }}
                                </p>

                                <p class="text-xs text-blue-600 mt-2">
                                    {{ $nota->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif


            <div class="bg-blue-50 rounded-3xl border border-blue-200 p-6">
                <p class="font-extrabold text-blue-900">
                    ¿Qué sigue?
                </p>

                <p class="text-sm text-blue-800 mt-2">
                    Realiza tu pago por transferencia o depósito. Después validaremos la información y continuaremos con tu trámite.
                </p>
            </div>
        </aside>

    </div>

    {{-- Modal WhatsApp --}}
    <div id="modal_whatsapp"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">

        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm mx-4">

            <h3 class="text-lg font-black text-gray-900 mb-2">
                Enviar comprobante por WhatsApp
            </h3>

            <p class="text-sm text-gray-600 mt-2">
                Se abrirá WhatsApp con un mensaje listo para enviarte el comprobante de tu trámite.
            </p>

            <p class="text-sm text-gray-500 mb-4">
                Revisa el número antes de abrir WhatsApp.
            </p>

            <div class="mt-5">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">
                    Número registrado
                </label>
                <input type="text"
                    id="whatsapp_numero"
                    value="{{ preg_replace('/\D/', '', $solicitud->telefono_whatsapp ?? '') }}"
                    class="w-full border-gray-300 rounded-xl shadow-sm text-sm"
                    maxlength="15"
                    placeholder="523111234567">
            </div>

            <p id="error_whatsapp"
            class="hidden text-red-600 text-xs mt-2">
                Ingresa un número válido con código de país.
            </p>

            <div class="flex justify-end gap-3 mt-5">
                <button type="button"
                        onclick="cerrarModalWhatsApp()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-bold">
                    Cancelar
                </button>

                <button type="button"
                        onclick="enviarWhatsApp()"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-bold">
                    📱 Abrir WhatsApp
                </button>
            </div>
        </div>
    </div>


</section>

@endsection

<script>
    function abrirModalWhatsApp() {
        document
            .getElementById('modal_whatsapp')
            .classList
            .remove('hidden');
    }

    function cerrarModalWhatsApp() {
        document
            .getElementById('modal_whatsapp')
            .classList
            .add('hidden');
    }

    function enviarWhatsApp() {
        const numero = document
            .getElementById('whatsapp_numero')
            .value
            .replace(/\D/g, '');

        if (numero.length < 7 || numero.length > 15) {
            return;
        }

        const texto = @json($mensajeWhatsApp);

        window.open(
            `https://wa.me/${numero}?text=${encodeURIComponent(texto)}`,
            '_blank'
        );

        cerrarModalWhatsApp();
    }

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            cerrarModalWhatsApp();
        }
    });
</script>