@php
    $opcionesTexto = old('opciones_texto');

    if ($opcionesTexto === null && $campo?->opciones) {
        $opcionesTexto = collect($campo->opciones)
            ->map(function ($opcion) {
                if (is_array($opcion)) {
                    $valor = $opcion['value']
                        ?? $opcion['valor']
                        ?? '';

                    $etiqueta = $opcion['label']
                        ?? $opcion['etiqueta']
                        ?? $valor;

                    return $valor === $etiqueta
                        ? $valor
                        : $valor . '|' . $etiqueta;
                }

                return $opcion;
            })
            ->implode(PHP_EOL);
    }
@endphp

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
            value="{{ old('nombre', $campo?->nombre) }}"
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
            value="{{ old('slug', $campo?->slug) }}"
            data-preserve-case="true"
            class="mt-1 block w-full rounded-lg border-gray-300"
            required
        >
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Tipo de campo
        </label>

        <select
            name="tipo_campo"
            class="mt-1 block w-full rounded-lg border-gray-300"
            required
        >
            @foreach ([
                'text' => 'Texto',
                'curp' => 'CURP',
                'rfc' => 'RFC',
                'nss' => 'NSS',
                'email' => 'Correo electrónico',
                'tel' => 'Teléfono',
                'date' => 'Fecha',
                'password' => 'Contraseña',
                'checkbox' => 'Casilla de verificación',
                'select' => 'Lista de opciones',
                'file' => 'Archivo',
            ] as $valor => $texto)
                <option
                    value="{{ $valor }}"
                    @selected(old('tipo_campo', $campo?->tipo_campo) === $valor)
                >
                    {{ $texto }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Grupo de expediente
        </label>

        <select
            name="grupo_expediente"
            class="mt-1 block w-full rounded-lg border-gray-300"
            required
        >
            @foreach ([
                'datos' => 'Datos',
                'documentos' => 'Documentos',
                'credenciales' => 'Credenciales',
            ] as $valor => $texto)
                <option
                    value="{{ $valor }}"
                    @selected(old('grupo_expediente', $campo?->grupo_expediente ?? 'datos') === $valor)
                >
                    {{ $texto }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Validación
        </label>

        <select
            name="validacion"
            class="mt-1 block w-full rounded-lg border-gray-300"
        >
            <option value="">Sin validación especial</option>

            @foreach ([
                'required' => 'Requerido',
                'accepted' => 'Debe aceptarse',
                'curp' => 'CURP',
                'email' => 'Correo electrónico',
                'nss' => 'NSS',
                'rfc' => 'RFC',
                'telefono' => 'Teléfono',
            ] as $valor => $texto)
                <option
                    value="{{ $valor }}"
                    @selected(old('validacion', $campo?->validacion) === $valor)
                >
                    {{ $texto }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Transformación
        </label>

        <select
            name="transformacion"
            class="mt-1 block w-full rounded-lg border-gray-300"
        >
            <option value="">Ninguna</option>

            <option
                value="mayusculas"
                @selected(old('transformacion', $campo?->transformacion) === 'mayusculas')
            >
                Mayúsculas
            </option>

            <option
                value="minusculas"
                @selected(old('transformacion', $campo?->transformacion) === 'minusculas')
            >
                Minúsculas
            </option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Placeholder
        </label>

        <input
            type="text"
            name="placeholder"
            value="{{ old('placeholder', $campo?->placeholder) }}"
            data-preserve-case="true"
            class="mt-1 block w-full rounded-lg border-gray-300"
        >
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Autocomplete
        </label>

        <input
            type="text"
            name="autocomplete"
            value="{{ old('autocomplete', $campo?->autocomplete) }}"
            data-preserve-case="true"
            placeholder="Ej. off, email, tel, postal-code"
            class="mt-1 block w-full rounded-lg border-gray-300"
        >
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Longitud mínima
        </label>

        <input
            type="number"
            name="longitud_minima"
            min="0"
            value="{{ old('longitud_minima', $campo?->longitud_minima) }}"
            class="mt-1 block w-full rounded-lg border-gray-300"
        >
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Longitud máxima
        </label>

        <input
            type="number"
            name="longitud_maxima"
            min="0"
            value="{{ old('longitud_maxima', $campo?->longitud_maxima) }}"
            class="mt-1 block w-full rounded-lg border-gray-300"
        >
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Orden
        </label>

        <input
            type="number"
            name="orden"
            min="0"
            value="{{ old('orden', $campo?->orden ?? 0) }}"
            class="mt-1 block w-full rounded-lg border-gray-300"
        >
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Icono
        </label>

        <input
            type="text"
            name="icono"
            value="{{ old('icono', $campo?->icono) }}"
            data-preserve-case="true"
            class="mt-1 block w-full rounded-lg border-gray-300"
        >
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">
            Ayuda al usuario
        </label>

        <textarea
            name="ayuda"
            rows="3"
            data-preserve-case="true"
            class="mt-1 block w-full rounded-lg border-gray-300"
        >{{ old('ayuda', $campo?->ayuda) }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">
            Ayuda para operador
        </label>

        <textarea
            name="ayuda_operador"
            rows="3"
            data-preserve-case="true"
            class="mt-1 block w-full rounded-lg border-gray-300"
        >{{ old('ayuda_operador', $campo?->ayuda_operador) }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Título de ayuda
        </label>

        <input
            type="text"
            name="titulo_ayuda"
            value="{{ old('titulo_ayuda', $campo?->titulo_ayuda) }}"
            data-preserve-case="true"
            class="mt-1 block w-full rounded-lg border-gray-300"
        >
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">
            Imagen de ayuda
        </label>

        <input
            type="text"
            name="imagen_ayuda"
            value="{{ old('imagen_ayuda', $campo?->imagen_ayuda) }}"
            data-preserve-case="true"
            class="mt-1 block w-full rounded-lg border-gray-300"
        >
    </div>

    <div class="md:col-span-2 rounded-lg border border-gray-200 bg-gray-50 p-4">
        <h3 class="font-semibold text-gray-900">
            Configuración para listas de opciones
        </h3>

        <p class="mt-1 text-sm text-gray-500">
            Solo se utiliza cuando el tipo de campo es “Lista de opciones”.
            Escribe una opción por línea. Puedes usar valor|etiqueta.
        </p>

        <textarea
            name="opciones_texto"
            rows="6"
            data-preserve-case="true"
            placeholder="M|Masculino&#10;F|Femenino"
            class="mt-3 block w-full rounded-lg border-gray-300 font-mono text-sm"
        >{{ $opcionesTexto }}</textarea>
    </div>

    <div class="md:col-span-2 rounded-lg border border-gray-200 bg-gray-50 p-4">
        <h3 class="font-semibold text-gray-900">
            Configuración para archivos
        </h3>

        <div class="mt-4 grid gap-4 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Extensiones permitidas
                </label>

                <input
                    type="text"
                    name="accept"
                    value="{{ old('accept', $campo?->accept) }}"
                    data-preserve-case="true"
                    placeholder=".pdf,.jpg,.jpeg,.png"
                    class="mt-1 block w-full rounded-lg border-gray-300"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Tamaño máximo MB
                </label>

                <input
                    type="number"
                    name="tamano_maximo_mb"
                    min="0"
                    step="0.01"
                    value="{{ old('tamano_maximo_mb', $campo?->tamano_maximo_mb) }}"
                    class="mt-1 block w-full rounded-lg border-gray-300"
                >
            </div>

            <div class="md:col-span-2">
                <label class="inline-flex items-center gap-3">
                    <input
                        type="hidden"
                        name="multiple"
                        value="0"
                    >

                    <input
                        type="checkbox"
                        name="multiple"
                        value="1"
                        @checked(old('multiple', $campo?->multiple ?? false))
                        class="rounded border-gray-300 text-blue-600"
                    >

                    <span class="text-sm font-medium text-gray-700">
                        Permitir múltiples archivos
                    </span>
                </label>
            </div>
        </div>
    </div>

    <div class="md:col-span-2">
        <label class="inline-flex items-center gap-3">
            <input
                type="hidden"
                name="activo"
                value="0"
            >

            <input
                type="checkbox"
                name="activo"
                value="1"
                @checked(old('activo', $campo?->activo ?? true))
                class="rounded border-gray-300 text-blue-600"
            >

            <span class="text-sm font-medium text-gray-700">
                Campo activo
            </span>
        </label>
    </div>
</div>
