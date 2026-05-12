<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Editar Venta #{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="mb-4 p-3 bg-gray-50 rounded text-sm">
                    <span class="font-medium text-gray-500">Cliente:</span> {{ $venta->cliente_nombre }}
                </div>

                <form action="{{ route('admin.ventas.update', $venta) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo de Pago</label>
                            <select name="tipo_pago" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="efectivo"      {{ $venta->tipo_pago == 'efectivo'      ? 'selected' : '' }}>Efectivo</option>
                                <option value="transferencia" {{ $venta->tipo_pago == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                                <option value="tarjeta"       {{ $venta->tipo_pago == 'tarjeta'       ? 'selected' : '' }}>Tarjeta</option>
                            </select>
                        </div>

                        @if(auth()->user()->hasRole('admin'))
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estatus</label>
                            <select name="estatus" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="completada" {{ $venta->estatus == 'completada' ? 'selected' : '' }}>Completada</option>
                                <option value="cancelada"  {{ $venta->estatus == 'cancelada'  ? 'selected' : '' }}>Cancelada</option>
                            </select>
                            @if($venta->estatus === 'cancelada')
                                <p class="text-xs text-red-600 mt-1">
                                    Cancelada el {{ $venta->fecha_hora_cancelacion?->format('d/m/Y H:i') }}
                                    por {{ $venta->canceladoPor?->name }}
                                </p>
                            @endif
                        </div>
                        @endif

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observaciones" rows="2"
                                      class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ $venta->observaciones }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.ventas.show', $venta) }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancelar</a>
                        <button type="submit"
                                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>