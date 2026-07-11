<div class="bg-white rounded-2xl shadow border border-gray-200 p-6">
    <h2 class="text-xl font-black text-gray-900 mb-5">
        📤 Documentos generados
    </h2>

    <form method="POST"
          action="{{ route('admin.tramitanet.solicitudes.documentos-generados.store', $solicitud) }}"
          enctype="multipart/form-data"
          class="border rounded-xl bg-gray-50 p-5 mb-6">

        @csrf

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">
                    Título
                </label>

                <input type="text"
                       name="titulo"
                       value="Constancia generada"
                       class="w-full rounded-xl border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">
                    Tipo
                </label>

                <select name="tipo"
                        class="w-full rounded-xl border-gray-300">
                    <option value="resultado">Resultado</option>
                    <option value="acuse">Acuse</option>
                    <option value="comprobante">Comprobante</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
        </div>

        <div class="mt-4">
            <label class="block text-sm font-bold text-gray-700 mb-1">
                Archivo
            </label>

            <input type="file"
                   name="documento"
                   accept=".pdf,.jpg,.jpeg,.png"
                   class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2">
        </div>

        <label class="mt-4 flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox"
                   name="visible_cliente"
                   value="1"
                   checked>
            Visible para el ciudadano
        </label>

        @if(
            \App\Support\TramitaNet\EstadosSolicitud::puedeCambiarDe(
                $solicitud->estatus,
                \App\Support\TramitaNet\EstadosSolicitud::ENTREGADO
            )
        )
            <label class="mt-3 flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox"
                    name="marcar_entregado"
                    value="1">
                Marcar trámite como entregado
            </label>
        @else
            <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-3">
                <p class="text-sm text-amber-800">
                    Antes de entregar, completa los pasos pendientes del trámite.
                </p>
            </div>
        @endif

        <button type="submit"
                class="mt-5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3">
            Subir documento
        </button>
    </form>

    @forelse($solicitud->documentosGenerados as $documento)
        <div class="border rounded-xl bg-gray-50 p-5 mb-4">
            <p class="text-xs uppercase tracking-wide text-gray-500 font-bold">
                {{ ucfirst($documento->tipo) }}
            </p>

            <p class="font-black text-gray-900 mt-1">
                {{ $documento->titulo }}
            </p>

            <p class="text-sm text-gray-600 mt-1 break-all">
                {{ $documento->nombre_original_archivo }}
            </p>

            @if($documento->tamano_archivo)
                <p class="text-xs text-gray-500 mt-2">
                    {{ number_format($documento->tamano_archivo / 1024, 1) }} KB
                </p>
            @endif

            @if($documento->visible_cliente)
                <span class="inline-flex mt-3 px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                    Visible para el ciudadano
                </span>
            @endif
        </div>
    @empty
        <p class="text-gray-500 text-sm">
            Aún no se han agregado documentos generados.
        </p>
    @endforelse
</div>