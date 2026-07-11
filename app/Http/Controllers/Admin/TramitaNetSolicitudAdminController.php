<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SolicitudServicio;
use Illuminate\Http\Request;
use App\Models\HistorialEstatusSolicitud;
use App\Models\SolicitudServicioNota;
use App\Models\SolicitudServicioDato;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use App\Services\TramitaNet\ProximaAccionService;
use App\Models\SolicitudServicioDocumento;
use App\Support\TramitaNet\EstadosSolicitud;
use App\Services\TramitaNet\CambioEstadoService;
use App\Models\SolicitudServicioPago;
use App\Services\TramitaNet\PagoService;


class TramitaNetSolicitudAdminController extends Controller
{
    public function index(Request $request)
    {   

        $query = SolicitudServicio::with([
            'servicio.institucion',
            'modalidad',
            'datos',
        ]);

        if ($request->filled('buscar')) {
            $buscar = trim($request->buscar);
            $query->where(function ($q) use ($buscar) {
                $q->where('folio', 'like', "%{$buscar}%")
                ->orWhereHas('datos', function ($q2) use ($buscar) {
                        $q2->where('valor', 'like', "%{$buscar}%");
                });
            });

        }

        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }

        $estatuses = EstadosSolicitud::labels();

        $solicitudes = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $conteos = [
            'solicitado' => SolicitudServicio::where('estatus', 'solicitado')->count(),
            'esperando_pago' => SolicitudServicio::where('estatus', 'esperando_pago')->count(),
            'pago_confirmado' => SolicitudServicio::where('estatus', 'pago_confirmado')->count(),
            'en_gestion' => SolicitudServicio::where('estatus', 'en_gestion')->count(),
            'entregado' => SolicitudServicio::where('estatus', 'entregado')->count(),
        ];

