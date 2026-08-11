<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">
                Editar campo maestro
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                {{ $campo->nombre }}
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-xl bg-white p-6 shadow">
                <form
                    method="POST"
                    action="{{ route('admin.tramitanet.campos.update', $campo) }}"
                >
                    @csrf
                    @method('PUT')

                    @include('admin.tramitanet.campos._form', [
                        'campo' => $campo,
                    ])

                    <div class="mt-6 flex items-center justify-end gap-3">
                        <a
                            href="{{ route('admin.tramitanet.campos.index') }}"
                            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                        >
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
