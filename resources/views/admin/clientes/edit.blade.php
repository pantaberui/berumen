<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Editar Cliente — {{ $cliente->nombre_completo }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                @if($errors->any())
                    <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.clientes.update', $cliente) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre *</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Apellido Paterno *</label>
                            <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $cliente->apellido_paterno) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Apellido Materno</label>
                            <input type="text" name="apellido_materno" value="{{ old('apellido_materno', $cliente->apellido_materno) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Celular</label>
                            <input type="text" name="celular" value="{{ old('celular', $cliente->celular) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email', $cliente->email) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">CURP</label>
                            <input type="text" name="curp" value="{{ old('curp', $cliente->curp) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm" maxlength="18">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">RFC</label>
                            <input type="text" name="rfc" value="{{ old('rfc', $cliente->rfc) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm" maxlength="13">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ciudad</label>
                            <input type="text" name="ciudad" value="{{ old('ciudad', $cliente->ciudad) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Calle</label>
                            <input type="text" name="calle" value="{{ old('calle', $cliente->calle) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Número Exterior</label>
                            <input type="text" name="numero_exterior" value="{{ old('numero_exterior', $cliente->numero_exterior) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Colonia</label>
                            <input type="text" name="colonia" value="{{ old('colonia', $cliente->colonia) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Código Postal</label>
                            <input type="text" name="codigo_postal" value="{{ old('codigo_postal', $cliente->codigo_postal) }}"
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm" maxlength="10">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Referencias</label>
                            <textarea name="referencias" rows="3"
                                      class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('referencias', $cliente->referencias) }}</textarea>
                        </div>

                        <div class="flex items-center mt-6">
                            <input type="checkbox" name="activo" value="1" id="activo"
                                   {{ old('activo', $cliente->activo) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600">
                            <label for="activo" class="ml-2 text-sm text-gray-700">Cliente activo</label>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.clientes.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Actualizar Cliente
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>