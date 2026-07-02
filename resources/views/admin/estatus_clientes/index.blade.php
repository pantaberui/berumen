<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Estatus de Pagos — Clientes Internet</h2>
            <p class="text-sm text-gray-500">Hoy: {{ $hoy->format('d/m/Y') }}</p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Resumen --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                @php
                    $conteos = collect($clientes)->groupBy('estatus');
                @endphp
                <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-center">
                    <p class="text-xl font-bold text-green-700">{{ $conteos->get('pagado', collect())->count() }}</p>
                    <p class="text-xs text-green-600">✅ Pagados</p>
                </div>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-center">
                    <p class="text-xl font-bold text-yellow-700">{{ $conteos->get('pendiente', collect())->count() }}</p>
                    <p class="text-xs text-yellow-600">⏳ Pendientes</p>
                </div>
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 text-center">
                    <p class="text-xl font-bold text-orange-700">{{ $conteos->get('vencido', collect())->count() }}</p>
                    <p class="text-xs text-orange-600">⚠️ Vencidos</p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-center">
                    <p class="text-xl font-bold text-red-700">{{ $conteos->get('critico', collect())->count() }}</p>
                    <p class="text-xs text-red-600">🔴 Críticos</p>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-center">
                    <p class="text-xl font-bold text-gray-700">{{ $conteos->get('sin_pagos', collect())->count() }}</p>
                    <p class="text-xs text-gray-600">Sin pagos</p>
                </div>
            </div>

            {{-- Filtros --}}
            <div class="bg-white shadow-sm rounded-lg p-4">
                <form method="GET" class="flex gap-3 flex-wrap">
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Buscar cliente o contrato..."
                           class="border-gray-300 rounded-md shadow-sm text-sm flex-1 min-w-48">
                    <select name="estatus" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">— Todos los estatus —</option>
                        <option value="pagado"   {{ request('estatus') == 'pagado'   ? 'selected' : '' }}>✅ Pagados</option>
                        <option value="pendiente"{{ request('estatus') == 'pendiente'? 'selected' : '' }}>⏳ Pendientes</option>
                        <option value="vencido"  {{ request('estatus') == 'vencido'  ? 'selected' : '' }}>⚠️ Vencidos</option>
                        <option value="critico"  {{ request('estatus') == 'critico'  ? 'selected' : '' }}>🔴 Críticos</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded text-sm">Filtrar</button>
                    <a href="{{ route('admin.estatus-clientes.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm">✕</a>
                </form>
            </div>

            {{-- Tabla --}}
            <div class="bg-white shadow-sm rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contrato</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Último Pago</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Período Último Pago</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periodo Próximo Pago</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($clientes as $item)
                        @php
                            $badges = [
                                'pagado'   => 'bg-green-100 text-green-800',
                                'pendiente'=> 'bg-yellow-100 text-yellow-800',
                                'vencido'  => 'bg-orange-100 text-orange-800',
                                'critico'  => 'bg-red-100 text-red-800',
                                'sin_pagos'=> 'bg-gray-100 text-gray-800',
                            ];
                            $labels = [
                                'pagado'   => '✅ Pagado',
                                'pendiente'=> '⏳ Pendiente',
                                'vencido'  => '⚠️ Vencido',
                                'critico'  => '🔴 Crítico',
                                'sin_pagos'=> 'Sin pagos',
                            ];
                            $rowBg = [
                                'pagado'   => '',
                                'pendiente'=> 'bg-yellow-50',
                                'vencido'  => 'bg-orange-50',
                                'critico'  => 'bg-red-50',
                                'sin_pagos'=> 'bg-gray-50',
                            ];
                            $celular = preg_replace('/\D/', '', $item['cliente']->celular ?? $item['cliente']->telefono ?? '');
                        @endphp
                        <tr class="hover:bg-gray-50 {{ $rowBg[$item['estatus']] ?? '' }}">
                            <td class="px-4 py-3 text-sm font-mono text-gray-700">
                                {{ $item['contrato']->numero_contrato }}
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                {{ $item['cliente']->nombre }}
                                {{ $item['cliente']->apellido_paterno }}
                                {{ $item['cliente']->apellido_materno }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badges[$item['estatus']] ?? '' }}">
                                    {{ $labels[$item['estatus']] ?? $item['estatus'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                @if($item['ultimo_pago'])
                                    {{ \Carbon\Carbon::parse($item['ultimo_pago']->fecha_pago)->format('d/m/Y') }}
                                    <span class="text-xs text-gray-400 block">
                                        ${{ number_format($item['ultimo_pago']->total, 2) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">Sin pagos</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                @if($item['ultimo_pago'])
                                    {{ \Carbon\Carbon::parse($item['ultimo_pago']->periodo_desde)->format('d/m/Y') }}
                                    al
                                    {{ \Carbon\Carbon::parse($item['ultimo_pago']->periodo_hasta)->format('d/m/Y') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if($item['periodo_desde'] && $item['periodo_hasta'] && $item['estatus'] !== 'pagado')
                                    <span class="text-gray-600">
                                        {{ \Carbon\Carbon::parse($item['periodo_desde'])->format('d/m/Y') }}
                                        al
                                        {{ \Carbon\Carbon::parse($item['periodo_hasta'])->format('d/m/Y') }}
                                    </span>
                                @elseif($item['estatus'] === 'pagado' && $item['ultimo_pago'])
                                    <span class="text-green-600">
                                        {{ \Carbon\Carbon::parse($item['ultimo_pago']->periodo_desde)->format('d/m/Y') }}
                                        al
                                        {{ \Carbon\Carbon::parse($item['ultimo_pago']->periodo_hasta)->format('d/m/Y') }}
                                    </span>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.pagos.create', [
                                            'contrato_id' => $item['contrato']->id,                                            
                                        ]) }}"
                                        title="Registrar pago"
                                        class="text-blue-600 hover:underline text-xs">
                                        + Pago
                                    </a>

                                    @if($item['estatus'] !== 'pagado' && $celular)
                                    <button onclick="enviarRecordatorio('{{ $celular }}', '{{ $item['cliente']->nombre }} {{ $item['cliente']->apellido_paterno }}', '{{ $item['ultimo_pago'] ? \Carbon\Carbon::parse($item['ultimo_pago']->fecha_pago)->format('d/m/Y') : 'N/A' }}', '{{ $item['ultimo_pago'] ? \Carbon\Carbon::parse($item['ultimo_pago']->periodo_desde)->format('d/m/Y') : 'N/A' }}', '{{ $item['ultimo_pago'] ? \Carbon\Carbon::parse($item['ultimo_pago']->periodo_hasta)->format('d/m/Y') : 'N/A' }}')"
                                            title="Enviar mensaje de recordatorio de pago"
                                            class="text-green-600 hover:underline text-xs">
                                        📱 WhatsApp
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                No hay clientes con los filtros seleccionados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    function enviarRecordatorio(celular, nombre, fechaUltimoPago, periodoDesde, periodoHasta) {
        const texto =
            `Estimado(a) *${nombre}*,\n\n` +
            `Le recordamos que el pago de su mensualidad de *Internet* está pendiente.\n\n` +
            `Su último pago registrado fue el día *${fechaUltimoPago}* ` +
            `que comprende el periodo del *${periodoDesde}* al *${periodoHasta}*.\n\n` +
            `Agradecemos su pago a la brevedad posible.\n\n` +
            `Este es un mensaje generado en automático,\n\n` +
            `no es necesario responderlo.\n\n` +
            `*Entretenimiento Berumen*\n` +
            `Tel. (311) 352-2645`;

        window.open(`https://wa.me/52${celular}?text=${encodeURIComponent(texto)}`, '_blank');
    }
    </script>
</x-app-layout>