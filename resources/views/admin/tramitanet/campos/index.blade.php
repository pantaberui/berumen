<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Campos maestros de TramitaNet
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Administra los campos reutilizables que pueden asignarse
                    a las modalidades de los servicios.
                </p>
            </div>

            <a
                href="{{ route('admin.tramitanet.campos.create') }}"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
            >
                Nuevo campo
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
                                    Nombre
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Tipo
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Grupo
                                </th>

                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    Orden
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
                            @forelse ($campos as $campo)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-900">
                                            {{ $campo->nombre }}
                                        </div>

                                        <div class="text-xs text-gray-500">
                                            {{ $campo->slug }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ $campo->tipo_campo }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ $campo->grupo_expediente }}
                                    </td>

                                    <td class="px-4 py-3 text-center text-sm text-gray-700">
                                        {{ $campo->orden }}
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        @if ($campo->activo)
                                            <span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                                Activo
                                            </span>
                                        @else
                                            <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-right">
                                        <a
                                            href="{{ route('admin.tramitanet.campos.edit', $campo) }}"
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
                                        No hay campos maestros registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($campos->hasPages())
                    <div class="border-t border-gray-200 px-4 py-4">
                        {{ $campos->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
