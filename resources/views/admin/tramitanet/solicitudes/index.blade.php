<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Solicitudes TramitaNet
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-bold text-gray-900">
                        Solicitudes recibidas
                    </h3>
                </div>

                @php
                    $coloresEstatus = [
                        'solicitado' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
                        'esperando_pago' => 'bg-orange-50 border-orange-200 text-orange-800',
                        'pago_confirmado' => 'bg-green-50 border-green-200 text-green-800',
                        'en_gestion' => 'bg-blue-50 border-blue-200 text-blue-800',
                        'entregado' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
                    ];
                @endphp

                <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                    @foreach($estatuses as $valor => $texto)
                        <a href="{{ route('admin.tramitanet.solicitudes.index', ['estatus' => $valor]) }}"
                        class="border rounded-2xl p-5 shadow hover:shadow-md transition {{ $coloresEstatus[$valor] ?? 'bg-white border-gray-200 text-gray-800' }}">

                            <p class="text-sm font-bold">
                                {{ $texto }}
                            </p>

                            <p class="text-3xl font-black mt-2">
                                {{ $conteos[$valor] ?? 0 }}
                            </p>
                        </a>
                    @endforeach
                </div>

                <form method="GET" class="mb-6">
                    <div class="flex gap-3">
                        <input
                            type="text"
                            name="buscar"
                            value="{{ request('buscar') }}"
                            placeholder="Buscar por folio, RFC o CURP..."
                            class="w-full rounded-xl border-gray-300 shadow-sm">
                        <button
                            class="px-6 rounded-xl bg-blue-600 text-white font-bold">
                            Buscar
                        </button>
                    </div>


                    <div class="mt-4 grid md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Estatus
                            </label>
                            <select
                                name="estatus"
                                class="w-full rounded-xl border-gray-300 shadow-sm">
                                <option value="">Todos</option>
                                @foreach($estatuses as $valor => $texto)
                                    <option
                                        value="{{ $valor }}"
                                        @selected(request('estatus') == $valor)>
                                        {{ $texto }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>



                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Folio</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">RFC / CURP</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Servicio</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Modalidad</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Estatus</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Fecha</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($solicitudes as $solicitud)
                                <tr>
                                    <td class="px-6 py-4 font-bold text-blue-700">
                                        {{ $solicitud->folio }}
                                    </td>

                                    @php
                                        $identificador = $solicitud->datos
                                            ->whereIn('campo', ['rfc', 'curp'])
                                            ->first();
                                    @endphp

                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">
                                            {{ $identificador->valor ?? 'N/A' }}
                                        </div>

                                        @if($identificador)
                                            <div class="text-xs text-gray-500">
                                                {{ $identificador->etiqueta }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">
                                            {{ $solicitud->servicio->titulo_publico ?? $solicitud->servicio->nombre }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $solicitud->servicio->institucion->nombre ?? '' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm">
                                        {{ $solicitud->modalidad->nombre ?? 'N/A' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ \App\Support\TramitaNet\EstadosSolicitud::color($solicitud->estatus) }}">
                                            {{ \App\Support\TramitaNet\EstadosSolicitud::icono($solicitud->estatus) }}
                                            {{ \App\Support\TramitaNet\EstadosSolicitud::labels()[$solicitud->estatus] ?? strtoupper(str_replace('_', ' ', $solicitud->estatus)) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 font-bold">
                                        ${{ number_format($solicitud->total_pagar, 2) }} MXN
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $solicitud->created_at->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.tramitanet.solicitudes.show', $solicitud) }}"
                                           class="text-blue-700 font-bold hover:underline">
                                            Ver expediente
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                        No hay solicitudes registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6">
                    {{ $solicitudes->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>