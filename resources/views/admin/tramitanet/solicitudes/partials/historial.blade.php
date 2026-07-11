<div class="bg-white rounded-2xl shadow border border-gray-200 p-6">
    <h2 class="text-xl font-black text-gray-900 mb-5">
        🕒 Historial del trámite
    </h2>

    <div class="space-y-5">
        @forelse($solicitud->historial->sortByDesc('created_at') as $movimiento)
            <div class="flex gap-4">
                <div class="mt-1 w-3 h-3 rounded-full bg-blue-600 flex-shrink-0"></div>

                <div>
                    <p class="text-sm font-bold text-gray-900">
                        {{ ucfirst(str_replace('_',' ', $movimiento->estatus_nuevo)) }}
                    </p>

                    @if($movimiento->estatus_anterior)
                        <p class="text-sm text-gray-600 mt-1">
                            De <strong>{{ ucfirst(str_replace('_',' ', $movimiento->estatus_anterior)) }}</strong>
                            a <strong>{{ ucfirst(str_replace('_',' ', $movimiento->estatus_nuevo)) }}</strong>
                        </p>
                    @endif

                    @if($movimiento->observacion)
                        <p class="mt-2 text-sm text-gray-700">
                            {{ $movimiento->observacion }}
                        </p>
                    @endif

                    <p class="text-xs text-gray-500 mt-2">
                        {{ $movimiento->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        @empty
            <p class="text-gray-500">
                No existen movimientos registrados.
            </p>
        @endforelse
    </div>
</div>