<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatalogoInstitucion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TramitaNetInstitucionAdminController extends Controller
{
    public function index()
    {
        $instituciones = CatalogoInstitucion::query()
            ->withCount('servicios')
            ->orderBy('orden')
            ->orderBy('nombre')
            ->paginate(20);

        return view(
            'admin.tramitanet.instituciones.index',
            compact('instituciones')
        );
    }

    public function create()
    {
        return view('admin.tramitanet.instituciones.create');
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);

        if ($request->hasFile('logo')) {
            $archivo = $request->file('logo');

            $nombreLogo = $request->slug . '.' . $archivo->getClientOriginalExtension();

            $archivo->move(
                public_path('images/instituciones'),
                $nombreLogo
            );

            $datos['logo'] = $nombreLogo;
        }

        $datos['activo'] = $request->boolean('activo');
        $datos['mostrar_en_portada'] = $request->boolean('mostrar_en_portada');

        CatalogoInstitucion::create($datos);

        return redirect()
            ->route('admin.tramitanet.instituciones.index')
            ->with('success', 'Institución creada correctamente.');
    }

    public function edit(CatalogoInstitucion $institucion)
    {
        return view(
            'admin.tramitanet.instituciones.edit',
            compact('institucion')
        );
    }

    public function update(
        Request $request,
        CatalogoInstitucion $institucion
    ) {
        $datos = $this->validar($request, $institucion);

        if ($request->hasFile('logo')) {
            $archivo = $request->file('logo');

            $nombreLogo = $request->slug . '.' . $archivo->getClientOriginalExtension();

            $archivo->move(
                public_path('images/instituciones'),
                $nombreLogo
            );

            $datos['logo'] = $nombreLogo;
        } else {
            unset($datos['logo']);
        }

        $datos['activo'] = $request->boolean('activo');
        $datos['mostrar_en_portada'] = $request->boolean('mostrar_en_portada');

        $institucion->update($datos);

        return redirect()
            ->route('admin.tramitanet.instituciones.index')
            ->with('success', 'Institución actualizada correctamente.');
    }

    private function validar(
        Request $request,
        ?CatalogoInstitucion $institucion = null
    ): array {
        return $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('catalogo_instituciones', 'slug')
                    ->ignore($institucion?->id),
            ],

            'descripcion' => [
                'nullable',
                'string',
            ],

            'logo' => [
                'nullable',
                'image',
                'mimes:png,jpg,jpeg,webp',
                'max:2048',
            ],

            'icono' => [
                'nullable',
                'string',
                'max:100',
            ],

            'color_principal' => [
                'nullable',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],

            'color_secundario' => [
                'nullable',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],

            'orden' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'activo' => [
                'nullable',
                'boolean',
            ],

            'mostrar_en_portada' => [
                'nullable',
                'boolean',
            ],
        ]);
    }
}
