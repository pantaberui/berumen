<div class="bg-white rounded-2xl shadow border border-gray-200 p-6">

    <a href="{{ route('admin.tramitanet.solicitudes.index') }}"
       class="text-blue-700 hover:text-blue-900 font-semibold">
        ← Volver a solicitudes
    </a>

    <div class="mt-5 grid lg:grid-cols-3 gap-6">

        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500 font-bold">
                Folio
            </p>

            <p class="text-3xl font-black text-gray-900 mt-1">
                {{ $solicitud->folio }}
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                Código de seguimiento
            </p>

            <p class="mt-2 font-mono text-2xl font-black text-slate-900">
                {{ $solicitud->codigo_consulta ?? 'No generado' }}
            </p>
        </div>

        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500 font-bold">
                Institución
            </p>

            <p class="text-lg font-semibold">
                {{ $solicitud->servicio->institucion->nombre }}
            </p>
        </div>

        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500 font-bold">
                Fecha de solicitud
            </p>

            <p class="text-lg font-semibold">
                {{ $solicitud->created_at->format('d/m/Y H:i') }}
            </p>
        </div>

        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500 font-bold">
                Servicio
            </p>

            <p class="font-semibold">
                {{ $solicitud->servicio->titulo_publico ?? $solicitud->servicio->nombre }}
            </p>
        </div>

        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500 font-bold">
                Modalidad
            </p>

            <p class="font-semibold">
                {{ $solicitud->modalidad->nombre }}
            </p>
        </div>

        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500 font-bold">
                Total
            </p>

            <p class="text-2xl font-black text-green-700">
                ${{ number_format($solicitud->total_pagar,2) }}
            </p>
        </div>

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

            </div>
        </div>
    </div>


</div>