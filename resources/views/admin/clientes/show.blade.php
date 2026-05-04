<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                {{ $cliente->nombre_completo }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('admin.clientes.edit', $cliente) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Editar
                </a>
                <a href="{{ route('admin.clientes.index') }}"
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Datos personales --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Datos Personales</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                    <div><span class="font-medium text-gray-500">Nombre completo</span><p>{{ $cliente->nombre_completo }}</p></div>
                    <div><span class="font-medium text-gray-500">Teléfono</span><p>{{ $cliente->telefono ?? '—' }}</p></div>
                    <div><span class="font-medium text-gray-500">Celular</span><p>{{ $cliente->celular ?? '—' }}</p></div>
                    <div><span class="font-medium text-gray-500">Email</span><p>{{ $cliente->email ?? '—' }}</p></div>
                    <div><span class="font-medium text-gray-500">CURP</span><p>{{ $cliente->curp ?? '—' }}</p></div>
                    <div><span class="font-medium text-gray-500">RFC</span><p>{{ $cliente->rfc ?? '—' }}</p></div>
                    <div class="col-span-2"><span class="font-medium text-gray-500">Dirección</span>
                        <p>{{ $cliente->calle }} {{ $cliente->numero_exterior }}, {{ $cliente->colonia }}, {{ $cliente->ciudad }} {{ $cliente->codigo_postal }}</p>
                    </div>
                    <div><span class="font-medium text-gray-500">Estatus</span>
                        <p>
                            @if($cliente->activo)
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Activo</span>
                            @else
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Inactivo</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Contratos --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Contratos</h3>
                @forelse($cliente->contratos as $contrato)
                    <div class="border rounded p-3 mb-2 text-sm">
                        <span class="font-medium">{{ $contrato->numero_contrato }}</span> —
                        Desde {{ $contrato->fecha_inicio->format('d/m/Y') }} —
                        ${{ number_format($contrato->mensualidad, 2) }}/mes —
                        <span class="capitalize">{{ $contrato->estatus }}</span>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">Sin contratos registrados.</p>
                @endforelse
            </div>

            {{-- Incidencias --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Incidencias</h3>
                @forelse($cliente->incidencias as $incidencia)
                    <div class="border rounded p-3 mb-2 text-sm">
                        <span class="font-medium">{{ $incidencia->titulo }}</span> —
                        <span class="capitalize">{{ str_replace('_', ' ', $incidencia->estatus) }}</span> —
                        {{ $incidencia->created_at->format('d/m/Y') }}
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">Sin incidencias registradas.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>