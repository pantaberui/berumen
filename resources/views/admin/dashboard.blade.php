<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Dashboard — Reporte de Ventas</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Filtros --}}
            <div class="bg-white shadow-sm rounded-lg p-4">
                <form method="GET" action="{{ route('admin.dashboard') }}"
                      class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Fecha desde</label>
                        <input type="date" name="fecha_desde" value="{{ $fechaDesde }}"
                               class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Fecha hasta</label>
                        <input type="date" name="fecha_hasta" value="{{ $fechaHasta }}"
                               class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Usuario</label>
                        <select name="user_id" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">— Todos —</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}"
                                    {{ $userId == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }} {{ $usuario->apellido_paterno }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit"
                                class="flex-1 py-2 bg-gray-700 text-white rounded hover:bg-gray-800 text-sm">
                            Consultar
                        </button>
                        <a href="{{ route('admin.dashboard') }}"
                           class="py-2 px-3 bg-gray-200 text-gray-700 rounded text-sm">✕</a>
                    </div>
                </form>
            </div>

            {{-- SECCIÓN 1: Resumen --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-base font-semibold text-gray-800 mb-4">
                    📊 Resumen de Ventas
                    <span class="text-sm font-normal text-gray-500 ml-2">
                        {{ \Carbon\Carbon::parse($fechaDesde)->format('d/m/Y') }}
                        al {{ \Carbon\Carbon::parse($fechaHasta)->format('d/m/Y') }}
                    </span>
                </h3>

                <div class="space-y-4">
                    {{-- Grupo 1 --}}
                    <div class="border rounded-lg p-4 bg-blue-50">
                        <h4 class="font-medium text-blue-800 mb-2">1. {{ $resumen['grupo1']['label'] }}</h4>
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div class="text-center">
                                <p class="text-gray-500">Pago de Servicios</p>
                                <p class="font-bold text-lg text-blue-700">${{ number_format($resumen['grupo1']['servicios'], 2) }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-gray-500">Trámites</p>
                                <p class="font-bold text-lg text-blue-700">${{ number_format($resumen['grupo1']['tramites'], 2) }}</p>
                            </div>
                            <div class="text-center bg-blue-100 rounded p-2">
                                <p class="text-gray-600 text-xs">Subtotal Grupo 1</p>
                                <p class="font-bold text-xl text-blue-800">${{ number_format($resumen['grupo1']['total'], 2) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Grupo 2 --}}
                    <div class="border rounded-lg p-4 bg-green-50">
                        <h4 class="font-medium text-green-800 mb-2">2. {{ $resumen['grupo2']['label'] }}</h4>
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div class="text-center">
                                <p class="text-gray-500">Pagos Internet</p>
                                <p class="font-bold text-lg text-green-700">${{ number_format($resumen['grupo2']['internet'], 2) }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-gray-500">Fichas WiFi</p>
                                <p class="font-bold text-lg text-green-700">${{ number_format($resumen['grupo2']['fichas'], 2) }}</p>
                            </div>
                            <div class="text-center bg-green-100 rounded p-2">
                                <p class="text-gray-600 text-xs">Subtotal Grupo 2</p>
                                <p class="font-bold text-xl text-green-800">${{ number_format($resumen['grupo2']['total'], 2) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Grupo 3 --}}
                    <div class="border rounded-lg p-4 bg-purple-50">
                        <h4 class="font-medium text-purple-800 mb-2">3. {{ $resumen['grupo3']['label'] }}</h4>
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div class="text-center">
                                <p class="text-gray-500">Ventas</p>
                                <p class="font-bold text-lg text-purple-700">${{ number_format($resumen['grupo3']['ventas'], 2) }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-gray-500">Rentas de Equipos</p>
                                <p class="font-bold text-lg text-purple-700">${{ number_format($resumen['grupo3']['rentas'], 2) }}</p>
                            </div>
                            <div class="text-center bg-purple-100 rounded p-2">
                                <p class="text-gray-600 text-xs">Subtotal Grupo 3</p>
                                <p class="font-bold text-xl text-purple-800">${{ number_format($resumen['grupo3']['total'], 2) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Gran Total --}}
                    <div class="border-2 border-gray-800 rounded-lg p-4 bg-gray-800 text-white text-center">
                        <p class="text-sm opacity-75">GRAN TOTAL</p>
                        <p class="font-bold text-3xl">${{ number_format($granTotal, 2) }}</p>
                        <p class="text-xs opacity-60 mt-1">{{ \App\Helpers\NumeroALetras::convertir($granTotal) }}</p>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN 3: Gráfica comparativa --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-base font-semibold text-gray-800 mb-4">
                    📈 Comparativa de Ventas
                    <span class="text-sm font-normal text-gray-500 ml-2">
                        {{ $grafica['nombre_anterior'] }} vs {{ $grafica['nombre_actual'] }}
                    </span>
                </h3>
                <canvas id="graficaVentas" height="100"></canvas>
            </div>

            {{-- SECCIÓN 2: Detalle --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-base font-semibold text-gray-800">📋 Detalle de Ventas</h3>
                    <a href="{{ route('admin.dashboard.exportar', ['fecha_desde' => $fechaDesde, 'fecha_hasta' => $fechaHasta, 'user_id' => $userId]) }}"
                       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                        📥 Exportar Excel
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Concepto</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Referencia</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Importe</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($detalle as $fila)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-xs text-gray-500">{{ $fila['fecha'] }}</td>
                                <td class="px-4 py-2 text-xs">
                                    @php
                                        $colores = [
                                            'Pago de Servicio' => 'bg-blue-100 text-blue-800',
                                            'Trámite'          => 'bg-indigo-100 text-indigo-800',
                                            'Pago Internet'    => 'bg-green-100 text-green-800',
                                            'Ficha WiFi'       => 'bg-yellow-100 text-yellow-800',
                                            'Venta'            => 'bg-purple-100 text-purple-800',
                                            'Renta Equipo'     => 'bg-orange-100 text-orange-800',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs {{ $colores[$fila['categoria']] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $fila['categoria'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-xs text-gray-700">{{ $fila['concepto'] }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500">{{ $fila['cliente'] }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500">{{ $fila['referencia'] }}</td>
                                <td class="px-4 py-2 text-xs font-medium text-gray-900">${{ number_format($fila['importe'], 2) }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500">{{ $fila['usuario'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                    No hay registros en el rango seleccionado.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($detalle->count() > 0)
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-sm font-medium text-gray-700 text-right">Total:</td>
                                <td class="px-4 py-2 text-sm font-bold text-green-700">
                                    ${{ number_format($detalle->sum('importe'), 2) }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('graficaVentas').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($grafica['labels']) !!},
                datasets: [
                    {
                        label: '{{ $grafica["nombre_actual"] }}',
                        data: {!! json_encode($grafica['mes_actual']) !!},
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59,130,246,0.1)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: 4,
                    },
                    {
                        label: '{{ $grafica["nombre_anterior"] }}',
                        data: {!! json_encode($grafica['mes_anterior']) !!},
                        borderColor: '#9ca3af',
                        backgroundColor: 'rgba(156,163,175,0.1)',
                        tension: 0.3,
                        fill: true,
                        borderDash: [5, 5],
                        pointRadius: 3,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: ctx => '$' + parseFloat(ctx.raw || 0).toFixed(2)
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: val => '$' + val.toFixed(2)
                        }
                    },
                    x: {
                        title: { display: true, text: 'Día del mes' }
                    }
                }
            }
        });
    </script>
</x-app-layout>