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


class TramitaNetController extends Controller
{
    public function index()
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

        return view('publico.tramitanet.index', compact(
            'instituciones',
            'serviciosDestacados'
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
}
