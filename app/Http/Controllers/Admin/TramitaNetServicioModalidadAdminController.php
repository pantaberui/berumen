<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatalogoServicio;
use App\Models\CatalogoServicioModalidad;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TramitaNetServicioModalidadAdminController extends Controller
{
    public function store(
        Request $request,
        CatalogoServicio $servicio
    ) {
        $datos = $this->validar($request, $servicio);

        $datos['catalogo_servicio_id'] = $servicio->id;
        $datos['activo'] = $request->boolean('activo');

        CatalogoServicioModalidad::create($datos);

        return redirect()
            ->route('admin.tramitanet.servicios.edit', $servicio)
            ->with('success', 'Modalidad creada correctamente.');
    }

    public function update(
        Request $request,
        CatalogoServicio $servicio,
        CatalogoServicioModalidad $modalidad
    ) {
        abort_unless(
            $modalidad->catalogo_servicio_id === $servicio->id,
            404
        );

        $datos = $this->validar(
            $request,
            $servicio,
            $modalidad
        );

        $datos['activo'] = $request->boolean('activo');

        $modalidad->update($datos);

        return redirect()
            ->route('admin.tramitanet.servicios.edit', $servicio)
            ->with('success', 'Modalidad actualizada correctamente.');
    }

    private function validar(
        Request $request,
        CatalogoServicio $servicio,
        ?CatalogoServicioModalidad $modalidad = null
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
                Rule::unique('catalogo_servicio_modalidades', 'slug')
                    ->where(
                        fn ($query) =>
                            $query->where(
                                'catalogo_servicio_id',
                                $servicio->id
                            )
                    )
                    ->ignore($modalidad?->id),
            ],

            'descripcion' => [
                'nullable',
                'string',
            ],

            'tipo_precio' => [
                'required',
                Rule::in([
                    'fijo',
                    'por_entidad',
                    'variable',
                    'gratuito',
                ]),
            ],

            'precio' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'tiempo_estimado' => [
                'nullable',
                'string',
                'max:255',
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
        ]);
    }
}
