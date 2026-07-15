<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CatalogoServicio;
use App\Models\SolicitudServicio;
use App\Models\SolicitudServicioDato;
use App\Models\HistorialEstatusSolicitud;
use Illuminate\Support\Facades\DB;
use App\Services\TramitaNetService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use App\Services\TramitaNetNotificacionService;
use App\Models\SolicitudServicioDocumento;
use App\Services\TramitaNet\PagoService;
use App\Services\TramitaNet\CaptchaService;
use App\Services\TramitaNet\PrecioService;
use InvalidArgumentException;

class TramitaNetSolicitudController extends Controller
{   
    public function resumen(Request $request, string $slug)
    {
        $servicio = CatalogoServicio::with('institucion')
            ->where('slug', $slug)
            ->where('activo', true)
            ->firstOrFail();

        $modalidad = $servicio->modalidades()
            ->with('campos.campoMaestro')
            ->whereKey($request->modalidad)
            ->where('activo', true)
            ->firstOrFail();

         $camposEntrada = $request->input('campos', []);

        if (isset($camposEntrada['curp'])) {
            $camposEntrada['curp'] = mb_strtoupper(
                preg_replace('/\s+/', '', trim($camposEntrada['curp']))
            );
        }

        $request->merge([
            'campos' => $camposEntrada,
        ]);



        $solicitaCurp = $modalidad->campos->contains(
            fn ($campoServicio) =>
                $campoServicio->campoMaestro->slug === 'curp'
        );

        if ($solicitaCurp) {
            $request->validate([
                'campos.curp' => [
                    'required',
                    'string',
                    'size:18',

                    'regex:/^[A-Z][AEIOU][A-Z]{2}\d{6}[HMX](AS|BC|BS|CC|CL|CM|CS|CH|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|NE|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z0-9]\d$/',

                    function (
                        string $attribute,
                        mixed $value,
                        \Closure $fail
                    ) {
                        $curp = mb_strtoupper((string) $value);

                        $anioCorto = (int) substr($curp, 4, 2);
                        $mes = (int) substr($curp, 6, 2);
                        $dia = (int) substr($curp, 8, 2);

                        /*
                        * En la posición 17:
                        * - número: persona nacida antes del año 2000;
                        * - letra: persona nacida a partir del año 2000.
                        */
                        $diferenciador = substr($curp, 16, 1);

                        $anioCompleto = ctype_digit($diferenciador)
                            ? 1900 + $anioCorto
                            : 2000 + $anioCorto;

                        if (!checkdate($mes, $dia, $anioCompleto)) {
                            $fail(
                                'La fecha de nacimiento contenida en la CURP no es válida.'
                            );

                            return;
                        }

                        $fechaNacimiento = sprintf(
                            '%04d-%02d-%02d',
                            $anioCompleto,
                            $mes,
                            $dia
                        );

                        if ($fechaNacimiento > now()->format('Y-m-d')) {
                            $fail(
                                'La fecha de nacimiento contenida en la CURP no puede ser futura.'
                            );
                        }
                    },
                ],
            ], [
                'campos.curp.required' =>
                    'La CURP es obligatoria.',

                'campos.curp.size' =>
                    'La CURP debe contener exactamente 18 caracteres.',

                'campos.curp.regex' =>
                    'La CURP capturada no tiene un formato válido.',
            ]);
        }





        $entidadCurp = TramitaNetService::obtenerEntidadDesdeCurp(
            $campos['curp'] ?? null
        );

        $request->merge([
            'whatsapp_numero' => preg_replace(
                '/\D+/',
                '',
                (string) $request->input('whatsapp_numero', '')
            ),
        ]);

        $request->validate([
            'whatsapp_codigo_pais' => [
                'required',
                'regex:/^\+[1-9]\d{0,3}$/',
            ],

            'whatsapp_numero' => [
                'required',
                'string',
                'digits_between:7,14',

                function (
                    string $attribute,
                    mixed $value,
                    \Closure $fail
                ) use ($request) {
                    if (
                        $request->input('whatsapp_codigo_pais') === '+52' &&
                        strlen((string) $value) !== 10
                    ) {
                        $fail(
                            'El número de WhatsApp de México debe contener exactamente 10 dígitos.'
                        );
                    }
                },
            ],

            'correo' => [
                'nullable',
                'email',
                'max:255',
            ],
        ], [
            'whatsapp_codigo_pais.required' =>
                'Selecciona el código de país.',

            'whatsapp_codigo_pais.regex' =>
                'El código de país no es válido.',

            'whatsapp_numero.required' =>
                'El número de WhatsApp es obligatorio.',

            'whatsapp_numero.regex' =>
                'El número de WhatsApp debe contener únicamente entre 7 y 14 dígitos.',

            'correo.email' =>
                'El correo electrónico no tiene un formato válido.',
        ]);

        if (!CaptchaService::validar($request->captcha)) {
            return back()
                ->withErrors([
                    'captcha' => 'El código de seguridad no es correcto. Intenta nuevamente.',
                ])
                ->withInput();
        }

        session([
            'tramitanet.captcha_ok' => true,
        ]);

        $campos = collect($request->input('campos', []))
            ->map(function ($valor, $clave) {
                if (!is_string($valor)) {
                    return $valor;
                }

                $valor = trim($valor);

                return in_array($clave, ['curp', 'rfc', 'id_cif'])
                    ? mb_strtoupper($valor)
                    : $valor;
            })
            ->toArray();

        
        $whatsappCodigoPais = $request->input('whatsapp_codigo_pais');

        $whatsappNumero = preg_replace(
            '/\D+/',
            '',
            $request->input('whatsapp_numero', '')
        );

        $correo = $request->input('correo');

        try {
            $precioCalculado = PrecioService::calcular(
                servicio: $servicio,
                modalidad: $modalidad,
                campos: $campos
            );
        } catch (InvalidArgumentException $e) {
            return back()
                ->withErrors([
                    'precio' => $e->getMessage(),
                ])
                ->withInput();
        }


        return view('publico.tramitanet.resumen', compact(
            'servicio',
            'modalidad',
            'campos',
            'whatsappCodigoPais',
            'whatsappNumero',
            'correo',
            'precioCalculado',
            'entidadCurp'
        ));
    }

