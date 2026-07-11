<div class="bg-white rounded-2xl shadow border border-gray-200 p-6">
    <h2 class="text-xl font-black text-gray-900 mb-5">
        ⚙ Estado del trámite
    </h2>

    <p class="text-sm text-gray-500">
        Estado actual
    </p>

    <span class="inline-flex mt-2 px-4 py-2 rounded-full font-bold
        {{ \App\Support\TramitaNet\EstadosSolicitud::color($solicitud->estatus) }}">

        {{ \App\Support\TramitaNet\EstadosSolicitud::icono($solicitud->estatus) }}

        <span class="ml-2">
            {{ \App\Support\TramitaNet\EstadosSolicitud::labels()[$solicitud->estatus] ?? strtoupper(str_replace('_',' ', $solicitud->estatus)) }}
        </span>
    </span>

    <form method="POST"
          action="{{ route('admin.tramitanet.solicitudes.actualizar-estatus', $solicitud) }}"
          class="mt-6">

        @csrf
        @method('PATCH')

        <label class="block text-sm font-semibold mb-2">
            Cambiar a
        </label>

        <select name="estatus"
                class="w-full rounded-xl border-gray-300">
            @foreach($estatuses as $valor => $texto)
                <option value="{{ $valor }}" @selected($solicitud->estatus == $valor)>
                    {{ $texto }}
                </option>
            @endforeach
        </select>

        <label class="block text-sm font-semibold mt-5 mb-2">
            Observación
        </label>

        <textarea name="observacion"
                  rows="4"
                  class="w-full rounded-xl border-gray-300"
                  placeholder="Ejemplo: Se verificó la documentación..."></textarea>

        <button type="submit"
                class="mt-5 w-full rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold py-3">
            Guardar cambio
        </button>
    </form>
</div>

<div class="bg-blue-50 rounded-2xl border border-blue-200 p-6">
    <div class="bg-blue-50 rounded-2xl border border-blue-200 p-6">
        <h2 class="text-lg font-black text-blue-900">
            {{ $proximaAccion['icono'] }} {{ $proximaAccion['titulo'] }}
        </h2>

        <p class="text-sm text-blue-800 mt-3">
            {{ $proximaAccion['descripcion'] }}
        </p>
    </div>

</div>