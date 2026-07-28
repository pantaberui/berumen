<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>


    <style>
        /* Paleta de colores del sistema */
        :root {
            --color-primary:     #1e40af;
            --color-primary-dark:#1e3a8a;
            --color-accent:      #0ea5e9;
            --color-bg-light:    #f0f7ff;
            --color-bg-dark:     #1e293b;
            --color-text-dark:   #1e293b;
        }



        /* ==========================================
        IMPRESIÓN OPTIMIZADA DE TICKETS
        ========================================== */
        @media print {
            @page {
                margin: 3mm 4mm;
                size: 80mm auto;
            }
            body {
                margin: 0 !important;
                padding: 0 !important;
                font-size: 11px !important;
                font-family: monospace !important;
            }
        }


        /* Labels de formularios */
        label.block {
            font-weight: 600;
            color: var(--color-text-dark);
            letter-spacing: 0.01em;
        }

        /* Menús desplegables */
        nav .absolute {
            background: #1e293b !important;
            border: 1px solid #334155 !important;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3) !important;
        }

        nav .absolute a {
            color: #cbd5e1 !important;
            transition: all 0.15s ease;
        }

        nav .absolute a:hover {
            background-color: #1e40af !important;
            color: #ffffff !important;
        }

        nav .absolute a.font-semibold {
            color: #60a5fa !important;
            background-color: rgba(30,64,175,0.3) !important;
        }

        /* Inputs y selects */
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        input[type="password"],
        input[type="datetime-local"],
        select,
        textarea {
            border-radius: 0.5rem !important;
            border-color: #cbd5e1 !important;
            background-color: #f8fafc;
            color: #1e293b;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--color-primary) !important;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(30,64,175,0.12) !important;
            outline: none;
        }

        /* Cards / secciones de formulario */
        .bg-white.shadow-sm.rounded-lg {
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03) !important;
        }

        /* Headers de sección */
        .font-semibold.text-xl {
            color: var(--color-text-dark);
            font-size: 1.15rem;
        }

        /* Botones primarios */
        .bg-blue-600 { background-color: var(--color-primary) !important; }
        .hover\:bg-blue-700:hover { background-color: var(--color-primary-dark) !important; }

        /* Filas de tabla alternadas */
        tbody tr:nth-child(odd)  { background-color: #ffffff; }
        tbody tr:nth-child(even) { background-color: #f0f7ff; }
        tbody tr:hover           { background-color: #e0f0ff !important; }

        /* Encabezados de tabla */
        thead th {
            background-color: var(--color-bg-dark) !important;
            color: #ffffff !important;
            letter-spacing: 0.05em;
            font-size: 0.7rem;
        }

        /* Badges de estatus */
        .rounded-full { font-weight: 600; letter-spacing: 0.03em; }

        /* Navbar */
        nav {
            background: linear-gradient(135deg, #1e293b 0%, #1e40af 100%) !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        nav a, nav button, nav .text-gray-500 {
            color: #cbd5e1 !important;
        }

        nav a:hover, nav button:hover {
            color: #ffffff !important;
        }

        /* Footer */
        footer {
            background-color: #1e293b;
            color: #94a3b8 !important;
            border-top: none !important;
        }

        footer span { color: #60a5fa !important; }
    </style>



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
            document
                .querySelectorAll(
                    'input[type="text"], textarea'
                )
                .forEach(function (campo) {
                    if (campo.dataset.preserveCase === 'true') {
                        return;
                    }

                    campo.addEventListener('input', function () {
                        const inicio = this.selectionStart;
                        const fin = this.selectionEnd;

                        this.value = this.value.toUpperCase();

                        this.setSelectionRange(inicio, fin);
                    });
                });
        });

        document.addEventListener('DOMContentLoaded', function () {

            // Máscara teléfono/celular: (###) ###-##-##
            document.querySelectorAll(
                'input[name="telefono"], input[name="celular"]'
            ).forEach(function (campo) {
                campo.setAttribute('maxlength', '16');
                campo.setAttribute('placeholder', '(311) 352-26-45');

                campo.addEventListener('input', function () {
                    const digits = this.value
                        .replace(/\D/g, '')
                        .substring(0, 10);

                    let result = '';

                    if (digits.length > 0) {
                        result = '(' + digits.substring(0, 3);
                    }

                    if (digits.length >= 4) {
                        result += ') ' + digits.substring(3, 6);
                    }

                    if (digits.length >= 7) {
                        result += '-' + digits.substring(6, 8);
                    }

                    if (digits.length >= 9) {
                        result += '-' + digits.substring(8, 10);
                    }

                    this.value = result;
                });
            });

            // Máscara IP: ###.###.###.###
            document.querySelectorAll('input[name="ip"]').forEach(function (campo) {
                campo.addEventListener('input', function () {
                    let valor = this.value.replace(/[^\d.]/g, '');
                    let partes = valor.split('.');

                    partes = partes.map(
                        parte => parte.substring(0, 3)
                    );

                    partes = partes.slice(0, 4);

                    this.value = partes.join('.');
                });
            });

            // Solo letras, espacios, acentos y punto para nombre
            document.querySelectorAll(
                'input[name="nombre"]'
            ).forEach(function (campo) {
                campo.addEventListener('input', function () {
                    this.value = this.value
                        .replace(/[^A-ZÁÉÍÓÚÜÑ\s.]/gi, '')
                        .toUpperCase();
                });
            });

            // Solo letras, espacios y acentos para apellidos
            document.querySelectorAll(
                'input[name="apellido_paterno"], input[name="apellido_materno"]'
            ).forEach(function (campo) {
                campo.addEventListener('input', function () {
                    this.value = this.value
                        .replace(/[^A-ZÁÉÍÓÚÜÑ\s]/gi, '')
                        .toUpperCase();
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
