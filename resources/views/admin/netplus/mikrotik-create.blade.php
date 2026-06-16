<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Generar Códigos MikroTik
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('admin.netplus.mikrotik.generate') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Cantidad de códigos *
                        </label>
                        <input type="number"
                               name="cantidad"
                               min="1"
                               max="5000"
                               value="{{ old('cantidad', 10) }}"
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('cantidad')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Tiempo *
                        </label>
                        <select name="tiempo"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="00:30:00" {{ old('tiempo') == '00:30:00' ? 'selected' : '' }}>Media hora</option>
                            <option value="01:00:00" {{ old('tiempo') == '01:00:00' ? 'selected' : '' }}>1 Hora</option>
                            <option value="03:00:00" {{ old('tiempo') == '03:00:00' ? 'selected' : '' }}>3 Horas</option>
                            <option value="1d" {{ old('tiempo') == '1d' ? 'selected' : '' }}>1 Día</option>
                            <option value="1w" {{ old('tiempo') == '1w' ? 'selected' : '' }}>1 Semana</option>
                            <option value="4w" {{ old('tiempo') == '4w' ? 'selected' : '' }}>1 Mes</option>
                        </select>
                        @error('tiempo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($errors->has('archivo'))
                        <div class="p-3 rounded bg-red-50 text-red-700 text-sm">
                            {{ $errors->first('archivo') }}
                        </div>
                    @endif

                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Generar y descargar ZIP
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-sm text-gray-600">
                    Se generará un archivo ZIP con:
                    <ul class="list-disc ml-6 mt-2">
                        <li><strong>air-vouchercodes.csv</strong></li>
                        <li><strong>air-importme.rsc</strong></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>