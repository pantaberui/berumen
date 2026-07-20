<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold uppercase tracking-wide text-indigo-600">
                TramitaNet
            </p>

            <h1 class="text-2xl font-black text-gray-900">
                Nueva cuenta bancaria
            </h1>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <form
                method="POST"
                action="{{ route('admin.catalogo-cuentas-bancarias.store') }}"
            >
                @csrf

                @include('admin.catalogo-cuentas-bancarias.form')
            </form>
        </div>
    </div>
</x-app-layout>