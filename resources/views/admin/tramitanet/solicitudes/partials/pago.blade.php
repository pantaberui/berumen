<div class="bg-white rounded-2xl shadow border border-gray-200 p-6">
    <h2 class="text-xl font-black text-gray-900 mb-5">
        💰 Pago del trámite
    </h2>

    <div class="mb-5">
        <p class="text-sm text-gray-500">Monto esperado</p>
        <p class="text-2xl font-black text-green-700">
            ${{ number_format($solicitud->total_pagar, 2) }}
        </p>

        <p class="text-sm text-gray-500 mt-3">Referencia</p>
        <p class="text-xl font-black text-blue-700">
            {{ $solicitud->referencia_pago }}
        </p>
    </div>

    @if(!$ultimoPago)
        <p class="text-sm text-gray-500">
            Aún no se ha recibido comprobante de pago.
        </p>
    @else
        <div class="border rounded-xl bg-gray-50 p-5">
            <p class="text-xs uppercase text-gray-500 font-bold">
                Comprobante recibido
            </p>


            @php
                $extensionPago = strtolower(pathinfo($ultimoPago->nombre_original_archivo, PATHINFO_EXTENSION));
            @endphp

            @if(in_array($extensionPago, ['jpg', 'jpeg', 'png', 'webp']))
                <div class="mb-4">
                    <img src="{{ route('admin.tramitanet.pagos.ver', $ultimoPago) }}"
                        alt="Comprobante de pago"
                        class="w-40 h-40 object-cover rounded-xl border">
                </div>
            @else
                <div class="mb-4 text-5xl">
                    📄
                </div>
            @endif




            <p class="font-bold text-gray-900 mt-1 break-all">
                {{ $ultimoPago->nombre_original_archivo }}
            </p>

            @if($ultimoPago->tamano_archivo)
                <p class="text-xs text-gray-500 mt-1">
                    {{ number_format($ultimoPago->tamano_archivo / 1024, 1) }} KB
                </p>
            @endif

            <p class="text-xs text-gray-500 mt-1">
                Recibido el {{ $ultimoPago->created_at->format('d/m/Y H:i') }}
            </p>

            <div class="mt-4">
                <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold
                    @if($ultimoPago->estatus === 'pendiente') bg-orange-100 text-orange-800
                    @elseif($ultimoPago->estatus === 'validado') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ strtoupper($ultimoPago->estatus) }}
                </span>
            </div>

            <div class="mt-4 flex gap-3">

                <a href="{{ route('admin.tramitanet.pagos.ver', $ultimoPago) }}"
                target="_blank"
                class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 text-sm font-semibold">
                    👁 Ver
                </a>

                <a href="{{ route('admin.tramitanet.pagos.descargar', $ultimoPago) }}"
                class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold">
                    ⬇ Descargar
                </a>

            </div>



        </div>

        @if($ultimoPago->estatus === 'pendiente')
            <div class="mt-5 grid md:grid-cols-2 gap-3">
                <form method="POST"
                      action="{{ route('admin.tramitanet.pagos.validar', $ultimoPago) }}">
                    @csrf
                    @method('PATCH')

                    <button type="submit"
                            class="w-full rounded-xl bg-green-600 hover:bg-green-700 text-white font-bold py-3">
                        ✔ Validar pago
                    </button>
                </form>

                <form method="POST"
                      action="{{ route('admin.tramitanet.pagos.rechazar', $ultimoPago) }}">
                    @csrf
                    @method('PATCH')

                    <textarea name="observacion"
                              rows="2"
                              required
                              class="w-full rounded-xl border-gray-300"
                              placeholder="Motivo de rechazo"></textarea>

                    <button type="submit"
                            class="mt-2 w-full rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold py-3">
                        ✖ Rechazar
                    </button>
                </form>
            </div>
        @elseif($ultimoPago->estatus === 'validado')
            <p class="mt-4 text-sm font-bold text-green-700">
                Pago validado correctamente.
            </p>
        @elseif($ultimoPago->estatus === 'rechazado')
            <div class="mt-4 rounded-xl bg-red-50 border border-red-200 p-4">
                <p class="text-sm font-bold text-red-800">
                    Comprobante rechazado
                </p>

                <p class="text-sm text-red-700 mt-1">
                    {{ $ultimoPago->observacion }}
                </p>
            </div>
        @endif




    @endif
</div>