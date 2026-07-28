<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CostoActaEntidad;
use Illuminate\Http\Request;

class CostoActaEntidadController extends Controller
{
    public function index()
    {
        $costosActas = CostoActaEntidad::query()
            ->orderBy('entidad')
            ->get();

        return view('admin.costos-actas.index', compact('costosActas'));
    }

    public function edit(CostoActaEntidad $costoActaEntidad)
    {
        return view('admin.costos-actas.edit', compact('costoActaEntidad'));
    }

    public function update(
        Request $request,
        CostoActaEntidad $costoActaEntidad
    ) {
        $datos = $request->validate([
            'costo' => [
                'required',
                'numeric',
                'min:0',
                'max:99999999.99',
            ],
            'activo' => [
                'nullable',
                'boolean',
            ],
        ]);

        $datos['activo'] = $request->boolean('activo');

        $costoActaEntidad->update($datos);

        return redirect()
            ->route('admin.costos-actas.index')
            ->with(
                'success',
                'El costo del acta de ' .
                $costoActaEntidad->entidad .
                ' se actualizó correctamente.'
            );
    }
}
