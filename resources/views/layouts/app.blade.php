<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('input[type="text"], input[type="email"], textarea').forEach(function (campo) {
                campo.addEventListener('input', function () {
                    const pos = this.selectionStart;
                    this.value = this.value.toUpperCase();
                    this.setSelectionRange(pos, pos);
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {

        // Máscara teléfono/celular: (###) ###-##-##
        document.querySelectorAll('input[name="telefono"], input[name="celular"]').forEach(function (campo) {
            campo.setAttribute('maxlength', '16');
            campo.setAttribute('placeholder', '(311) 352-26-45');

            campo.addEventListener('input', function (e) {
                let digits = this.value.replace(/\D/g, '').substring(0, 10);
                let result = '';
                if (digits.length > 0) result = '(' + digits.substring(0, 3);
                if (digits.length >= 4) result += ') ' + digits.substring(3, 6);
                if (digits.length >= 7) result += '-' + digits.substring(6, 8);
                if (digits.length >= 9) result += '-' + digits.substring(8, 10);
                this.value = result;
            });
        });

        // Máscara IP: ###.###.###.###
        document.querySelectorAll('input[name="ip"]').forEach(function (campo) {
                campo.addEventListener('input', function () {
                    let digits = this.value.replace(/[^\d.]/g, '');
                    let partes = digits.split('.');
                    partes = partes.map(p => p.substring(0, 3));
                    partes = partes.slice(0, 4);
                    this.value = partes.join('.');
                });
            });

            // Solo letras, espacios, acentos y punto para nombre
            document.querySelectorAll('input[name="nombre"]').forEach(function (campo) {
                campo.addEventListener('input', function () {
                    this.value = this.value.replace(/[^A-ZÁÉÍÓÚÜÑ\s.]/gi, '').toUpperCase();
                });
            });

            // Solo letras, espacios y acentos para apellidos
            document.querySelectorAll('input[name="apellido_paterno"], input[name="apellido_materno"]').forEach(function (campo) {
                campo.addEventListener('input', function () {
                    this.value = this.value.replace(/[^A-ZÁÉÍÓÚÜÑ\s]/gi, '').toUpperCase();
                });
            });

        });


    </script>

    <body class="font-sans antialiased min-h-screen flex flex-col">
        <div class="flex-1">
            {{-- Navegación --}}
            @include('layouts.navigation')

            {{-- Header --}}
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            {{-- Contenido --}}
            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- Footer --}}
        <footer class="py-4 border-t border-gray-200 text-center text-xs text-gray-400">
            © {{ date('Y') }} Entretenimiento Berumen — Todos los derechos reservados.
            Desarrollado por <span class="text-gray-500 font-medium">EB</span>
        </footer>
    </body>

</html>
