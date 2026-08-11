<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Instituciones TramitaNet
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Administra las instituciones disponibles en el portal.
                </p>
            </div>

            <a
                href="{{ route('admin.tramitanet.instituciones.create') }}"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
            >
                Nueva institución
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-xl bg-white shadow">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Institución
                                </th>

                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Servicios
                                </th>

                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Orden
                                </th>

                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Portada
                                </th>

                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Estado
                                </th>

                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($instituciones as $institucion)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="inline-block h-5 w-5 rounded-full border border-gray-200"
                                                style="background-color: {{ $institucion->color_principal ?: '#e5e7eb' }}"
                                            ></span>

                                            <div>
                                                <div class="font-medium text-gray-900">
                                                    {{ $institucion->nombre }}
                                                </div>

                                                <div class="text-xs text-gray-500">
                                                    {{ $institucion->slug }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 text-center text-sm text-gray-700">
                                        {{ $institucion->servicios_count }}
                                    </td>

                                    <td class="px-4 py-3 text-center text-sm text-gray-700">
                                        {{ $institucion->orden }}
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        @if ($institucion->mostrar_en_portada)
                                            <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                                Sí
                                            </span>
                                        @else
                                            <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                                No
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        @if ($institucion->activo)
                                            <span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                                Activa
                                            </span>
                                        @else
                                            <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                                Inactiva
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-right">
                                        <a
                                            href="{{ route('admin.tramitanet.instituciones.edit', $institucion) }}"
                                            class="text-sm font-semibold text-blue-600 hover:text-blue-800"
                                        >
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="6"
                                        class="px-4 py-10 text-center text-sm text-gray-500"
                                    >
                                        No hay instituciones registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($instituciones->hasPages())
                    <div class="border-t border-gray-200 px-4 py-4">
                        {{ $instituciones->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
