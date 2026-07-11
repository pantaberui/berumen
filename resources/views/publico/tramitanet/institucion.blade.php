@extends('publico.tramitanet.layouts.app')

@section('title', $institucion->nombre . ' | TramitaNet')

@section('content')

<section class="bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 text-white py-14">
    <div class="max-w-7xl mx-auto px-6">
        <a href="{{ route('tramitanet.index') }}" class="text-blue-200 hover:text-white text-sm font-semibold">
            ← Volver al inicio
        </a>

        <div class="mt-8">
            <p class="text-orange-400 font-bold uppercase tracking-wide text-sm">
                Institución
            </p>

            <h1 class="text-4xl md:text-5xl font-extrabold mt-2">
                {{ $institucion->nombre }}
            </h1>

            <p class="text-slate-300 mt-4 max-w-3xl">
                {{ $institucion->descripcion }}
            </p>
        </div>
    </div>
</section>

<section class="bg-slate-100 py-12">
    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-3xl font-extrabold text-slate-900 mb-8">
            Trámites disponibles
        </h2>

        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($institucion->servicios as $servicio)
                <a href="{{ route('tramitanet.servicio', $servicio->slug) }}"
                   class="block bg-white rounded-3xl border border-slate-200 p-7 shadow hover:shadow-xl hover:-translate-y-1 transition">

                    <p class="text-sm font-bold text-blue-700 uppercase">
                        {{ $institucion->nombre }}
                    </p>

                    <h3 class="text-xl font-extrabold text-slate-900 mt-2">
                        {{ $servicio->titulo_publico ?? $servicio->nombre }}
                    </h3>

                    <p class="text-slate-600 text-sm mt-3">
                        {{ $servicio->descripcion_corta }}
                    </p>

                    <p class="mt-6 text-orange-600 font-bold">
                        Ver detalles →
                    </p>
                </a>
            @endforeach
        </div>

    </div>
</section>

@endsection