    public function store(Request $request, string $slug)
    {

        $servicio = CatalogoServicio::with('modalidades.campos.campoMaestro')
            ->where('slug', $slug)
            ->where('activo', true)
            ->firstOrFail();

        $modalidad = $servicio->modalidades()
            ->whereKey($request->modalidad)
            ->where('activo', true)
            ->firstOrFail();
        

        $camposEntrada = $request->input('campos', []);

        if (isset($camposEntrada['curp'])) {
            $camposEntrada['curp'] = mb_strtoupper(
                preg_replace('/\s+/', '', trim($camposEntrada['curp']))
            );
        }

        $request->merge([
            'campos' => $camposEntrada,
        ]);



        $solicitaCurp = $modalidad->campos->contains(
            fn ($campoServicio) =>
                $campoServicio->campoMaestro->slug === 'curp'
        );

        if ($solicitaCurp) {
            $request->validate([
                'campos.curp' => [
                    'required',
                    'string',
                    'size:18',

                    'regex:/^[A-Z][AEIOU][A-Z]{2}\d{6}[HMX](AS|BC|BS|CC|CL|CM|CS|CH|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|NE|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z0-9]\d$/',

                    function (
                        string $attribute,
                        mixed $value,
                        \Closure $fail
                    ) {
                        $curp = mb_strtoupper((string) $value);

                        $anioCorto = (int) substr($curp, 4, 2);
                        $mes = (int) substr($curp, 6, 2);
                        $dia = (int) substr($curp, 8, 2);

                        /*
                        * En la posición 17:
                        * - número: persona nacida antes del año 2000;
                        * - letra: persona nacida a partir del año 2000.
                        */
                        $diferenciador = substr($curp, 16, 1);

                        $anioCompleto = ctype_digit($diferenciador)
                            ? 1900 + $anioCorto
                            : 2000 + $anioCorto;

                        if (!checkdate($mes, $dia, $anioCompleto)) {
                            $fail(
                                'La fecha de nacimiento contenida en la CURP no es válida.'
                            );

                            return;
                        }

                        $fechaNacimiento = sprintf(
                            '%04d-%02d-%02d',
                            $anioCompleto,
                            $mes,
                            $dia
                        );

                        if ($fechaNacimiento > now()->format('Y-m-d')) {
                            $fail(
                                'La fecha de nacimiento contenida en la CURP no puede ser futura.'
                            );
                        }
                    },
                ],
            ], [
                'campos.curp.required' =>
                    'La CURP es obligatoria.',

                'campos.curp.size' =>
                    'La CURP debe contener exactamente 18 caracteres.',

                'campos.curp.regex' =>
                    'La CURP capturada no tiene un formato válido.',
            ]);
        }


        

        $tieneArchivos = $modalidad->campos->contains(
            fn ($campoServicio) =>
                $campoServicio->campoMaestro->tipo_campo === 'file'
        );

        if ($tieneArchivos) {
            if (!CaptchaService::validar($request->captcha)) {
                return redirect()
                    ->route('tramitanet.servicio.modalidad', [
                        $servicio->slug,
                        $modalidad->slug,
                    ])
                    ->withErrors([
                        'captcha' => 'El código de seguridad no es correcto. Intenta nuevamente.',
                    ])
                    ->withInput();
            }
        } elseif (!session('tramitanet.captcha_ok')) {
            return redirect()
                ->route('tramitanet.servicio.modalidad', [
                    $servicio->slug,
                    $modalidad->slug,
                ])
                ->withErrors([
                    'captcha' => 'La verificación de seguridad expiró. Captura nuevamente el código.',
                ])
                ->withInput();
        }
        
        $request->merge([
            'whatsapp_numero' => preg_replace(
                '/\D+/',
                '',
                (string) $request->input('whatsapp_numero', '')
            ),
        ]);

        $request->validate([
            'whatsapp_codigo_pais' => [
                'required',
                'string',
                'regex:/^\+[1-9]\d{0,3}$/',
            ],

            'whatsapp_numero' => [
                'required',
                'string',
                'digits_between:7,14',

                function (
                    string $attribute,
                    mixed $value,
                    \Closure $fail
                ) use ($request) {
                    if (
                        $request->input('whatsapp_codigo_pais') === '+52' &&
                        strlen((string) $value) !== 10
                    ) {
                        $fail(
                            'El número de WhatsApp de México debe contener exactamente 10 dígitos.'
                        );
                    }
                },
            ],

            'correo' => [
                'nullable',
                'email',
                'max:255',
            ],
        ], [
            'whatsapp_codigo_pais.required' =>
                'Selecciona el código de país.',

            'whatsapp_codigo_pais.regex' =>
                'El código de país no es válido.',

            'whatsapp_numero.required' =>
                'El número de WhatsApp es obligatorio.',

            'whatsapp_numero.regex' =>
                'El número de WhatsApp debe contener únicamente entre 7 y 14 dígitos.',

            'correo.email' =>
                'El correo electrónico no tiene un formato válido.',

            'correo.max' =>
                'El correo electrónico no debe exceder los 255 caracteres.',
        ]);

        $whatsappCodigoPais = $request->input('whatsapp_codigo_pais');

        $whatsappNumero = preg_replace(
            '/\D+/',
            '',
            $request->input('whatsapp_numero', '')
        );

        $telefonoWhatsappCompleto =
            $whatsappCodigoPais . $whatsappNumero;
        
        

        $campos = collect($request->input('campos', []))
            ->map(function ($valor, $clave) {
                if (!is_string($valor)) {
                    return $valor;
                }

                $valor = trim($valor);

                return in_array($clave, ['curp', 'rfc'])
                    ? mb_strtoupper($valor)
                    : $valor;
            })
            ->toArray();
        
        try {
            $precioCalculado = PrecioService::calcular(
                servicio: $servicio,
                modalidad: $modalidad,
                campos: $campos
            );
        } catch (InvalidArgumentException $e) {
            return redirect()
                ->route('tramitanet.servicio.modalidad', [
                    $servicio->slug,
                    $modalidad->slug,
                ])
                ->withErrors([
                    'precio' => $e->getMessage(),
                ])
                ->withInput();
        }


        
        foreach ($modalidad->campos as $campoServicio){
            $campo = $campoServicio->campoMaestro;

            if ($campoServicio->requerido) {
                if ($campo->tipo_campo === 'file') {
                    if (!$request->hasFile("campos.{$campo->slug}")) {
                        return redirect()
                            ->route('tramitanet.servicio.modalidad', [$servicio->slug, $modalidad->slug])
                            ->withErrors([$campo->slug => "El campo {$campo->nombre} es obligatorio."])
                            ->withInput();
                    }
                } elseif (empty($campos[$campo->slug])) {
                    return redirect()
                        ->route('tramitanet.servicio.modalidad', [$servicio->slug, $modalidad->slug])
                        ->withErrors([$campo->slug => "El campo {$campo->nombre} es obligatorio."])
                        ->withInput();
                }
            }
        }





        return DB::transaction(function () use (
            $servicio,
            $modalidad,
            $campos,
            $request,
            $telefonoWhatsappCompleto,
            $precioCalculado,
            $tieneArchivos
        ) {
            $folio = TramitaNetService::generarFolio();
            $referenciaPago = TramitaNetService::generarReferenciaPago($folio);

            $curp = $campos['curp'] ?? null;
            $entidad = TramitaNetService::obtenerEntidadDesdeCurp($curp);






            $solicitud = SolicitudServicio::create([
                'folio' => $folio,
                'telefono_whatsapp' => $telefonoWhatsappCompleto,
                'correo' => $request->correo,
                'referencia_pago' => $referenciaPago,
                'catalogo_servicio_id' => $servicio->id,
                'estatus' => 'solicitado',
                'curp' => $curp,
                'entidad_curp_codigo' => $entidad['codigo'] ?? null,
                'entidad_curp_nombre' => $entidad['nombre'] ?? null,
                'catalogo_servicio_modalidad_id' => $modalidad->id,
                'monto_base' => $precioCalculado,
                'comision' => 0,
                'total_pagar' => $precioCalculado,
            ]);

            foreach ($modalidad->campos as $campoServicio) {
                $campo = $campoServicio->campoMaestro;

                $valor = $campos[$campo->slug] ?? null;

                if ($campo->tipo_campo === 'password' && $valor) {
                    $valor = Crypt::encryptString($valor);
                }

                $datos = [
                    'solicitud_servicio_id' => $solicitud->id,
                    'catalogo_campo_id' => $campo->id,
                    'campo' => $campo->slug,
                    'etiqueta' => $campo->nombre,
                    'tipo_campo' => $campo->tipo_campo,
                    'requerido' => $campoServicio->requerido,
                    'valor' => $valor,
                    'es_archivo' => false,
                ];

                if (
                    $campo->tipo_campo === 'file' &&
                    $request->hasFile("campos.{$campo->slug}")
                ) {
                    $archivo = $request->file("campos.{$campo->slug}");

                    $nombreOriginal = $archivo->getClientOriginalName();
                    $nombreSeguro = preg_replace(
                        '/[^A-Za-z0-9._-]/',
                        '_',
                        $nombreOriginal
                    );

                    $ruta = $archivo->storeAs(
                        "tramitanet/solicitudes/{$solicitud->folio}",
                        $nombreSeguro,
                        'public'
                    );

                    $datos['valor'] = null;
                    $datos['es_archivo'] = true;
                    $datos['ruta_archivo'] = $ruta;
                    $datos['nombre_original_archivo'] = $nombreOriginal;
                    $datos['mime_type'] = $archivo->getMimeType();
                    $datos['tamano_archivo'] = $archivo->getSize();
                }

                SolicitudServicioDato::create($datos);

            }
            
            $datosGuardados = SolicitudServicioDato::where(
                'solicitud_servicio_id',
                $solicitud->id
            )->get([
                'campo',
                'valor',
            ]);


            HistorialEstatusSolicitud::create([
                'solicitud_servicio_id' => $solicitud->id,
                'estatus_anterior' => null,
                'estatus_nuevo' => 'solicitado',
                'observacion' => 'Solicitud registrada desde TramitaNet.',
                'user_id' => null,
            ]);

            TramitaNetNotificacionService::nuevaSolicitud($solicitud);

            if (!$tieneArchivos) {
                session()->forget('tramitanet.captcha_ok');
            }

            return redirect()
                ->route('tramitanet.expediente', $solicitud->folio);
            
        });
    }

