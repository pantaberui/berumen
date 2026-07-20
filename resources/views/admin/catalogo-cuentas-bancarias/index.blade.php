<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-wide text-indigo-600">
                    TramitaNet
                </p>

                <h1 class="text-2xl font-black text-gray-900">
                    Cuentas bancarias
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Administra las cuentas disponibles para pagos de trámites y servicios.
                </p>
            </div>

            <a
                href="{{ route('admin.catalogo-cuentas-bancarias.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 font-bold text-white hover:bg-indigo-700"
            >
                Nueva cuenta
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 font-bold text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 font-bold text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-500">
                                    Orden
                                </th>

                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-500">
                                    Banco
                                </th>

                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-500">
                                    Cuenta
                                </th>

                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-500">
                                    Métodos
                                </th>

                                <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-500">
                                    Estatus
                                </th>

                                <th class="px-5 py-3 text-right text-xs font-bold uppercase tracking-wide text-gray-500">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($cuentas as $cuenta)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-5 py-4 text-sm font-bold text-gray-700">
                                        {{ $cuenta->orden }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            @if ($cuenta->logo_url)
                                                <div class="flex h-12 w-16 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white p-2">
                                                    <img
                                                        src="{{ $cuenta->logo_url }}"
                                                        alt="Logo de {{ $cuenta->banco }}"
                                                        class="max-h-8 max-w-full object-contain"
                                                    >
                                                </div>
                                            @endif

                                            <div>
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <p class="font-black text-gray-900">
                                                        {{ $cuenta->banco }}
                                                    </p>

                                                    @if ($cuenta->es_principal)
                                                        <span class="rounded-full bg-indigo-100 px-2 py-1 text-xs font-bold text-indigo-700">
                                                            Principal
                                                        </span>
                                                    @endif
                                                </div>

                                                <p class="mt-1 text-sm text-gray-600">
                                                    {{ $cuenta->alias }}
                                                </p>

                                                <p class="text-xs text-gray-500">
                                                    {{ $cuenta->titular }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 text-sm text-gray-700">
                                        @if ($cuenta->clabe_interbancaria)
                                            <p>
                                                <span class="font-bold">CLABE:</span>
                                                {{ $cuenta->clabe_interbancaria }}
                                            </p>
                                        @endif

                                        @if ($cuenta->numero_cuenta)
                                            <p class="mt-1">
                                                <span class="font-bold">Cuenta:</span>
                                                {{ $cuenta->numero_cuenta }}
                                            </p>
                                        @endif

                                        @if ($cuenta->numero_tarjeta)
                                            <p class="mt-1">
                                                <span class="font-bold">Tarjeta:</span>
                                                {{ $cuenta->numero_tarjeta }}
                                            </p>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            @if ($cuenta->acepta_transferencia)
                                                <span class="rounded-full bg-blue-100 px-2 py-1 text-xs font-bold text-blue-700">
                                                    Transferencia
                                                </span>
                                            @endif

                                            @if ($cuenta->acepta_deposito)
                                                <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-bold text-amber-700">
                                                    Depósito
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        @if ($cuenta->activo)
                                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">
                                                Activa
                                            </span>
                                        @else
                                            <span class="rounded-full bg-gray-200 px-3 py-1 text-xs font-bold text-gray-600">
                                                Inactiva
                                            </span>
                                        @endif
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a
                                                href="{{ route('admin.catalogo-cuentas-bancarias.edit', $cuenta) }}"
                                                class="rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-2 text-sm font-bold text-indigo-700 hover:bg-indigo-100"
                                            >
                                                Editar
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.catalogo-cuentas-bancarias.destroy', $cuenta) }}"
                                                onsubmit="return confirm('¿Deseas eliminar esta cuenta bancaria?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-bold text-red-700 hover:bg-red-100"
                                                >
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <p class="font-bold text-gray-700">
                                            No hay cuentas bancarias registradas.
                                        </p>

                                        <a
                                            href="{{ route('admin.catalogo-cuentas-bancarias.create') }}"
                                            class="mt-4 inline-flex rounded-xl bg-indigo-600 px-5 py-3 font-bold text-white hover:bg-indigo-700"
                                        >
                                            Registrar primera cuenta
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($cuentas->hasPages())
                    <div class="border-t border-gray-200 px-5 py-4">
                        {{ $cuentas->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>