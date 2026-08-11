@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <ul class="list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="rounded-xl bg-white p-6 shadow">
    <h3 class="text-lg font-semibold text-gray-900">
        Información general
    </h3>

    <div class="mt-5 grid gap-5 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Institución
            </label>

            <select
                name="catalogo_institucion_id"
                class="mt-1 block w-full rounded-lg border-gray-300"
                required
            >
                <option value="">Seleccione una institución</option>

                @foreach ($instituciones as $institucion)
                    <option
                        value="{{ $institucion->id }}"
                        @selected(
                            old(
                                'catalogo_institucion_id',
                                $servicio->catalogo_institucion_id ?? ''
                            ) == $institucion->id
                        )
                    >
                        {{ $institucion->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Orden
            </label>

            <input
                type="number"
                name="orden"
                min="0"
                value="{{ old('orden', $servicio->orden ?? 0) }}"
                class="mt-1 block w-full rounded-lg border-gray-300"
            >
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Nombre
            </label>

            <input
                type="text"
                name="nombre"
                data-preserve-case="true"
                value="{{ old('nombre', $servicio->nombre ?? '') }}"
                class="mt-1 block w-full rounded-lg border-gray-300"
                required
            >
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Slug
            </label>

            <input
                type="text"
                name="slug"
                data-preserve-case="true"
                value="{{ old('slug', $servicio->slug ?? '') }}"
                class="mt-1 block w-full rounded-lg border-gray-300"
                required
            >

            <p class="mt-1 text-xs text-gray-500">
                Ejemplo: constancia-situacion-fiscal
            </p>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
                Título público
            </label>

            <input
                type="text"
                name="titulo_publico"
                data-preserve-case="true"
                value="{{ old('titulo_publico', $servicio->titulo_publico ?? '') }}"
                class="mt-1 block w-full rounded-lg border-gray-300"
            >
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
                Resumen de requisitos
            </label>

            <textarea
                name="descripcion_corta"
                data-preserve-case="true"
                rows="2"
                class="mt-1 block w-full rounded-lg border-gray-300"
            >{{ old('descripcion_corta', $servicio->descripcion_corta ?? '') }}</textarea>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
                Descripción
            </label>

            <textarea
                name="descripcion"
                rows="4"
                data-preserve-case="true"
                class="mt-1 block w-full rounded-lg border-gray-300"
            >{{ old('descripcion', $servicio->descripcion ?? '') }}</textarea>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
                Requisitos
            </label>

            <textarea
                name="requisitos"
                rows="3"
                data-preserve-case="true"
                class="mt-1 block w-full rounded-lg border-gray-300"
            >{{ old('requisitos', $servicio->requisitos ?? '') }}</textarea>
        </div>
    </div>
</div>

<div class="rounded-xl bg-white p-6 shadow">
    <h3 class="text-lg font-semibold text-gray-900">
        Precio y atención
    </h3>

    <div class="mt-5 grid gap-5 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Tipo de precio
            </label>

            <select
                name="tipo_precio"
                class="mt-1 block w-full rounded-lg border-gray-300"
                required
            >
                @foreach ([
                    'fijo' => 'Fijo',
                    'por_entidad' => 'Por entidad',
                    'variable' => 'Variable',
                    'gratuito' => 'Gratuito',
                ] as $valor => $texto)
                    <option
                        value="{{ $valor }}"
                        @selected(
                            old(
                                'tipo_precio',
                                $servicio->tipo_precio ?? 'fijo'
                            ) === $valor
                        )
                    >
                        {{ $texto }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Precio base
            </label>

            <input
                type="number"
                name="precio"
                step="0.01"
                min="0"
                value="{{ old('precio', $servicio->precio ?? '') }}"
                class="mt-1 block w-full rounded-lg border-gray-300"
            >

            <p class="mt-1 text-xs text-gray-500">
                Si el precio es por entidad, variable o gratuito, puede permanecer vacío.
            </p>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">
                Tiempo estimado
            </label>

            <input
                type="text"
                name="tiempo_estimado"
                data-preserve-case="true"
                value="{{ old('tiempo_estimado', $servicio->tiempo_estimado ?? '') }}"
                class="mt-1 block w-full rounded-lg border-gray-300"
            >
        </div>
    </div>

    @if (isset($servicio) && $servicio->exists && $servicio->modalidades->isNotEmpty())
        <div class="mt-6 border-t border-gray-200 pt-5">
            <h4 class="font-semibold text-gray-900">
                Modalidades del servicio
            </h4>

            <p class="mt-1 text-sm text-gray-500">
                Estas modalidades pueden tener un precio propio distinto al precio base.
            </p>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left">Modalidad</th>
                            <th class="px-3 py-2 text-left">Tipo</th>
                            <th class="px-3 py-2 text-left">Precio propio</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach ($servicio->modalidades as $modalidad)
                            <tr>
                                <td class="px-3 py-2">
                                    {{ $modalidad->nombre }}
                                </td>

                                <td class="px-3 py-2">
                                    {{ $modalidad->tipo_precio }}
                                </td>

                                <td class="px-3 py-2">
                                    @if ($modalidad->precio !== null)
                                        ${{ number_format((float) $modalidad->precio, 2) }}
                                    @else
                                        Hereda precio del servicio
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<div class="rounded-xl bg-white p-6 shadow">
    <h3 class="text-lg font-semibold text-gray-900">
        SEO
    </h3>

    <div class="mt-5 space-y-5">
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Título SEO
            </label>

            <input
                type="text"
                name="seo_title"
                data-preserve-case="true"
                maxlength="70"
                value="{{ old('seo_title', $servicio->seo_title ?? '') }}"
                class="mt-1 block w-full rounded-lg border-gray-300"
            >

            <p class="mt-1 text-xs text-gray-500">
                Si se deja vacío, TramitaNet utilizará el título público o el nombre.
            </p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                Descripción SEO
            </label>

            <textarea
                name="seo_description"
                maxlength="170"
                data-preserve-case="true"
                rows="3"
                class="mt-1 block w-full rounded-lg border-gray-300"
            >{{ old('seo_description', $servicio->seo_description ?? '') }}</textarea>

            <p class="mt-1 text-xs text-gray-500">
                Si se deja vacía, se utilizará la descripción corta o descripción general.
            </p>
        </div>
    </div>
</div>

<div class="rounded-xl bg-white p-6 shadow">
    <h3 class="text-lg font-semibold text-gray-900">
        Visibilidad y características
    </h3>

    @php
        $opciones = [
            'cobra_comision' => ['Cobra comisión', false],
            'es_documento_oficial' => ['Documento oficial', true],
            'entrega_digital' => ['Entrega digital', true],
            'mostrar_en_portada' => ['Mostrar en portada', false],
            'mostrar_precio' => ['Mostrar precio', true],
            'activo' => ['Servicio activo', true],
        ];
    @endphp

    <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($opciones as $campo => [$etiqueta, $predeterminado])
            <label class="flex items-center gap-3 rounded-lg border border-gray-200 p-3">
                <input type="hidden" name="{{ $campo }}" value="0">

                <input
                    type="checkbox"
                    name="{{ $campo }}"
                    value="1"
                    @checked(
                        (bool) old(
                            $campo,
                            isset($servicio)
                                ? $servicio->{$campo}
                                : $predeterminado
                        )
                    )
                    class="rounded border-gray-300 text-blue-600"
                >

                <span class="text-sm font-medium text-gray-700">
                    {{ $etiqueta }}
                </span>
            </label>
        @endforeach
    </div>
</div>
