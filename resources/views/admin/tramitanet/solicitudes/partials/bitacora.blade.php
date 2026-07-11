<div class="bg-white rounded-2xl shadow border border-gray-200 p-6">

    <h2 class="text-xl font-black text-gray-900 mb-5">
        📝 Bitácora
    </h2>

    <form method="POST"
          action="{{ route('admin.tramitanet.solicitudes.notas.store', $solicitud) }}">

        @csrf

        <textarea
            name="nota"
            rows="4"
            class="w-full rounded-xl border-gray-300"
            placeholder="Escribe una observación del expediente..."></textarea>

        <div class="mt-4 flex items-center justify-between">

            <label class="flex items-center gap-2 text-sm text-gray-600">

                <input
                    type="checkbox"
                    name="visible_cliente"
                    value="1">

                Visible para el ciudadano

            </label>

            <button
                type="submit"
                class="px-6 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold">

                Agregar nota

            </button>

        </div>

    </form>

    <div class="mt-8 space-y-4">

        @forelse($solicitud->notas as $nota)

            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                <div class="flex items-center justify-between">

                    <span class="font-bold text-gray-800">

                        📝 {{ ucfirst($nota->tipo) }}

                    </span>

                    <span class="text-xs text-gray-500">

                        {{ $nota->created_at->format('d/m/Y H:i') }}

                    </span>

                </div>

                <p class="mt-3 text-gray-700 whitespace-pre-line">
                    {{ $nota->nota }}
                </p>

                @if($nota->visible_cliente)
                    <span class="inline-flex mt-3 px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                        Visible para el ciudadano
                    </span>
                @endif

            </div>

        @empty

            <p class="text-gray-500">
                No existen notas registradas.
            </p>

        @endforelse

    </div>

</div>