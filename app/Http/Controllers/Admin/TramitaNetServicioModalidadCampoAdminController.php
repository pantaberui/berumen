<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatalogoServicio;
use App\Models\CatalogoServicioModalidad;
use App\Models\CatalogoServicioModalidadCampo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TramitaNetServicioModalidadCampoAdminController extends Controller
{
    public function store(
        Request $request,
        CatalogoServicio $servicio,
        CatalogoServicioModalidad $modalidad
    ) {
        $this->validarPertenencia($servicio, $modalidad);

        $datos = $request->validate([
            'catalogo_campo_id' => [
                'required',
                'integer',
                'exists:catalogo_campos,id',

                Rule::unique(
                    'catalogo_servicio_modalidad_campos',
                    'catalogo_campo_id'
                )->where(
                    fn ($query) =>
                        $query->where(
                            'catalogo_servicio_modalidad_id',
                            $modalidad->id
                        )
                ),
            ],

            'requerido' => [
                'nullable',
                'boolean',
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

        $datos['catalogo_servicio_modalidad_id'] = $modalidad->id;
        $datos['requerido'] = $request->boolean('requerido');
        $datos['activo'] = $request->boolean('activo');

        CatalogoServicioModalidadCampo::create($datos);

        return redirect()
            ->route('admin.tramitanet.servicios.edit', $servicio)
            ->with('success', 'Campo agregado a la modalidad correctamente.');
    }

    public function update(
        Request $request,
        CatalogoServicio $servicio,
        CatalogoServicioModalidad $modalidad,
        CatalogoServicioModalidadCampo $campoModalidad
    ) {
        $this->validarPertenencia($servicio, $modalidad);

        abort_unless(
            $campoModalidad->catalogo_servicio_modalidad_id === $modalidad->id,
            404
        );

        $datos = $request->validate([
            'catalogo_campo_id' => [
                'required',
                'integer',
                'exists:catalogo_campos,id',

                Rule::unique(
                    'catalogo_servicio_modalidad_campos',
                    'catalogo_campo_id'
                )
                    ->where(
                        fn ($query) =>
                            $query->where(
                                'catalogo_servicio_modalidad_id',
                                $modalidad->id
                            )
                    )
                    ->ignore($campoModalidad->id),
            ],

            'requerido' => [
                'nullable',
                'boolean',
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

        $datos['requerido'] = $request->boolean('requerido');
        $datos['activo'] = $request->boolean('activo');

        $campoModalidad->update($datos);

        return redirect()
            ->route('admin.tramitanet.servicios.edit', $servicio)
            ->with('success', 'Campo de la modalidad actualizado correctamente.');
    }

    private function validarPertenencia(
        CatalogoServicio $servicio,
        CatalogoServicioModalidad $modalidad
    ): void {
        abort_unless(
            $modalidad->catalogo_servicio_id === $servicio->id,
            404
        );
    }
}
