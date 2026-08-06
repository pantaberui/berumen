<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">



    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <meta name="author" content="Entretenimiento Berumen">




    <meta name="theme-color" content="#f97316">
    <meta name="msapplication-TileColor" content="#f97316">
    <meta name="application-name" content="TramitaNet">
    <meta name="apple-mobile-web-app-title" content="TramitaNet">

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('images/branding/favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/branding/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/branding/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/branding/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('images/branding/site.webmanifest') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('publico.tramitanet.components.seo', [
        'seo' => $seo ?? app(\App\Services\Seo\SeoService::class)->default(),
    ])
</head>

<body class="min-h-screen flex flex-col bg-slate-100 text-slate-900 antialiased overflow-x-hidden">

    @include('publico.tramitanet.components.navbar')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('publico.tramitanet.components.footer')

    @stack('scripts')

</body>
</html>
