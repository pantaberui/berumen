<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Error temporal | TramitaNet</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 font-sans text-white antialiased">

    <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-12 sm:px-6">

        {{-- Decoración de fondo --}}
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute left-[-80px] top-[-80px] h-64 w-64 rounded-full bg-blue-500/20 blur-3xl"></div>
            <div class="absolute bottom-[-100px] right-[-80px] h-72 w-72 rounded-full bg-orange-500/20 blur-3xl"></div>
        </div>

        <section class="relative w-full max-w-3xl rounded-3xl border border-white/10 bg-white/5 p-6 text-center shadow-2xl backdrop-blur sm:p-10">

            <a
                href="{{ route('tramitanet.index') }}"
                class="mx-auto mb-10 inline-flex items-center justify-center"
            >
                <img
                    src="{{ asset('images/logo-horizontal.png') }}"
                    alt="TramitaNet"
                    class="h-16 w-auto max-w-[240px] rounded-xl bg-white object-contain p-1 shadow-lg sm:h-20"
                >
            </a>

            <p class="text-sm font-black uppercase tracking-[0.35em] text-orange-400">
                Error 500
            </p>

            <h1 class="mt-4 text-7xl font-black tracking-tight text-white sm:text-9xl">
                500
            </h1>

            <h2 class="mt-5 text-2xl font-black text-white sm:text-4xl">
                Tenemos un problema temporal
            </h2>

            <p class="mx-auto mt-5 max-w-xl text-base leading-7 text-slate-300 sm:text-lg">
                No pudimos completar tu solicitud en este momento.
            </p>

            <p class="mx-auto mt-2 max-w-xl text-sm leading-6 text-slate-400 sm:text-base">
                Puedes intentarlo nuevamente en unos minutos o regresar al inicio de TramitaNet.
            </p>

            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a
                    href="{{ url()->current() }}"
                    class="inline-flex items-center justify-center rounded-xl bg-orange-500 px-6 py-3 text-sm font-black text-white shadow-lg transition duration-200 hover:scale-105 hover:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300"
                >
                    Intentar nuevamente
                </a>

                <a
                    href="{{ route('tramitanet.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-blue-400/40 bg-blue-500/10 px-6 py-3 text-sm font-black text-blue-200 transition duration-200 hover:scale-105 hover:border-blue-300 hover:bg-blue-500/20 focus:outline-none focus:ring-2 focus:ring-blue-300"
                >
                    Ir al inicio
                </a>
            </div>

            <div class="mt-10 border-t border-white/10 pt-6">
                <p class="text-sm font-semibold text-slate-400">
                    TramitaNet · Servicios Digitales en Línea Berumen
                </p>
            </div>

        </section>
    </main>

</body>
</html>