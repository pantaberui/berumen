<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CatalogoInstitucion;
use App\Models\CatalogoServicio;
use App\Models\CatalogoServicioModalidad;
use App\Services\Seo\SeoService;

class TramitaNetServicioController extends Controller
{
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
            ->where('slug', $modalidad)
            ->where('activo', true)
            ->firstOrFail();

        return view('publico.tramitanet.modalidad', compact(
            'servicio',
            'modalidadServicio'
        ));
    }


    public function servicio(string $slug, SeoService $seoService)
    {


        $servicio = CatalogoServicio::with([
                'institucion',
                'modalidades.campos.campoMaestro',
            ])
            ->where('slug', $slug)
            ->where('activo', true)
            ->firstOrFail();

        $seo = $seoService->servicio($servicio);

        return view(
            'publico.tramitanet.servicio',
            compact(
                'servicio',
                'seo'
            )
        );
    }

}
