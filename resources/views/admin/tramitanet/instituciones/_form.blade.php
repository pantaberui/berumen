@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3">
        <ul class="list-disc space-y-1 pl-5 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="block text-sm font-medium text-gray-700">
            Nombre
        </label>

        <input
            type="text"
            name="nombre"
            value="{{ old('nombre', $institucion?->nombre) }}"
            data-preserve-case="true"
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
            value="{{ old('slug', $institucion?->slug) }}"
            data-preserve-case="true"
            class="mt-1 block w-full rounded-lg border-gray-300"
            required
        >
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
        >{{ old('descripcion', $institucion?->descripcion) }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Icono
        </label>

        <input
            type="text"
            name="icono"
            value="{{ old('icono', $institucion?->icono) }}"
            data-preserve-case="true"
            placeholder="Ej. receipt-tax"
            class="mt-1 block w-full rounded-lg border-gray-300"
        >
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Logo
        </label>

        @if(!empty($institucion?->logo))
            <div class="mb-3 mt-2">
                <img
                    src="{{ asset('images/instituciones/' . $institucion->logo) }}"
                    alt="Logo de {{ $institucion->nombre }}"
                    class="max-h-20 max-w-[180px] rounded-lg border border-gray-200 bg-white p-2 object-contain"
                >

                <p class="mt-1 text-xs text-gray-500">
                    Logo actual: {{ $institucion->logo }}
                </p>
            </div>
        @endif

        <input
            type="file"
            name="logo"
            accept=".png,.jpg,.jpeg,.webp"
            class="mt-1 block w-full rounded-lg border border-gray-300 text-sm"
        >

        <p class="mt-1 text-xs text-gray-500">
            PNG, JPG o WEBP. Recomendado: 512 × 512 px.
        </p>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Color principal
        </label>

        <div class="mt-1 flex gap-3">
            <input
                type="color"
                value="{{ old('color_principal', $institucion?->color_principal ?? '#1E40AF') }}"
                oninput="this.nextElementSibling.value = this.value"
                class="h-10 w-14 rounded border border-gray-300"
            >

            <input
                type="text"
                name="color_principal"
                value="{{ old('color_principal', $institucion?->color_principal ?? '#1E40AF') }}"
                data-preserve-case="true"
                class="block w-full rounded-lg border-gray-300"
            >
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Color secundario
        </label>

        <div class="mt-1 flex gap-3">
            <input
                type="color"
                value="{{ old('color_secundario', $institucion?->color_secundario ?? '#DBEAFE') }}"
                oninput="this.nextElementSibling.value = this.value"
                class="h-10 w-14 rounded border border-gray-300"
            >

            <input
                type="text"
                name="color_secundario"
                value="{{ old('color_secundario', $institucion?->color_secundario ?? '#DBEAFE') }}"
                data-preserve-case="true"
                class="block w-full rounded-lg border-gray-300"
            >
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Orden
        </label>

        <input
            type="number"
            name="orden"
            min="0"
            value="{{ old('orden', $institucion?->orden ?? 0) }}"
            class="mt-1 block w-full rounded-lg border-gray-300"
        >
    </div>

    <div class="flex items-end">
        <div class="space-y-3">
            <label class="flex items-center gap-3">
                <input type="hidden" name="mostrar_en_portada" value="0">

                <input
                    type="checkbox"
                    name="mostrar_en_portada"
                    value="1"
                    @checked(old('mostrar_en_portada', $institucion?->mostrar_en_portada ?? true))
                    class="rounded border-gray-300 text-blue-600"
                >

                <span class="text-sm font-medium text-gray-700">
                    Mostrar en portada
                </span>
            </label>

            <label class="flex items-center gap-3">
                <input type="hidden" name="activo" value="0">

                <input
                    type="checkbox"
                    name="activo"
                    value="1"
                    @checked(old('activo', $institucion?->activo ?? true))
                    class="rounded border-gray-300 text-blue-600"
                >

                <span class="text-sm font-medium text-gray-700">
                    Institución activa
                </span>
            </label>
        </div>
    </div>
</div>
