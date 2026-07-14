@props([
    'campoServicio',
])

@php
    $campo = $campoServicio->campoMaestro;
    $nombre = 'campos[' . $campo->slug . ']';
    $id = 'campo_' . $campo->slug;

    $inputType = match ($campo->tipo_campo) {
        'email' => 'email',
        'number' => 'number',
        'date' => 'date',
        'password' => 'password',
        default => 'text',
    };
@endphp

<div class="mb-5">
    @if($campo->tipo_campo !== 'checkbox')
        <label for="{{ $id }}" class="block text-sm font-bold text-slate-700 mb-2">
            {{ $campo->nombre }}

            @if($campoServicio->requerido)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    @if(in_array($campo->tipo_campo, ['text', 'curp', 'rfc', 'nss', 'tel', 'email', 'number', 'date', 'password']))
        <input
            type="{{ $inputType }}"
            id="{{ $id }}"
            name="{{ $nombre }}"
            value="{{ old('campos.' . $campo->slug) }}"
            placeholder="{{ $campo->placeholder }}"
            autocomplete="{{ $campo->autocomplete ?? 'off' }}"
            class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            @if($campoServicio->requerido) required @endif
            @if($campo->longitud_maxima) maxlength="{{ $campo->longitud_maxima }}" @endif
        >

    @elseif($campo->tipo_campo === 'textarea')
        <textarea
            id="{{ $id }}"
            name="{{ $nombre }}"
            rows="4"
            placeholder="{{ $campo->placeholder }}"
            class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            @if($campoServicio->requerido) required @endif
        >{{ old('campos.' . $campo->slug) }}</textarea>

    @elseif($campo->tipo_campo === 'file')
        <input
            type="file"
            id="{{ $id }}"
            name="{{ $nombre }}"
            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm"
            @if($campoServicio->requerido) required @endif
            @if($campo->accept) accept="{{ $campo->accept }}" @endif
            @if($campo->multiple) multiple @endif
        >

    @elseif($campo->tipo_campo === 'select')
        @php
        $opciones = $campoServicio->opciones_personalizadas
            ?? $campo->opciones
            ?? [];

        if (is_string($opciones)) {
            $opciones = json_decode($opciones, true) ?? [];
        }
    @endphp

        <select
            id="{{ $id }}"
            name="{{ $nombre }}"
            class="w-full rounded-xl border-slate-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
            @if($campoServicio->requerido) required @endif
        >
            <option value="">
                {{ $campo->placeholder ?: 'Selecciona una opción' }}
            </option>

            @foreach($opciones as $opcion)
                @php
                    $valorOpcion = is_array($opcion)
                        ? ($opcion['value'] ?? $opcion['valor'] ?? null)
                        : $opcion;

                    $etiquetaOpcion = is_array($opcion)
                        ? ($opcion['label'] ?? $opcion['etiqueta'] ?? $valorOpcion)
                        : $opcion;
                @endphp

                @if($valorOpcion !== null)
                    <option
                        value="{{ $valorOpcion }}"
                        @selected(
                            old('campos.' . $campo->slug) == $valorOpcion
                        )
                    >
                        {{ $etiquetaOpcion }}
                    </option>
                @endif
            @endforeach
        </select>

    @elseif($campo->tipo_campo === 'checkbox')
        <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <input
                type="checkbox"
                id="{{ $id }}"
                name="{{ $nombre }}"
                value="1"
                class="mt-1 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                @checked(old('campos.' . $campo->slug))
                @if($campoServicio->requerido) required @endif
            >

            <span class="text-sm text-slate-700">
                <strong>{{ $campo->nombre }}</strong><br>
                {{ $campo->ayuda }}
            </span>
        </label>
    @endif

    @if($campo->ayuda && $campo->tipo_campo !== 'checkbox')
        <p class="text-xs text-slate-500 mt-2">
            {{ $campo->ayuda }}
        </p>
    @endif

    @error('campos.' . $campo->slug)
        <p class="text-sm text-red-600 font-semibold mt-2">
            {{ $message }}
        </p>
    @enderror

    @error($campo->slug)
        <p class="text-sm text-red-600 font-semibold mt-2">
            {{ $message }}
        </p>
    @enderror
</div>