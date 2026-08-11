<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Editar servicio
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                {{ $servicio->titulo_publico ?: $servicio->nombre }}
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <form
                method="POST"
                action="{{ route('admin.tramitanet.servicios.update', $servicio) }}"
                class="space-y-6"
            >
                @csrf
                @method('PUT')

                @include('admin.tramitanet.servicios._form')

                <div class="flex items-center justify-between">
                    <a
                        href="{{ route('admin.tramitanet.servicios.index') }}"
                        class="text-sm font-semibold text-gray-600 hover:text-gray-900"
                    >
                        ← Volver
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"
                    >
                        Guardar cambios
                    </button>
                </div>
            </form>

            <div class="mt-8 rounded-xl bg-white p-6 shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            Modalidades
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Administra las formas disponibles para solicitar este servicio.
                        </p>
                    </div>
                </div>

                @if (session('success'))
                    <div class="mt-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mt-6">
                    <h4 class="font-semibold text-gray-900">
                        Nueva modalidad
                    </h4>

                    <form
                        method="POST"
                        action="{{ route('admin.tramitanet.servicios.modalidades.store', $servicio) }}"
                        class="mt-4 grid gap-4 md:grid-cols-2"
                    >
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Nombre
                            </label>

                            <input
                                type="text"
                                name="nombre"
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
                                rows="3"
                                data-preserve-case="true"
                                class="mt-1 block w-full rounded-lg border-gray-300"
                            ></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Tipo de precio
                            </label>

                            <select
                                name="tipo_precio"
                                class="mt-1 block w-full rounded-lg border-gray-300"
                                required
                            >
                                <option value="fijo">Fijo</option>
                                <option value="por_entidad">Por entidad</option>
                                <option value="variable">Variable</option>
                                <option value="gratuito">Gratuito</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Precio propio
                            </label>

                            <input
                                type="number"
                                name="precio"
                                step="0.01"
                                min="0"
                                class="mt-1 block w-full rounded-lg border-gray-300"
                            >

                            <p class="mt-1 text-xs text-gray-500">
                                Déjalo vacío para heredar el precio del servicio.
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Tiempo estimado
                            </label>

                            <input
                                type="text"
                                name="tiempo_estimado"
                                data-preserve-case="true"
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
                                value="0"
                                class="mt-1 block w-full rounded-lg border-gray-300"
                            >
                        </div>

                        <div class="md:col-span-2">
                            <label class="inline-flex items-center gap-3">
                                <input type="hidden" name="activo" value="0">

                                <input
                                    type="checkbox"
                                    name="activo"
                                    value="1"
                                    checked
                                    class="rounded border-gray-300 text-blue-600"
                                >

                                <span class="text-sm font-medium text-gray-700">
                                    Modalidad activa
                                </span>
                            </label>
                        </div>

                        <div class="md:col-span-2 flex justify-end">
                            <button
                                type="submit"
                                class="rounded-lg bg-green-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-700"
                            >
                                Agregar modalidad
                            </button>
                        </div>
                    </form>
                </div>

                @if ($servicio->modalidades->isNotEmpty())
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h4 class="font-semibold text-gray-900">
                            Modalidades registradas
                        </h4>

                        <div class="mt-4 space-y-5">
                            @foreach ($servicio->modalidades as $modalidad)
                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.tramitanet.servicios.modalidades.update',
                                        [$servicio, $modalidad]
                                    ) }}"
                                    class="rounded-lg border border-gray-200 p-4"
                                >
                                    @csrf
                                    @method('PUT')

                                    <div class="grid gap-4 md:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Nombre
                                            </label>

                                            <input
                                                type="text"
                                                name="nombre"
                                                data-preserve-case="true"
                                                value="{{ $modalidad->nombre }}"
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
                                                value="{{ $modalidad->slug }}"
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
                                                rows="3"
                                                data-preserve-case="true"
                                                class="mt-1 block w-full rounded-lg border-gray-300"
                                            >{{ $modalidad->descripcion }}</textarea>
                                        </div>

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
                                                        @selected($modalidad->tipo_precio === $valor)
                                                    >
                                                        {{ $texto }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Precio propio
                                            </label>

                                            <input
                                                type="number"
                                                name="precio"
                                                step="0.01"
                                                min="0"
                                                value="{{ $modalidad->precio }}"
                                                class="mt-1 block w-full rounded-lg border-gray-300"
                                            >
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Tiempo estimado
                                            </label>

                                            <input
                                                type="text"
                                                name="tiempo_estimado"
                                                data-preserve-case="true"
                                                value="{{ $modalidad->tiempo_estimado }}"
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
                                                value="{{ $modalidad->orden }}"
                                                class="mt-1 block w-full rounded-lg border-gray-300"
                                            >
                                        </div>

                                        <div class="md:col-span-2 flex items-center justify-between">
                                            <label class="inline-flex items-center gap-3">
                                                <input type="hidden" name="activo" value="0">

                                                <input
                                                    type="checkbox"
                                                    name="activo"
                                                    value="1"
                                                    @checked($modalidad->activo)
                                                    class="rounded border-gray-300 text-blue-600"
                                                >

                                                <span class="text-sm font-medium text-gray-700">
                                                    Modalidad activa
                                                </span>
                                            </label>

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                                            >
                                                Guardar modalidad
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="mt-4 rounded-lg border border-gray-200 bg-gray-50 p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h5 class="font-semibold text-gray-900">
                                                Campos de la modalidad
                                            </h5>

                                            <p class="mt-1 text-sm text-gray-500">
                                                Define la información que deberá proporcionar el usuario
                                                para esta modalidad.
                                            </p>
                                        </div>
                                    </div>

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.tramitanet.servicios.modalidades.campos.store',
                                            [$servicio, $modalidad]
                                        ) }}"
                                        class="mt-4"
                                    >
                                        @csrf

                                        <div class="grid gap-4 md:grid-cols-4">
                                            <div class="md:col-span-2">
                                                <label class="block text-sm font-medium text-gray-700">
                                                    Campo
                                                </label>

                                                <select
                                                    name="catalogo_campo_id"
                                                    class="mt-1 block w-full rounded-lg border-gray-300"
                                                    required
                                                >
                                                    <option value="">
                                                        Selecciona un campo
                                                    </option>

                                                    @foreach ($camposDisponibles as $campoDisponible)
                                                        <option value="{{ $campoDisponible->id }}">
                                                            {{ $campoDisponible->nombre }}
                                                            ({{ $campoDisponible->tipo_campo }})
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
                                                    value="{{ $modalidad->camposAdmin->count() + 1 }}"
                                                    class="mt-1 block w-full rounded-lg border-gray-300"
                                                >
                                            </div>

                                            <div class="flex items-end">
                                                <div class="space-y-2">
                                                    <label class="flex items-center gap-2">
                                                        <input type="hidden" name="requerido" value="0">

                                                        <input
                                                            type="checkbox"
                                                            name="requerido"
                                                            value="1"
                                                            checked
                                                            class="rounded border-gray-300 text-blue-600"
                                                        >

                                                        <span class="text-sm text-gray-700">
                                                            Requerido
                                                        </span>
                                                    </label>

                                                    <label class="flex items-center gap-2">
                                                        <input type="hidden" name="activo" value="0">

                                                        <input
                                                            type="checkbox"
                                                            name="activo"
                                                            value="1"
                                                            checked
                                                            class="rounded border-gray-300 text-blue-600"
                                                        >

                                                        <span class="text-sm text-gray-700">
                                                            Activo
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="md:col-span-4 flex justify-end">
                                                <button
                                                    type="submit"
                                                    class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700"
                                                >
                                                    Agregar campo
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    @if ($modalidad->camposAdmin->isNotEmpty())
                                        <div class="mt-5 border-t border-gray-200 pt-4">
                                            <h6 class="text-sm font-semibold text-gray-800">
                                                Campos registrados
                                            </h6>

                                            <div class="mt-3 space-y-3">
                                                @foreach ($modalidad->camposAdmin as $campoModalidad)
                                                    <form
                                                        method="POST"
                                                        action="{{ route(
                                                            'admin.tramitanet.servicios.modalidades.campos.update',
                                                            [$servicio, $modalidad, $campoModalidad]
                                                        ) }}"
                                                        class="rounded-lg border border-gray-200 bg-white p-3"
                                                    >
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="grid items-end gap-3 md:grid-cols-5">
                                                            <div class="md:col-span-2">
                                                                <label class="block text-xs font-medium text-gray-600">
                                                                    Campo
                                                                </label>

                                                                <select
                                                                    name="catalogo_campo_id"
                                                                    class="mt-1 block w-full rounded-lg border-gray-300 text-sm"
                                                                    required
                                                                >
                                                                    @foreach ($camposDisponibles as $campoDisponible)
                                                                        <option
                                                                            value="{{ $campoDisponible->id }}"
                                                                            @selected(
                                                                                $campoModalidad->catalogo_campo_id
                                                                                === $campoDisponible->id
                                                                            )
                                                                        >
                                                                            {{ $campoDisponible->nombre }}
                                                                            ({{ $campoDisponible->tipo_campo }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div>
                                                                <label class="block text-xs font-medium text-gray-600">
                                                                    Orden
                                                                </label>

                                                                <input
                                                                    type="number"
                                                                    name="orden"
                                                                    min="0"
                                                                    value="{{ $campoModalidad->orden }}"
                                                                    class="mt-1 block w-full rounded-lg border-gray-300 text-sm"
                                                                >
                                                            </div>

                                                            <div class="space-y-2">
                                                                <label class="flex items-center gap-2">
                                                                    <input
                                                                        type="hidden"
                                                                        name="requerido"
                                                                        value="0"
                                                                    >

                                                                    <input
                                                                        type="checkbox"
                                                                        name="requerido"
                                                                        value="1"
                                                                        @checked($campoModalidad->requerido)
                                                                        class="rounded border-gray-300 text-blue-600"
                                                                    >

                                                                    <span class="text-sm text-gray-700">
                                                                        Requerido
                                                                    </span>
                                                                </label>

                                                                <label class="flex items-center gap-2">
                                                                    <input
                                                                        type="hidden"
                                                                        name="activo"
                                                                        value="0"
                                                                    >

                                                                    <input
                                                                        type="checkbox"
                                                                        name="activo"
                                                                        value="1"
                                                                        @checked($campoModalidad->activo)
                                                                        class="rounded border-gray-300 text-blue-600"
                                                                    >

                                                                    <span class="text-sm text-gray-700">
                                                                        Activo
                                                                    </span>
                                                                </label>
                                                            </div>

                                                            <div class="flex justify-end">
                                                                <button
                                                                    type="submit"
                                                                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                                                                >
                                                                    Guardar campo
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>









                            @endforeach
                        </div>
                    </div>
                @endif
            </div>



        </div>
    </div>
</x-app-layout>
