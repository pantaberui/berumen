@extends('publico.tramitanet.layouts.app')

@section('title', 'Consulta tu trámite | TramitaNet')

@section('content')

<section class="bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 text-white py-16">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold">
            Consulta tu trámite
        </h1>

        <p class="text-slate-300 mt-4">
            Ingresa tu folio para conocer el estado de tu solicitud.
        </p>
    </div>
</section>

<section class="bg-slate-100 py-14 min-h-[55vh]">
    <div class="max-w-xl mx-auto px-6">
        <div class="bg-white rounded-3xl shadow border border-slate-200 p-8">

            <form method="GET" action="#">
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Folio
                </label>

                <input type="text"
                       name="folio"
                       class="w-full rounded-xl border-slate-300 text-lg font-semibold uppercase"
                       placeholder="Ej. 202607030001">

                <button type="submit"
                        class="w-full mt-5 bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-bold">
                    Consultar
                </button>
            </form>

            <p class="text-sm text-slate-500 mt-5 text-center">
                El folio se genera al finalizar tu solicitud.
            </p>

        </div>
    </div>
</section>

@endsection