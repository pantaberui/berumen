<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Centro de Gestión TramitaNet
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="rounded-xl border border-green-200 bg-green-50 p-4">
                    <p class="font-semibold text-green-800">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            @if(session('info'))
                <div class="rounded-xl border border-blue-200 bg-blue-50 p-4">
                    <p class="font-semibold text-blue-800">
                        {{ session('info') }}
                    </p>
                </div>
            @endif

            @include('admin.tramitanet.solicitudes.partials.encabezado')

            <div class="grid lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">
                    @include('admin.tramitanet.solicitudes.partials.general')

                    @include('admin.tramitanet.solicitudes.partials.documentos')

                    @include('admin.tramitanet.solicitudes.partials.pago')

                    @include('admin.tramitanet.solicitudes.partials.documentos-generados')

                    @include('admin.tramitanet.solicitudes.partials.historial')

                    @include('admin.tramitanet.solicitudes.partials.bitacora')
                </div>

                <div class="space-y-6">
                    @include('admin.tramitanet.solicitudes.partials.panel-lateral')
                </div>

            </div>

        </div>
    </div>
</x-app-layout>