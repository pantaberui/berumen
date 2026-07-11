@php
    $documentos = $datosAgrupados->get('documentos', collect());
@endphp

<div class="bg-white rounded-2xl shadow border border-gray-200 p-6">
    <h2 class="text-xl font-black text-gray-900 mb-5">
        📎 Documentos recibidos
    </h2>

    @forelse($documentos as $documento)
        <div class="border rounded-xl bg-gray-50 p-5 mb-4">

    {{-- Encabezado --}}
    <div class="flex items-center gap-3">

        @php
            $extension = strtolower(pathinfo($documento->nombre_original_archivo, PATHINFO_EXTENSION));

            $icono = '📄';
            $tipo  = 'Documento';

            if ($extension === 'pdf') {
                $icono = '📄';
                $tipo  = 'Documento PDF';
            } elseif ($extension === 'cer') {
                $icono = '🔐';
                $tipo  = 'Certificado digital (.CER)';
            } elseif ($extension === 'key') {
                $icono = '🔑';
                $tipo  = 'Llave privada (.KEY)';
            } elseif (in_array($extension, ['jpg','jpeg','png'])) {
                $icono = '🖼️';
                $tipo  = 'Imagen';
            }
        @endphp

        <span class="text-3xl">
            {{ $icono }}
        </span>

        <div>

            <p class="text-xs uppercase tracking-wide text-gray-500 font-bold">
                {{ $tipo }}
            </p>

            <p class="font-bold text-gray-900 break-all">
                {{ $documento->nombre_original_archivo }}
            </p>

        </div>

    </div>

    {{-- Información --}}
    <div class="mt-4 flex flex-wrap gap-6 text-sm text-gray-600">

        @if($documento->tamano_archivo)
            <span>
                📦 {{ number_format($documento->tamano_archivo/1024,1) }} KB
            </span>
        @endif

        <span>
            🗓 {{ $documento->created_at->format('d/m/Y H:i') }}
        </span>

    </div>

    {{-- Acciones --}}
    <div class="mt-5 flex gap-3">

        @php
            $extension = strtolower(pathinfo($documento->nombre_original_archivo, PATHINFO_EXTENSION));
        @endphp

        @if(in_array($extension,['pdf','jpg','jpeg','png']))
            <a
                href="#"
                class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100 text-sm font-semibold">
                👁 Ver
            </a>
        @endif

        <a
            href="{{ route('admin.tramitanet.solicitudes.documentos.descargar', [$solicitud, $documento]) }}"
            class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold">

            ⬇ Descargar

        </a>

    </div>

</div>


    @empty
        <p class="text-gray-500 text-sm">
            No se recibieron documentos para esta solicitud.
        </p>
    @endforelse
</div>