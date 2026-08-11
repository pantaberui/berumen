<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Servicios TramitaNet
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Administra precios, información pública, visibilidad y SEO de los servicios.
                </p>
            </div>

            <a
                href="{{ route('admin.tramitanet.servicios.create') }}"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
            >
                Nuevo servicio
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-xl bg-white shadow">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Orden
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Servicio
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Institución
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Precio
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Portada
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Estado
                                </th>

                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($servicios as $servicio)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">
                                        {{ $servicio->orden }}
                                    </td>

                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-gray-900">
                                            {{ $servicio->titulo_publico ?: $servicio->nombre }}
                                        </div>

                                        <div class="mt-1 text-xs text-gray-500">
                                            {{ $servicio->slug }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        {{ $servicio->institucion->nombre ?? 'Sin institución' }}
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700">
                                        @if ($servicio->tipo_precio === 'gratuito')
                                            Gratuito
                                        @elseif ($servicio->precio !== null)
                                            ${{ number_format((float) $servicio->precio, 2) }}
                                        @else
                                            Variable
                                        @endif
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-4">
                                        @if ($servicio->mostrar_en_portada)
                                            <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                                Sí
                                            </span>
                                        @else
                                            <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                                No
                                            </span>
                                        @endif
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-4">
                                        @if ($servicio->activo)
                                            <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                                Activo
                                            </span>
                                        @else
                                            <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-4 text-right">
                                        <a
                                            href="{{ route('admin.tramitanet.servicios.edit', $servicio) }}"
                                            class="text-sm font-semibold text-blue-600 hover:text-blue-800"
                                        >
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-10 text-center text-sm text-gray-500">
                                        No hay servicios registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($servicios->hasPages())
                    <div class="border-t border-gray-200 px-4 py-4">
                        {{ $servicios->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
