@extends('publico.tramitanet.layouts.app')

@section('title', 'Consulta tu trámite | TramitaNet')

@section('content')

<section class="bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 py-16 text-white">
    <div class="mx-auto max-w-4xl px-6 text-center">
        <h1 class="text-4xl font-extrabold md:text-5xl">
            Consulta tu trámite
        </h1>

        <p class="mt-4 text-slate-300">
            Ingresa tu folio y código de consulta para conocer el estado de tu solicitud.
        </p>
    </div>
</section>

<section class="min-h-[55vh] bg-slate-100 py-14">
    <div class="mx-auto max-w-xl px-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow">

            <form
                method="POST"
                action="{{ route('tramitanet.consulta.buscar') }}"
            >
                @csrf

                @error('consulta')
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4">
                        <p class="text-sm font-semibold text-red-700">
                            {{ $message }}
                        </p>
                    </div>
                @enderror

                <div>
                    <label
                        for="folio"
                        class="mb-2 block text-sm font-bold text-slate-700"
                    >
                        Folio
                    </label>

                    <input
                        type="text"
                        id="folio"
                        name="folio"
                        value="{{ old('folio') }}"
                        autocomplete="off"
                        placeholder="Ej. 202607160001"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-lg font-semibold uppercase focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('folio')
                        <p class="mt-2 text-sm font-semibold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label
                        for="codigo_consulta"
                        class="mb-2 block text-sm font-bold text-slate-700"
                    >
                        Código de consulta
                    </label>

                    <input
                        type="text"
                        id="codigo_consulta"
                        name="codigo_consulta"
                        value="{{ old('codigo_consulta') }}"
                        inputmode="numeric"
                        maxlength="6"
                        autocomplete="one-time-code"
                        placeholder="Ej. 803630"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('codigo_consulta')
                        <p class="mt-2 text-sm font-semibold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="mt-2 text-xs text-slate-500">
                        Este código se entrega al finalizar la solicitud y posteriormente podrá enviarse por WhatsApp y correo electrónico.
                    </p>
                </div>

                <button
                    type="submit"
                    class="mt-6 w-full rounded-xl bg-orange-500 px-6 py-3 font-bold text-white hover:bg-orange-600"
                >
                    Consultar
                </button>
            </form>

            <p class="mt-5 text-center text-sm text-slate-500">
                El folio y el código se generan al finalizar tu solicitud.
            </p>

        </div>
    </div>
</section>

@endsection