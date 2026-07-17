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

                <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
                    @foreach($estatuses as $valor => $texto)
                        <a
                            href="{{ route('admin.tramitanet.solicitudes.index', ['estatus' => $valor]) }}"
                            class="min-w-0 rounded-2xl border p-4 shadow transition hover:shadow-md
                                {{ $coloresEstatus[$valor] ?? 'bg-white border-gray-200 text-gray-800' }}"
                        >
                            <p class="text-xs font-bold leading-tight sm:text-sm">
                                {{ $texto }}
                            </p>

                            <p class="mt-2 text-2xl font-black sm:text-3xl">
                                {{ $conteos[$valor] ?? 0 }}
                            </p>
                        </a>
                    @endforeach
                </div>

                <form
                    method="GET"
                    action="{{ route('admin.tramitanet.solicitudes.index') }}"
                    class="mt-8 grid gap-3 px-4 pb-5 sm:px-0 lg:grid-cols-[minmax(0,1fr)_auto_200px] lg:items-end"
                >
                    <div class="min-w-0">
                        <label
                            for="buscar"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Buscar solicitud
                        </label>

                        <input
                            type="text"
                            id="buscar"
                            name="buscar"
                            value="{{ request('buscar') }}"
                            placeholder="Buscar por folio, RFC o CURP..."
                            class="h-11 w-full rounded-xl border-gray-300 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <button
                        type="submit"
                        class="h-11 rounded-xl bg-blue-700 px-6 font-bold text-white transition hover:bg-blue-800"
                    >
                        Buscar
                    </button>

                    <div>
                        <label
                            for="estatus"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Estatus
                        </label>

                        <select
                            id="estatus"
                            name="estatus"
                            class="h-11 w-full rounded-xl border-gray-300 px-3 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            onchange="this.form.submit()"
                        >
                            <option value="">Todos</option>

                            @foreach($estatuses as $valor => $texto)
                                <option
                                    value="{{ $valor }}"
                                    @selected(request('estatus') === $valor)
                                >
                                    {{ $texto }}
                                </option>
                            @endforeach
                        </select>
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
                                    <td class="px-4 py-3">
                                        <p class="font-bold text-gray-900">
                                            {{ $solicitud->folio }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            Código:
                                            <span class="font-mono font-bold text-gray-700">
                                                {{ $solicitud->codigo_consulta ?? '—' }}
                                            </span>
                                        </p>
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