        return view('admin.tramitanet.solicitudes.index', compact(
            'solicitudes',
            'estatuses',
            'conteos'
        ));
    }

    public function show(SolicitudServicio $solicitud)
    {
        $solicitud->load([
            'servicio.institucion',
            'modalidad',
            'datos.catalogoCampo',
            'historial',
            'notas',
            'documentosGenerados',
            'pagos',
        ]);

        $ultimoPago = $solicitud->pagos->first();

        $estatuses = EstadosSolicitud::labels();

        $datosAgrupados = $solicitud->datos
            ->groupBy(fn ($dato) => $dato->catalogoCampo->grupo_expediente ?? 'datos');
        
        $proximaAccion = ProximaAccionService::obtener($solicitud);

        return view('admin.tramitanet.solicitudes.show', compact(
            'solicitud',
            'datosAgrupados',
            'estatuses',
            'proximaAccion',
            'ultimoPago'
        ));
    }

    public function actualizarEstatus(Request $request, SolicitudServicio $solicitud)
    {
        $request->validate([
            'estatus' => 'required|in:solicitado,esperando_pago,pago_en_revision,pago_confirmado,en_gestion,informacion_requerida,entregado,cancelado,rechazado',
            'observacion' => 'nullable|string|max:1000',
        ]);

        try {
            CambioEstadoService::ejecutar(
                solicitud: $solicitud,
                nuevoEstado: $request->estatus,
                observacion: $request->observacion,
                userId: auth()->id(),
                tipoNota: 'estatus'
            );
        } catch (\InvalidArgumentException $e) {
            return back()->with('info', $e->getMessage());
        }

        return back()->with('success', 'Estatus actualizado correctamente.');
    }

    public function guardarNota(Request $request, SolicitudServicio $solicitud)
    {
        $request->validate([
            'nota' => 'required|string|max:2000',
            'tipo' => 'nullable|string|max:50',
            'visible_cliente' => 'nullable|boolean',
        ]);

        SolicitudServicioNota::create([
            'solicitud_servicio_id' => $solicitud->id,
            'user_id' => auth()->id(),
            'nota' => $request->nota,
            'tipo' => $request->tipo ?? 'nota',
            'visible_cliente' => $request->boolean('visible_cliente'),
        ]);

        return back()->with('success', 'Nota agregada correctamente.');
    }

    public function descargarDocumento(SolicitudServicio $solicitud, SolicitudServicioDato $dato)
    {
        abort_unless($dato->solicitud_servicio_id === $solicitud->id, 404);
        abort_unless($dato->es_archivo && $dato->ruta_archivo, 404);

        if (!Storage::disk('public')->exists($dato->ruta_archivo)) {
            abort(404, 'Archivo no encontrado.');
        }

        return Storage::disk('public')->download(
            $dato->ruta_archivo,
            $dato->nombre_original_archivo
        );
    }

    public function verPassword(SolicitudServicio $solicitud, SolicitudServicioDato $dato)
    {
        abort_unless($dato->solicitud_servicio_id === $solicitud->id, 404);
        abort_unless($dato->tipo_campo === 'password', 404);
        abort_unless(!empty($dato->valor), 404);

        SolicitudServicioNota::create([
            'solicitud_servicio_id' => $solicitud->id,
            'user_id' => auth()->id(),
            'tipo' => 'credencial',
            'nota' => 'Se consultó una credencial protegida del expediente.',
            'visible_cliente' => false,
        ]);

        return response()->json([
            'password' => Crypt::decryptString($dato->valor),
        ]);
    }

    public function subirDocumentoGenerado(Request $request, SolicitudServicio $solicitud)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|string|max:50',
            'documento' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'visible_cliente' => 'nullable|boolean',
            'marcar_entregado' => 'nullable|boolean',
        ]);

        $archivo = $request->file('documento');

        $ruta = $archivo->store(
            "tramitanet/documentos-generados/{$solicitud->folio}",
            'public'
        );

        SolicitudServicioDocumento::create([
            'solicitud_servicio_id' => $solicitud->id,
            'user_id' => auth()->id(),
            'tipo' => $request->tipo,
            'titulo' => $request->titulo,
            'ruta_archivo' => $ruta,
            'nombre_original_archivo' => $archivo->getClientOriginalName(),
            'mime_type' => $archivo->getMimeType(),
            'tamano_archivo' => $archivo->getSize(),
            'visible_cliente' => $request->boolean('visible_cliente'),
        ]);

        // Registrar en bitácora
        SolicitudServicioNota::create([
            'solicitud_servicio_id' => $solicitud->id,
            'user_id' => auth()->id(),
            'tipo' => 'documento',
            'nota' => 'Se agregó un documento generado al expediente.',
            'visible_cliente' => false,
        ]);

        if ($request->boolean('marcar_entregado')) {
        try {
            CambioEstadoService::ejecutar(
                solicitud: $solicitud,
                nuevoEstado: EstadosSolicitud::ENTREGADO,
                observacion: 'Trámite concluido y documento entregado al ciudadano.',
                userId: auth()->id(),
                tipoNota: 'entrega'
            );
        } catch (\InvalidArgumentException $e) {
            return back()
                ->withInput()
                ->with('info', $e->getMessage());
        }
    }

        return back()->with('success', 'Documento generado agregado correctamente.');
    }

    public function validarPago(SolicitudServicioPago $pago)
    {
        PagoService::validarPago($pago);

        return back()->with(
            'success',
            'Pago validado correctamente.'
        );
    }

    public function rechazarPago(
        Request $request,
        SolicitudServicioPago $pago
    )
    {
        $request->validate([
            'observacion' => 'required|string|max:1000',
        ]);

        PagoService::rechazarPago(
            $pago,
            $request->observacion
        );

        return back()->with(
            'success',
            'El comprobante fue rechazado.'
        );
    }

    public function verPago(SolicitudServicioPago $pago)
    {
        abort_unless(
            Storage::disk('public')->exists($pago->ruta_archivo),
            404
        );

        return response()->file(
            Storage::disk('public')->path($pago->ruta_archivo)
        );
    }

    public function descargarPago(SolicitudServicioPago $pago)
    {
        abort_unless(
            Storage::disk('public')->exists($pago->ruta_archivo),
            404
        );

        return Storage::disk('public')->download(
            $pago->ruta_archivo,
            $pago->nombre_original_archivo
        );
    }

}
