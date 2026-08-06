<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\CatalogoInstitucion;
use App\Models\CatalogoServicio;
use Illuminate\Http\Request;
use App\Models\SolicitudServicio;
use App\Models\SolicitudServicioDato;
use App\Models\HistorialEstatusSolicitud;
use App\Services\TramitaNetService;
use Illuminate\Support\Facades\DB;
use App\Services\Seo\SeoService;



class TramitaNetController extends Controller
{
    public function index(SeoService $seoService)
    {
        $instituciones = CatalogoInstitucion::with([
                'servicios' => fn ($query) => $query
                    ->where('categoria', 'tramite')
                    ->where('activo', true)
                    ->orderBy('orden')
            ])
            ->withCount([
                'servicios' => fn ($query) => $query
                    ->where('categoria', 'tramite')
                    ->where('activo', true)
            ])
            ->where('activo', true)
            ->where('mostrar_en_portada', true)
            ->orderBy('orden')
            ->get();

        $serviciosDestacados = CatalogoServicio::with('institucion')
            ->where('categoria', 'tramite')
            ->where('activo', true)
            ->where('mostrar_en_portada', true)
            ->orderBy('orden')
            ->get();

        $seo = $seoService->home();

        return view('publico.tramitanet.index', compact(
            'instituciones',
            'serviciosDestacados',
            'seo'
        ));
    }

    public function servicio(string $slug)
    {
        $servicio = CatalogoServicio::with([
                'institucion',
                'modalidades.campos.campoMaestro',
                'campos.campoMaestro',
            ])
            ->where('slug', $slug)
            ->where('activo', true)
            ->firstOrFail();

        return view('publico.tramitanet.servicio', compact('servicio'));
    }

     public function consulta()
    {
        return view('publico.tramitanet.consulta');
    }

    public function consultar(Request $request)
    {
        $datos = $request->validate([
            'folio' => [
                'required',
                'string',
                'max:50',
            ],

            'codigo_consulta' => [
                'required',
                'digits:6',
            ],
        ], [
            'folio.required' =>
                'Captura el folio de tu solicitud.',

            'codigo_consulta.required' =>
                'Captura el código de consulta.',

            'codigo_consulta.digits' =>
                'El código de consulta debe contener exactamente 6 dígitos.',
        ]);

        $solicitud = SolicitudServicio::where(
                'folio',
                trim($datos['folio'])
            )
            ->where(
                'codigo_consulta',
                $datos['codigo_consulta']
            )
            ->first();

        if (!$solicitud) {
            return back()
                ->withErrors([
                    'consulta' =>
                        'No se encontró ninguna solicitud con la información proporcionada.',
                ])
                ->withInput();
        }

        /*
        * Guardamos temporalmente en sesión que el ciudadano
        * validó correctamente esta solicitud.
        */
        session()->put(
            "tramitanet.expedientes_autorizados.{$solicitud->folio}",
            true
        );

        return redirect()->route(
            'tramitanet.expediente',
            $solicitud->folio
        );
    }




    public function institucion(string $slug)
    {
        $institucion = CatalogoInstitucion::with([
                'servicios' => fn ($query) => $query
                    ->where('categoria', 'tramite')
                    ->where('activo', true)
                    ->orderBy('orden')
            ])
            ->where('slug', $slug)
            ->where('activo', true)
            ->firstOrFail();

        return view('publico.tramitanet.institucion', compact('institucion'));
    }

    public function modalidad(string $slug, string $modalidad)
    {
        $servicio = CatalogoServicio::with('institucion')
            ->where('slug', $slug)
            ->where('activo', true)
            ->firstOrFail();

        $modalidadServicio = $servicio->modalidades()
            ->with('campos.campoMaestro')
            ->where('slug', $modalidad)
            ->where('activo', true)
            ->firstOrFail();

        return view('publico.tramitanet.modalidad', compact(
            'servicio',
            'modalidadServicio'
        ));
    }

    public function faq()
    {
        return view('publico.tramitanet.faq');
    }
}
