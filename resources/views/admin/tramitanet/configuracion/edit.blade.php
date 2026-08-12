<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Configuración de TramitaNet
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl space-y-6 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="rounded-2xl border border-green-200 bg-green-50 p-4">
                    <p class="font-semibold text-green-800">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            @if($errors->any())
                <div class="rounded-2xl border border-red-200 bg-red-50 p-4">
                    <p class="font-bold text-red-800">
                        Revisa la información capturada.
                    </p>

                    <ul class="mt-2 list-inside list-disc text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('admin.tramitanet.configuracion.update') }}"
                class="rounded-3xl border border-gray-200 bg-white p-6 shadow"
            >
                @csrf
                @method('PATCH')

                <div class="flex flex-col gap-5 border-b border-gray-200 pb-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-xl font-black text-gray-900">
                            Horario de atención
                        </h3>

                        <p class="mt-1 text-sm text-gray-600">
                            Controla el indicador visible en el portal público.
                        </p>
                    </div>

                    <label class="inline-flex cursor-pointer items-center gap-3">
                        <input
                            type="checkbox"
                            name="servicio_abierto"
                            value="1"
                            class="peer sr-only"
                            @checked(old('servicio_abierto', $servicioAbierto))
                        >

                        <span class="relative h-7 w-12 rounded-full bg-gray-300 transition
                                     after:absolute after:left-1 after:top-1 after:h-5 after:w-5
                                     after:rounded-full after:bg-white after:shadow after:transition
                                     peer-checked:bg-green-600
                                     peer-checked:after:translate-x-5">
                        </span>

                        <span class="font-bold text-gray-800">
                            Servicio abierto
                        </span>
                    </label>
                </div>

                <div class="mt-6">
                    <label
                        for="mensaje_servicio_abierto"
                        class="mb-2 block text-sm font-bold text-gray-700"
                    >
                        Mensaje cuando está abierto
                    </label>

                    <textarea
                            id="mensaje_servicio_abierto"
                            name="mensaje_servicio_abierto"
                            data-preserve-case="true"
                            rows="3"
                            class="w-full rounded-xl border-gray-300"
                            required
                        >{{ old('mensaje_servicio_abierto', $mensajeAbierto) }}</textarea>
                </div>

                <div class="mt-6">
                    <label
                        for="mensaje_servicio_cerrado"
                        class="mb-2 block text-sm font-bold text-gray-700"
                    >
                        Mensaje cuando está cerrado
                    </label>

                    <textarea
                        id="mensaje_servicio_cerrado"
                        name="mensaje_servicio_cerrado"
                        data-preserve-case="true"
                        rows="4"
                        class="w-full rounded-xl border-gray-300"
                        required
                    >{{ old('mensaje_servicio_cerrado', $mensajeCerrado) }}</textarea>

                    {{-- Horario de atención --}}
                    <div class="mt-6">
                        <label
                            for="horario_atencion"
                            class="mb-2 block text-sm font-bold text-gray-700">
                            Horario habitual de atención
                        </label>

                        <textarea
                            id="horario_atencion"
                            name="horario_atencion"
                            rows="8"
                            data-preserve-case="true"
                            class="w-full rounded-xl border-gray-300"
                        >{{ old('horario_atencion', $horarioAtencion) }}</textarea>

                        <p class="mt-2 text-xs text-gray-500">
                            Los saltos de línea se mostrarán igual en TramitaNet.
                        </p>
                    </div>

                    {{-- Zona horaria --}}
                    <div class="mt-6">
                        <label
                            for="zona_horaria"
                            class="mb-2 block text-sm font-bold text-gray-700">
                            Zona horaria
                        </label>

                        <input
                            type="text"
                            id="zona_horaria"
                            name="zona_horaria"
                            value="{{ old('zona_horaria', $zonaHoraria) }}"
                            data-preserve-case="true"
                            class="w-full rounded-xl border-gray-300">
                    </div>
                </div>

                {{-- Programación automática --}}
                <div class="mt-8 border-t border-gray-200 pt-6">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-black text-gray-900">
                                Programación automática
                            </h3>

                            <p class="mt-1 text-sm text-gray-600">
                                TramitaNet determinará automáticamente si estamos dentro
                                o fuera del horario de atención.
                            </p>
                        </div>

                        <label class="inline-flex cursor-pointer items-center gap-3">
                            <input
                                type="checkbox"
                                name="horario_automatico"
                                value="1"
                                class="peer sr-only"
                                @checked(old('horario_automatico', $horarioAutomatico))
                            >

                            <span class="relative h-7 w-12 rounded-full bg-gray-300 transition
                                        after:absolute after:left-1 after:top-1 after:h-5 after:w-5
                                        after:rounded-full after:bg-white after:shadow after:transition
                                        peer-checked:bg-green-600
                                        peer-checked:after:translate-x-5">
                            </span>

                            <span class="font-bold text-gray-800">
                                Activar horario automático
                            </span>
                        </label>
                    </div>

                    {{-- Zona horaria técnica --}}
                    <div class="mt-6">
                        <label
                            for="zona_horaria_sistema"
                            class="mb-2 block text-sm font-bold text-gray-700"
                        >
                            Zona horaria del sistema
                        </label>

                        <select
                            id="zona_horaria_sistema"
                            name="zona_horaria_sistema"
                            class="w-full rounded-xl border-gray-300 sm:max-w-md"
                        >
                            <option
                                value="America/Mazatlan"
                                @selected(
                                    old(
                                        'zona_horaria_sistema',
                                        $zonaHorariaSistema
                                    ) === 'America/Mazatlan'
                                )
                            >
                                America/Mazatlan
                            </option>
                        </select>

                        <p class="mt-2 text-xs text-gray-500">
                            Esta zona horaria se utiliza para calcular automáticamente
                            si TramitaNet está dentro del horario de atención.
                        </p>
                    </div>

                    {{-- Horario semanal --}}
                    <div class="mt-8 space-y-4">

                        @php
                            $diasSemana = [
                                'lunes' => 'Lunes',
                                'martes' => 'Martes',
                                'miercoles' => 'Miércoles',
                                'jueves' => 'Jueves',
                                'viernes' => 'Viernes',
                                'sabado' => 'Sábado',
                                'domingo' => 'Domingo',
                            ];
                        @endphp

                        @foreach($diasSemana as $claveDia => $nombreDia)

                            @php
                                $turnosDia = old(
                                    "horarios.$claveDia",
                                    $horarioProgramado[$claveDia] ?? []
                                );

                                $turno1 = $turnosDia[0] ?? [
                                    'inicio' => '',
                                    'fin' => '',
                                ];

                                $turno2 = $turnosDia[1] ?? [
                                    'inicio' => '',
                                    'fin' => '',
                                ];
                            @endphp

                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4">

                                <div class="mb-4">
                                    <h4 class="text-base font-black text-gray-900">
                                        {{ $nombreDia }}
                                    </h4>
                                </div>

                                <div class="grid gap-4 lg:grid-cols-2">

                                    {{-- Turno 1 --}}
                                    <div class="rounded-xl border border-gray-200 bg-white p-4">

                                        <p class="mb-3 text-sm font-bold text-gray-700">
                                            Turno 1
                                        </p>

                                        <div class="grid grid-cols-2 gap-3">

                                            <div>
                                                <label class="mb-1 block text-xs font-bold text-gray-500">
                                                    Inicio
                                                </label>

                                                <input
                                                    type="time"
                                                    name="horarios[{{ $claveDia }}][0][inicio]"
                                                    value="{{ $turno1['inicio'] ?? '' }}"
                                                    class="w-full rounded-lg border-gray-300"
                                                >
                                            </div>

                                            <div>
                                                <label class="mb-1 block text-xs font-bold text-gray-500">
                                                    Fin
                                                </label>

                                                <input
                                                    type="time"
                                                    name="horarios[{{ $claveDia }}][0][fin]"
                                                    value="{{ $turno1['fin'] ?? '' }}"
                                                    class="w-full rounded-lg border-gray-300"
                                                >
                                            </div>

                                        </div>
                                    </div>

                                    {{-- Turno 2 --}}
                                    <div class="rounded-xl border border-gray-200 bg-white p-4">

                                        <p class="mb-3 text-sm font-bold text-gray-700">
                                            Turno 2
                                            <span class="font-normal text-gray-400">
                                                (opcional)
                                            </span>
                                        </p>

                                        <div class="grid grid-cols-2 gap-3">

                                            <div>
                                                <label class="mb-1 block text-xs font-bold text-gray-500">
                                                    Inicio
                                                </label>

                                                <input
                                                    type="time"
                                                    name="horarios[{{ $claveDia }}][1][inicio]"
                                                    value="{{ $turno2['inicio'] ?? '' }}"
                                                    class="w-full rounded-lg border-gray-300"
                                                >
                                            </div>

                                            <div>
                                                <label class="mb-1 block text-xs font-bold text-gray-500">
                                                    Fin
                                                </label>

                                                <input
                                                    type="time"
                                                    name="horarios[{{ $claveDia }}][1][fin]"
                                                    value="{{ $turno2['fin'] ?? '' }}"
                                                    class="w-full rounded-lg border-gray-300"
                                                >
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>

                <button
                    type="submit"
                    class="mt-6 rounded-xl bg-blue-700 px-6 py-3 font-bold text-white transition hover:bg-blue-800"
                >
                    Guardar configuración
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
