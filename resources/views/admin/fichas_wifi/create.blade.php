<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Venta de Fichas WiFi — NetPlus</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('error'))
                <div class="bg-red-100 text-red-800 px-4 py-3 rounded">{{ session('error') }}</div>
            @endif

            {{-- Cards de tipos de ficha --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                @php
                    $colores = [
                        'media_hora' => ['style' => 'background-color:#3b82f6;', 'hover' => ''],
                        '1_hora'     => ['style' => 'background-color:#22c55e;', 'hover' => ''],
                        '3_horas'    => ['style' => 'background-color:#eab308;', 'hover' => ''],
                        '1_dia'      => ['style' => 'background-color:#f97316;', 'hover' => ''],
                        '1_semana'   => ['style' => 'background-color:#a855f7;', 'hover' => ''],
                        '1_mes'      => ['style' => 'background-color:#ef4444;', 'hover' => ''],
                    ];
                @endphp

                @foreach($tipos as $key => $tipo)
                <form action="{{ route('admin.fichas-wifi.vender') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tipo_ficha" value="{{ $key }}">
                    <button type="submit"
                        style="{{ $colores[$key]['style'] }}"
                        class="w-full rounded-xl p-5 text-white shadow-md transition-transform hover:scale-105 hover:opacity-90 {{ $disponibles[$key] == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $disponibles[$key] == 0 ? 'disabled' : '' }}>
                        <div class="text-3xl font-bold mb-1">${{ number_format($tipo['importe'], 2) }}</div>
                        <div class="text-lg font-semibold">{{ $tipo['label'] }}</div>
                        <div class="text-sm mt-2 opacity-80">
                            {{ $disponibles[$key] }} fichas disponibles
                        </div>
                    </button>
                </form>
                @endforeach

            </div>

            {{-- Buscador para reimpresión --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-base font-medium text-gray-800 mb-4">Consultar / Reimprimir Ficha</h3>
                <form action="{{ route('admin.fichas-wifi.buscar') }}" method="GET"
                      class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <input type="number" name="folio" placeholder="Buscar por folio..."
                           class="border-gray-300 rounded-md shadow-sm text-sm">
                    <input type="text" name="codigo" placeholder="Buscar por código..."
                           class="border-gray-300 rounded-md shadow-sm text-sm">
                    <button type="submit"
                            class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800 text-sm">
                        Buscar
                    </button>
                    <button type="submit" name="ultimo" value="1"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                        Último folio vendido
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>