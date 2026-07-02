<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nuevo Tipo de Trámite</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                @if($errors->any())
                    <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.tipo-tramites.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo</label>
                            <input type="text" name="tipo" value="{{ old('tipo') }}"
                                placeholder="Ej: SAT, IMSS, INFONAVIT, SRE..."
                                class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre *</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Requisitos</label>
                            <textarea name="requisitos" rows="3"
                                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                    placeholder="Lista los documentos o requisitos necesarios...">{{ old('requisitos') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Precio Sugerido</label>
                            <input type="number" name="precio_sugerido" step="0.01" min="0"
                                   value="{{ old('precio_sugerido') }}"
                                   placeholder="Dejar vacío si no tiene precio fijo"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="activo" value="1" id="activo" checked
                                   class="rounded border-gray-300 text-blue-600">
                            <label for="activo" class="ml-2 text-sm text-gray-700">Activo</label>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.tipo-tramites.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancelar</a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>