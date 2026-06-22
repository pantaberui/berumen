<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entretenimiento Berumen — Acceso</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-card {
            animation: fadeIn 0.6s ease-out;
        }

        .login-bg {
            background-image:
                linear-gradient(rgba(15, 23, 42, 0.35), rgba(15, 23, 42, 0.55)),
                url('{{ asset('images/login-bg.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body class="min-h-screen login-bg flex items-center justify-center relative overflow-hidden px-4">

    <div class="absolute inset-0 bg-blue-950/10 pointer-events-none"></div>

    <div class="login-card relative z-10 w-full max-w-sm">
        <div class="bg-slate-950/75 backdrop-blur-md rounded-2xl shadow-2xl px-6 py-6 border border-white/20">

            <div class="text-center mb-5">
                <div class="inline-block bg-white/75 backdrop-blur-sm rounded-xl px-4 py-2 shadow-md">

                    <h1 class="text-white font-extrabold text-2xl">
                        Acceso al Sistema
                    </h1>

                    <p class="text-white text-sm font-semibold">
                        {{ ucfirst(now()->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY')) }}
                    </p>

                </div>

                <div class="mt-3 h-0.5 bg-gradient-to-r from-transparent via-sky-400 to-transparent"></div>
            </div>

            @if ($errors->any())
                <div class="bg-red-500/25 border border-red-300/60 rounded-xl px-4 py-3 mb-4">
                    <p class="text-red-50 text-sm text-center">
                        ⚠️ {{ $errors->first() }}
                    </p>
                </div>
            @endif

            @if (session('status'))
                <div class="bg-green-500/25 border border-green-300/60 rounded-xl px-4 py-3 mb-4">
                    <p class="text-green-50 text-sm text-center">
                        {{ session('status') }}
                    </p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-white text-sm font-semibold mb-2">
                        Correo electrónico
                    </label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           class="w-full px-4 py-2.5 rounded-lg text-white placeholder-slate-300 border border-white/40 focus:outline-none focus:border-sky-300 focus:ring-2 focus:ring-sky-400/30 transition bg-white/15"
                           placeholder="usuario@berumen.com">
                </div>

                <div class="mb-5">
                    <label class="block text-white text-sm font-semibold mb-2">
                        Contraseña
                    </label>
                    <input type="password"
                           name="password"
                           required
                           class="w-full px-4 py-2.5 rounded-lg text-white placeholder-slate-300 border border-white/40 focus:outline-none focus:border-sky-300 focus:ring-2 focus:ring-sky-400/30 transition bg-white/15"
                           placeholder="••••••••">
                </div>

                <div class="flex items-center mb-5">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox"
                               name="remember"
                               class="rounded border-white/40 text-sky-500">
                        <span class="text-white text-sm font-medium">Recordarme</span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full py-2.5 px-5 rounded-lg font-semibold text-white transition-all duration-200 hover:shadow-lg hover:scale-[1.02] active:scale-95"
                        style="background: linear-gradient(135deg, #1e40af, #0ea5e9);">
                    Iniciar Sesión →
                </button>
            </form>

            <div class="mt-5 text-center">
                <p class="text-white text-xs font-medium">
                    San José de Mojarras, Nayarit · Tel. (311) 352-2645
                </p>
                <p class="text-white text-xs mt-1 opacity-90">
                    © {{ date('Y') }} Entretenimiento Berumen
                </p>
            </div>

        </div>
    </div>

</body>
</html>