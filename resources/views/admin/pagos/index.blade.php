<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Pagos</h2>
            <a href="{{ route('admin.pagos.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Registrar Pago
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contrato</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Pago</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periodo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cajero</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pagos as $pago)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $pago->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $pago->contrato->numero_contrato }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $pago->contrato->cliente->nombre_completo }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $pago->periodo_desde->format('d/m/Y') }} — {{ $pago->periodo_hasta->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">${{ number_format($pago->total, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 capitalize">{{ $pago->tipo_pago }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $pago->cajero->name }}</td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.pagos.show', $pago) }}"
                                   class="text-blue-600 hover:underline">Ver</a>
                                <a href="{{ route('admin.pagos.edit', $pago) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                                <form action="{{ route('admin.pagos.destroy', $pago) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('¿Eliminar este pago?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-400">
                                No hay pagos registrados aún.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">
                    {{ $pagos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>