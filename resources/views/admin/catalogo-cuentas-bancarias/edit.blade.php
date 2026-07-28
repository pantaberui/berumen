<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-bold uppercase tracking-wide text-indigo-600">
                TramitaNet
            </p>

            <h1 class="text-2xl font-black text-gray-900">
                Editar cuenta bancaria
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                {{ $cuenta->alias }}
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 font-bold text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('admin.catalogo-cuentas-bancarias.update', $cuenta) }}"
            >
                @csrf
                @method('PUT')

                @include('admin.catalogo-cuentas-bancarias.form')
            </form>
        </div>
    </div>
</x-app-layout>