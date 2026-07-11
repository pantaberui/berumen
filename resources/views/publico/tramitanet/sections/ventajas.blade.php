<section class="bg-slate-950 text-white py-16">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-12">
            <p class="text-orange-400 font-bold uppercase tracking-widest text-sm">
                ¿Por qué elegir TramitaNet?
            </p>

            <h2 class="text-3xl md:text-4xl font-extrabold mt-2">
                Menos vueltas, más claridad
            </h2>

            <p class="text-slate-300 mt-3 max-w-2xl mx-auto">
                Te ayudamos a obtener documentos y servicios digitales con acompañamiento humano,
                seguimiento por folio y comunicación clara durante todo el proceso.
            </p>
        </div>

        <div class="grid md:grid-cols-4 gap-6">
            @foreach([
                ['🔒', 'Datos protegidos', 'Tu información se usa únicamente para gestionar el servicio solicitado.'],
                ['📱', 'Mobile First', 'Puedes solicitar y consultar desde tu celular de forma sencilla.'],
                ['💬', 'Atención personalizada', 'Si surge un caso especial, una persona revisará tu solicitud.'],
                ['🔎', 'Seguimiento por folio', 'Consulta el estado de tu trámite en cualquier momento.'],
            ] as [$icono, $titulo, $texto])
                <div class="bg-white/10 border border-white/10 rounded-2xl p-6">
                    <div class="text-3xl mb-4">{{ $icono }}</div>
                    <h3 class="font-extrabold text-lg">{{ $titulo }}</h3>
                    <p class="text-slate-300 text-sm mt-2">{{ $texto }}</p>
                </div>
            @endforeach
        </div>

    </div>
</section>