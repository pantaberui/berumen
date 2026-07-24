<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>resources/views/publico/tramitanet/components/footer.blade.php</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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