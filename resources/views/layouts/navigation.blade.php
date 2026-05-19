<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                        <img src="{{ asset('images/logo_hor.png') }}"
                            alt="Entretenimiento Berumen"
                            style="height: 52px; width: 200px; background: white; padding: 2px 2px; border-radius: 8px; border: 2px solid rgba(255,255,255,0.3);">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('admin.clientes.index')" :active="request()->routeIs('admin.clientes.*')">
                        Clientes
                    </x-nav-link>

                    {{-- Menú Internet --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                                class="inline-flex items-center gap-1 px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none">
                            Internet
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition
                            class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-100 z-50">
                            <a href="{{ route('admin.contratos.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.contratos.*') ? 'font-semibold text-indigo-600' : '' }}">
                                Contratos
                            </a>
                            <a href="{{ route('admin.pagos.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.pagos.*') ? 'font-semibold text-indigo-600' : '' }}">
                                Pagos
                            </a>
                            <a href="{{ route('admin.incidencias.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.incidencias.*') ? 'font-semibold text-indigo-600' : '' }}">
                                Incidencias
                            </a>
                            <a href="{{ route('admin.pagos.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.pagos.index') ? 'font-semibold text-indigo-600' : '' }}">
                                Consulta Pagos Internet
                            </a>
                        </div>
                    </div>

                    {{-- Menú Pago de Servicios --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                                class="inline-flex items-center gap-1 px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none">
                            Trámites y Pago de Servicios
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition
                            class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-100 z-50">
                            <a href="{{ route('admin.tipo-servicios.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.tipo-servicios.*') ? 'font-semibold text-indigo-600' : '' }}">
                                Tipos de Servicio
                            </a>
                            <a href="{{ route('admin.pagos-servicios.create') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.pagos-servicios.create') ? 'font-semibold text-indigo-600' : '' }}">
                                Registrar Pago
                            </a>
                            <a href="{{ route('admin.pagos-servicios.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.pagos-servicios.index') ? 'font-semibold text-indigo-600' : '' }}">
                                Consultar Pagos
                            </a>

                            <a href="{{ route('admin.tramites.create') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.tramites.create') ? 'font-semibold text-indigo-600' : '' }}">
                                Registrar Trámite
                            </a>
                            <a href="{{ route('admin.tramites.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.tramites.index') ? 'font-semibold text-indigo-600' : '' }}">
                                Consultar Trámites
                            </a>
                            @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.tipo-tramites.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.tipo-tramites.*') ? 'font-semibold text-indigo-600' : '' }}">
                                Tipos de Trámite
                            </a>
                            @endif

                        </div>

                    </div>

                    {{-- Fichas WiFi  Netplus --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                                class="inline-flex items-center gap-1 px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none">
                            Fichas WiFi Netplus
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition
                            class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-100 z-50">
                            <a href="{{ route('admin.fichas-wifi.create') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.fichas-wifi.*') ? 'font-semibold text-indigo-600' : '' }}">
                                Vender Ficha
                            </a>
                            @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.codigos-netplus.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.codigos-netplus.*') ? 'font-semibold text-indigo-600' : '' }}">
                                Gestión de Códigos
                            </a>
                            @endif

                            @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.codigos-netplus.reporte') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.codigos-netplus.reporte') ? 'font-semibold text-indigo-600' : '' }}">
                                Reporte de Ventas
                            </a>
                            @endif
                        </div>

                    </div>

                    {{-- Ventas --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                                class="inline-flex items-center gap-1 px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none">
                            Ventas
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition
                            class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-100 z-50">
                            <a href="{{ route('admin.ventas.create') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.ventas.create') ? 'font-semibold text-indigo-600' : '' }}">
                                Nueva Venta
                            </a>
                            <a href="{{ route('admin.ventas.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.ventas.index') ? 'font-semibold text-indigo-600' : '' }}">
                                Consultar Ventas
                            </a>
                            @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.productos.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.productos.*') ? 'font-semibold text-indigo-600' : '' }}">
                                Catálogo
                            </a>
                            <a href="{{ route('admin.compras.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.compras.*') ? 'font-semibold text-indigo-600' : '' }}">
                                Compras
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- Control de Tiempos --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                                class="inline-flex items-center gap-1 px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none">
                            Control Tiempos
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition
                            class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-100 z-50">
                            <a href="{{ route('admin.control-tiempos.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.control-tiempos.index') ? 'font-semibold text-indigo-600' : '' }}">
                                Dashboard Equipos
                            </a>
                            <a href="{{ route('admin.control-tiempos.index') }}" target="_blank"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                Dashboard Equipos ↗ (nueva pestaña)
                            </a>

                            <a href="{{ route('admin.control-tiempos.reporte') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.control-tiempos.reporte') ? 'font-semibold text-indigo-600' : '' }}">
                                Reporte
                            </a>
                        </div>
                    </div>



                </div>


            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 1114 0H5z" clip-rule="evenodd"/>
                                </svg>
                                <div>{{ Auth::user()->name }} {{ Auth::user()->apellido_paterno }}</div>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.usuarios.index') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('admin.usuarios.*') ? 'font-semibold text-indigo-600' : '' }}">
                            Usuarios
                        </a>
                        @endif

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1" style="background: #1e293b;">
            <x-responsive-nav-link :href="route('admin.dashboard')"
                :active="request()->routeIs('admin.dashboard')"
                style="color: #cbd5e1;">
                Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.clientes.index')"
                :active="request()->routeIs('admin.clientes.*')"
                style="color: #cbd5e1;">
                Clientes
            </x-responsive-nav-link>

            {{-- Internet --}}
            <div style="padding: 0.5rem 1rem; color: #60a5fa; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em;">
                INTERNET
            </div>
            <x-responsive-nav-link :href="route('admin.contratos.index')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Contratos
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.pagos.index')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Pagos
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.incidencias.index')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Incidencias
            </x-responsive-nav-link>

            {{-- Pago de Servicios --}}
            <div style="padding: 0.5rem 1rem; color: #60a5fa; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em;">
                PAGO DE SERVICIOS
            </div>
            <x-responsive-nav-link :href="route('admin.pagos-servicios.create')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Registrar Pago
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.pagos-servicios.index')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Consultar Pagos
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.tramites.create')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Registrar Trámite
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.tramites.index')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Consultar Trámites
            </x-responsive-nav-link>
            @if(auth()->user()->hasRole('admin'))
            <x-responsive-nav-link :href="route('admin.tipo-servicios.index')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Tipos de Servicio
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.tipo-tramites.index')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Tipos de Trámite
            </x-responsive-nav-link>
            @endif

            {{-- Fichas WiFi --}}
            <div style="padding: 0.5rem 1rem; color: #60a5fa; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em;">
                FICHAS WIFI
            </div>
            <x-responsive-nav-link :href="route('admin.fichas-wifi.create')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Vender Ficha
            </x-responsive-nav-link>
            @if(auth()->user()->hasRole('admin'))
            <x-responsive-nav-link :href="route('admin.codigos-netplus.index')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Gestión de Códigos
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.codigos-netplus.reporte')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Reporte de Ventas
            </x-responsive-nav-link>
            @endif

            {{-- Ventas --}}
            <div style="padding: 0.5rem 1rem; color: #60a5fa; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em;">
                VENTAS
            </div>
            <x-responsive-nav-link :href="route('admin.ventas.create')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Nueva Venta
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.ventas.index')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Consultar Ventas
            </x-responsive-nav-link>
            @if(auth()->user()->hasRole('admin'))
            <x-responsive-nav-link :href="route('admin.productos.index')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Catálogo
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.compras.index')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Compras
            </x-responsive-nav-link>
            @endif

            {{-- Control Tiempos --}}
            <div style="padding: 0.5rem 1rem; color: #60a5fa; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em;">
                CONTROL TIEMPOS
            </div>
            <x-responsive-nav-link :href="route('admin.control-tiempos.index')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Dashboard Equipos
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.control-tiempos.reporte')" style="color: #cbd5e1; padding-left: 1.5rem;">
                Reporte
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-700" style="background: #1e293b;">
            <div class="px-4">
                <div class="font-medium text-base text-white">
                    {{ Auth::user()->name }} {{ Auth::user()->apellido_paterno }}
                </div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" style="color: #cbd5e1;">
                    Perfil
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        style="color: #f87171;">
                        Cerrar Sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
