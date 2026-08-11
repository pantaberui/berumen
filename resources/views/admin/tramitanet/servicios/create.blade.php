<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Nuevo servicio
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Registra un nuevo servicio disponible en TramitaNet.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            <form
                method="POST"
                action="{{ route('admin.tramitanet.servicios.store') }}"
                class="space-y-6"
            >
                @csrf

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
                        Crear servicio
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
