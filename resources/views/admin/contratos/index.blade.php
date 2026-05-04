<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Contratos</h2>
            <a href="{{ route('admin.contratos.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nuevo Contrato
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contrato</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Inicio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mensualidad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Velocidad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($contratos as $contrato)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $contrato->numero_contrato }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $contrato->cliente->nombre_completo }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $contrato->fecha_inicio->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">${{ number_format($contrato->mensualidad, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $contrato->velocidad ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($contrato->estatus === 'activo')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Activo</span>
                                @elseif($contrato->estatus === 'adeudo')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">Adeudo</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Cancelado</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.contratos.show', $contrato) }}"
                                   class="text-blue-600 hover:underline">Ver</a>
                                <a href="{{ route('admin.contratos.edit', $contrato) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                                <form action="{{ route('admin.contratos.destroy', $contrato) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('¿Eliminar este contrato?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                No hay contratos registrados aún.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">
                    {{ $contratos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>