    public function expediente(string $folio)
    {
         $solicitud = SolicitudServicio::with([
            'servicio.institucion',
            'modalidad',
            'datos.catalogoCampo',
            'historial',
            'documentosGenerados',
            'pagos',
            'notas',
        ])
            ->where('folio', $folio)
            ->firstOrFail();

        $ultimoPago = $solicitud->pagos->first();

        $notasVisibles = $solicitud->notas
            ->where('visible_cliente', true);

        $datosAgrupados = $solicitud->datos
            ->groupBy(function ($dato) {
                return $dato->catalogoCampo->grupo_expediente ?? 'datos';
            });
        
        $estadoActual = $this->obtenerMensajeEstado($solicitud->estatus);

        return view('publico.tramitanet.expediente', compact(
            'solicitud',
            'estadoActual',
            'datosAgrupados',
            'ultimoPago',
            'notasVisibles'
        ));
    }

    private function obtenerMensajeEstado(string $estatus): array
    {
        return match ($estatus) {
            'solicitado' => [
                'titulo' => 'Solicitud recibida',
                'icono' => '🟡',
                'mensaje' => 'Recibimos correctamente tu solicitud.',
                'siguiente_paso' => 'Revisaremos la información proporcionada. Si necesitamos algún dato adicional, nos comunicaremos contigo por WhatsApp o correo electrónico.',
            ],

            'esperando_pago' => [
                'titulo' => 'Pago pendiente',
                'icono' => '🟠',
                'mensaje' => 'Tu solicitud fue registrada',
                'siguiente_paso' => 'Realizar el pago utilizando la referencia mostrada en este expediente.',
            ],

            'pago_en_revision' => [
                'titulo' => 'Pago en revisión',
                'icono' => '🧾',
                'mensaje' => 'Recibimos tu comprobante de pago.',
                'siguiente_paso' => 'Nuestro personal revisará que el pago corresponda al importe y referencia de esta solicitud.',
            ],

            'pago_confirmado' => [
                'titulo' => 'Pago confirmado',
                'icono' => '🟢',
                'mensaje' => 'Hemos confirmado tu pago.',
                'siguiente_paso' => 'Tu trámite comenzará a procesarse en breve.',
            ],

            'en_gestion' => [
                'titulo' => 'Trámite en gestión',
                'icono' => '🔵',
                'mensaje' => 'Nuestro personal ya está realizando las gestiones necesarias ante la institución correspondiente.',
                'siguiente_paso' => 'Te notificaremos cuando el trámite esté concluido.',
            ],

            'entregado' => [
                'titulo' => 'Trámite concluido',
                'icono' => '✅',
                'mensaje' => 'Tu trámite ha sido concluido correctamente.',
                'siguiente_paso' => 'Puedes descargar el documento final desde este expediente.',
            ],

            default => [
                'titulo' => 'Estado desconocido',
                'icono' => 'ℹ️',
                'mensaje' => '',
            ],
        };
    }

    public function descargarDocumentoGenerado(string $folio, SolicitudServicioDocumento $documento)
    {
        $solicitud = SolicitudServicio::where('folio', $folio)->firstOrFail();

        abort_unless($documento->solicitud_servicio_id === $solicitud->id, 404);
        abort_unless($documento->visible_cliente, 403);

        if (!Storage::disk('public')->exists($documento->ruta_archivo)) {
            abort(404, 'Archivo no encontrado.');
        }

        return Storage::disk('public')->download(
            $documento->ruta_archivo,
            $documento->nombre_original_archivo
        );
    }

    public function subirComprobantePago(Request $request, string $folio)
    {
        $solicitud = SolicitudServicio::where('folio', $folio)->firstOrFail();

        $request->validate([
            'comprobante' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'monto_reportado' => 'nullable|numeric|min:0',
            'referencia_reportada' => 'nullable|string|max:50',
        ]);

        PagoService::registrarComprobante(
            $solicitud,
            $request->file('comprobante'),
            $request->only([
                'monto_reportado',
                'referencia_reportada',
            ])
        );

        return back()->with(
            'success',
            'Tu comprobante fue recibido correctamente y será revisado por nuestro personal.'
        );
    }

}
