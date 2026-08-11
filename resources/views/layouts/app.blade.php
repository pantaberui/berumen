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


        /* ==========================================
        MENÚ PRINCIPAL RESPONSIVO DE ESCRITORIO
        ========================================== */

        .desktop-nav-shell {
            min-height: 96px;
            width: 100%;
            align-items: stretch;
        }

        .desktop-nav-logo {
            height: 52px !important;
            width: 190px !important;
            object-fit: contain;
        }

        .desktop-nav-links {
            justify-content: center;
            gap: 4px;
            overflow: visible;
        }

        .desktop-nav-item,
        .desktop-nav-dropdown {
            flex: 0 1 100px;
            width: 100px;
            min-width: 72px;
            max-width: 105px;
            height: 96px;
        }

        .desktop-nav-item {
            display: flex !important;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            padding: 7px 4px !important;
            border-bottom-width: 3px !important;
            text-align: center;
            white-space: normal !important;
            line-height: 1.05rem !important;
        }

        .desktop-nav-button {
            position: relative;
            display: flex;
            width: 100%;
            height: 96px;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            padding: 7px 15px 7px 5px;
            border-bottom: 3px solid transparent;
            color: #cbd5e1;
            text-align: center;
            white-space: normal;
            line-height: 1.05rem;
            transition:
                color 0.15s ease,
                background-color 0.15s ease,
                border-color 0.15s ease;
        }

        .desktop-nav-button:hover,
        .desktop-nav-item:hover {
            background-color: rgba(255, 255, 255, 0.08);
        }

        .desktop-nav-icon {
            display: block;
            flex-shrink: 0;
            font-size: 1.15rem;
            line-height: 1.2rem;
        }

        .desktop-nav-label {
            display: -webkit-box;
            overflow: hidden;
            max-width: 100%;
            min-height: 1.05rem;
            color: inherit;
            font-size: 0.76rem;
            font-weight: 600;
            line-height: 0.95rem;
            text-align: center;
            white-space: normal;
            overflow-wrap: normal;
            word-break: normal;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }

        .desktop-nav-arrow {
            position: absolute;
            top: 50%;
            right: 3px;
            width: 12px;
            height: 12px;
            transform: translateY(-50%);
        }

        .desktop-nav-active {
            color: #60a5fa !important;
            border-bottom-color: #60a5fa;
            background-color: rgba(255, 255, 255, 0.06);
        }

        .desktop-user-menu {
            flex: 0 0 auto;
            max-width: 175px;
            margin-left: 4px;
        }

        .desktop-user-name {
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Monitor común de 18", laptops y resoluciones cercanas a 1366 px */
        @media (max-width: 1536px) and (min-width: 640px) {
            .desktop-nav-logo {
                width: 165px !important;
                height: 48px !important;
            }

            .desktop-nav-links {
                gap: 1px;
                margin-left: 4px !important;
            }

            .desktop-nav-item,
            .desktop-nav-dropdown {
                flex-basis: 85px;
                width: 85px;
                min-width: 65px;
                max-width: 90px;
            }

            .desktop-nav-item,
            .desktop-nav-button {
                padding-left: 3px !important;
                padding-right: 12px !important;
            }

            .desktop-nav-label {
                font-size: 0.69rem;
                line-height: 0.84rem;
            }

            .desktop-nav-icon {
                font-size: 1.05rem;
            }

            .desktop-user-menu {
                max-width: 140px;
            }

            .desktop-user-name {
                max-width: 88px;
            }
        }

        /* Resoluciones especialmente reducidas */
        @media (max-width: 1250px) and (min-width: 640px) {
            .desktop-nav-logo {
                width: 135px !important;
            }

            .desktop-nav-item,
            .desktop-nav-dropdown {
                flex-basis: 76px;
                width: 76px;
                min-width: 60px;
                max-width: 80px;
            }

            .desktop-nav-label {
                font-size: 0.64rem;
                line-height: 0.78rem;
            }

            .desktop-user-menu {
                max-width: 115px;
            }

            .desktop-user-name {
                max-width: 65px;
            }
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

                // Algunos formularios deben conservar mayúsculas y minúsculas
                if (campo.dataset.preserveCase === 'true') {
                    return;
                }

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
