<div class="bg-white rounded-2xl shadow border border-gray-200 p-6">
    <h2 class="text-xl font-black text-gray-900 mb-5">
        👤 Información recibida
    </h2>

    @foreach($datosAgrupados as $grupo => $datos)
        @if($grupo !== 'documentos')
            <div class="mb-6">
                <h3 class="text-sm font-bold text-gray-500 uppercase mb-3">
                    {{ ucfirst($grupo) }}
                </h3>

                <div class="grid md:grid-cols-2 gap-4">
                    @foreach($datos as $dato)
                        <div class="border rounded-xl p-4 bg-gray-50">
                            <p class="text-xs text-gray-500 uppercase font-bold">
                                {{ $dato->etiqueta }}
                            </p>

                            <div class="font-bold text-gray-900 mt-1 break-words">
                                @if($dato->es_archivo)
                                    <p>
                                        {{ $dato->nombre_original_archivo ?? 'Documento recibido' }}
                                    </p>

                                    @if($dato->tamano_archivo)
                                        <p class="mt-1 text-xs font-normal text-gray-500">
                                            {{ number_format($dato->tamano_archivo / 1024, 1) }} KB
                                        </p>
                                    @endif

                                    <p class="mt-2 text-sm font-bold text-green-700">
                                        Documento recibido correctamente
                                    </p>

                                    <a href="{{ route(
                                            'admin.tramitanet.solicitudes.documentos.descargar',
                                            [$solicitud, $dato]
                                        ) }}"
                                    class="mt-3 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-bold text-white hover:bg-blue-700">
                                        <span>⬇</span>
                                        Descargar archivo
                                    </a>

                                @elseif($dato->tipo_campo === 'password')
                                    <span id="password-{{ $dato->id }}">********</span>

                                    <button
                                        type="button"
                                        class="ml-3 text-blue-700 text-sm font-bold hover:underline"
                                        onclick="verPassword('{{ route('admin.tramitanet.solicitudes.datos.ver-password', [$solicitud, $dato]) }}', {{ $dato->id }})">
                                        Ver
                                    </button>

                                @elseif($dato->tipo_campo === 'checkbox')
                                    Aceptado

                                @else
                                    {{ $dato->valor ?: 'Sin capturar' }}
                                @endif
                            </div>


                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</div>

<script>
    async function verPassword(url, datoId) {
        const respuesta = await fetch(url);

        if (!respuesta.ok) {
            alert('No se pudo consultar la contraseña. Código: ' + respuesta.status);
            return;
        }

        const data = await respuesta.json();

        document.getElementById(`password-${datoId}`).innerText = data.password;
    }
</script>