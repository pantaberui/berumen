<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Compra #{{ $compra->id }}</h2>
            <div class="space-x-2">
                <a href="{{ route('admin.compras.edit', $compra) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
                <a href="{{ route('admin.compras.index') }}"
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Volver</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6 text-sm space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div><span class="font-medium text-gray-500">Producto</span>
                        <p>{{ $compra->producto->clave }} — {{ $compra->producto->descripcion }}</p>
                    </div>
                    <div><span class="font-medium text-gray-500">Cantidad</span>
                        <p>{{ $compra->cantidad }}</p>
                    </div>
                    <div><span class="font-medium text-gray-500">Precio de Compra</span>
                        <p>${{ number_format($compra->precio_compra, 2) }}</p>
                    </div>
                    <div><span class="font-medium text-gray-500">Total</span>
                        <p class="font-bold text-green-700">${{ number_format($compra->total, 2) }}</p>
                    </div>
                    <div><span class="font-medium text-gray-500">Usuario</span>
                        <p>{{ $compra->usuario->name }}</p>
                    </div>
                    <div><span class="font-medium text-gray-500">Fecha</span>
                        <p>{{ $compra->fecha_hora_compra?->format('d/m/Y H:i') }}</p>
                    </div>
                    @if($compra->observaciones)
                    <div class="col-span-2"><span class="font-medium text-gray-500">Observaciones</span>
                        <p>{{ $compra->observaciones }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>