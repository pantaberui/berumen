@extends('publico.tramitanet.layouts.app')

@section('title', $modalidadServicio->nombre)

@section('content')

<section class="bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 text-white py-14">

    <div class="max-w-6xl mx-auto px-6">

        <a href="{{ route('tramitanet.servicio', $servicio->slug) }}"
           class="text-blue-200 hover:text-white text-sm font-semibold">

            ← Cambiar modalidad

        </a>

        <h1 class="text-4xl font-black mt-8">

            {{ $servicio->titulo_publico }}

        </h1>

        <p class="text-slate-300 mt-3">

            {{ $modalidadServicio->nombre }}

        </p>

    </div>

</section>

<section class="bg-slate-100 py-12">

<div class="max-w-6xl mx-auto px-6 grid lg:grid-cols-3 gap-8">

<div class="lg:col-span-2">

<div class="bg-white rounded-3xl shadow p-8">

<h2 class="text-2xl font-black">

Esta modalidad requiere:

</h2>

<ul class="mt-6 space-y-3">

@foreach($modalidadServicio->campos as $campo)

<li class="flex items-center gap-3">

<span class="text-green-600">✔</span>

{{ $campo->campoMaestro->nombre }}

</li>

@endforeach

</ul>

<hr class="my-8">

@php
    $tieneArchivos = $modalidadServicio->campos
        ->contains(fn($campo) => $campo->campoMaestro->tipo_campo === 'file');
@endphp

@if($errors->any())
    <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-4">
        <p class="font-bold text-red-800">
            Revisa la información capturada
        </p>

        <ul class="text-sm text-red-700 mt-2 list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST"
      action="{{ $tieneArchivos
            ? route('tramitanet.servicio.store', $servicio->slug)
            : route('tramitanet.servicio.resumen', $servicio->slug)
        }}"
      enctype="multipart/form-data">

@csrf

    <input
        type="hidden"
        name="modalidad"
        value="{{ $modalidadServicio->id }}">

    @foreach($modalidadServicio->campos as $campo)
        <x-tramitanet.dynamic-field
            :campo-servicio="$campo" />
    @endforeach

    @include('publico.tramitanet.partials.datos-contacto')

    @include('publico.tramitanet.partials.captcha')

    <div class="mt-8">
        <button
            class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-8 py-3 rounded-xl">
            Continuar solicitud
        </button>
    </div>

</form>

</div>

</div>

<aside>

<div class="bg-white rounded-3xl shadow p-8">

<p class="text-sm uppercase text-slate-500">

Tiempo estimado

</p>

<p class="font-black text-xl mt-2">

{{ $modalidadServicio->tiempo_estimado }}

</p>

<hr class="my-6">

<p class="text-sm uppercase text-slate-500">

Costo

</p>

<p class="font-black text-4xl mt-2">

${{ number_format($modalidadServicio->precio,2) }}

</p>

<p class="text-slate-500">

MXN

</p>

</div>

</aside>

</div>

</section>

@endsection