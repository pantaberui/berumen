<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Editar costo de acta
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4">
                    <ul class="list-disc pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="rounded-xl bg-white shadow-sm p-6">

                <form
                    action="{{ route('admin.costos-actas.update', $costoActaEntidad) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    <div class="grid gap-6">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Entidad
                            </label>

                            <input
                                type="text"
                                value="{{ $costoActaEntidad->entidad }}"
                                class="w-full rounded-lg border-gray-300 bg-gray-100"
                                readonly
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Código CURP
                            </label>

                            <input
                                type="text"
                                value="{{ $costoActaEntidad->codigo_curp }}"
                                class="w-full rounded-lg border-gray-300 bg-gray-100"
                                readonly
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Costo
                            </label>

                            <input
                                type="number"
                                name="costo"
                                step="0.01"
                                min="0"
                                value="{{ old('costo', $costoActaEntidad->costo) }}"
                                class="w-full rounded-lg border-gray-300"
                                required
                            >
                        </div>

                        <div class="flex items-center gap-3">
                            <input
                                id="activo"
                                type="checkbox"
                                name="activo"
                                value="1"
                                @checked(old('activo', $costoActaEntidad->activo))
                                class="rounded border-gray-300 text-indigo-600 shadow-sm"
                            >

                            <label
                                for="activo"
                                class="text-sm font-medium text-gray-700"
                            >
                                Activo
                            </label>
                        </div>

                    </div>

                    <div class="mt-8 flex justify-end gap-3">

                        <a
                            href="{{ route('admin.costos-actas.index') }}"
                            class="rounded-lg border px-5 py-2 text-gray-700 hover:bg-gray-100"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="rounded-lg bg-indigo-600 px-6 py-2 font-semibold text-white hover:bg-indigo-700"
                        >
                            Guardar cambios
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>