<?php

namespace App\Http\Controllers;

use App\Models\CatalogoInstitucion;
use App\Models\CatalogoServicio;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $instituciones = CatalogoInstitucion::query()
            ->where('activo', true)
            ->orderBy('orden')
            ->get();

        $servicios = CatalogoServicio::query()
            ->where('categoria', 'tramite')
            ->where('activo', true)
            ->orderBy('orden')
            ->get();

        return response()
            ->view('sitemap.index', compact(
                'instituciones',
                'servicios'
            ))
            ->header('Content-Type', 'application/xml');
    }
}
