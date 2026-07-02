<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoTramite;
use Illuminate\Http\Request;

class TipoTramiteController extends Controller
{
    public function index()
    {
        $tramites = TipoTramite::orderBy('nombre')->paginate(20);
        return view('admin.tipo_tramites.index', compact('tramites'));
    }

    public function create()
    {
        return view('admin.tipo_tramites.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'          => 'required|string|max:200|unique:tipo_tramites,nombre',
            'precio_sugerido' => 'nullable|numeric|min:0',
        ], [
            'nombre.unique' => 'Ya existe un trámite con ese nombre.',
        ]);

        TipoTramite::create([
            'nombre'          => strtoupper($request->nombre),
            'tipo'            => $request->tipo ? strtoupper($request->tipo) : null,
            'precio_sugerido' => $request->precio_sugerido ?: null,
            'requisitos'      => $request->requisitos ?: null,
            'activo'          => $request->has('activo') ? 1 : 0,
        ]);

        return redirect()->route('admin.tipo-tramites.index')
            ->with('success', 'Tipo de trámite registrado correctamente.');
    }

    public function edit(TipoTramite $tipoTramite)
    {
        return view('admin.tipo_tramites.edit', compact('tipoTramite'));
    }

    public function update(Request $request, TipoTramite $tipoTramite)
    {
        $request->validate([
            'nombre'          => 'required|string|max:200|unique:tipo_tramites,nombre,' . $tipoTramite->id,
            'precio_sugerido' => 'nullable|numeric|min:0',
        ]);

        $tipoTramite->update([
            'nombre'          => strtoupper($request->nombre),
            'tipo'            => $request->tipo ? strtoupper($request->tipo) : null,
            'precio_sugerido' => $request->precio_sugerido ?: null,
            'requisitos'      => $request->requisitos ?: null,
            'activo'          => $request->has('activo') ? 1 : 0,
        ]);

        return redirect()->route('admin.tipo-tramites.index')
            ->with('success', 'Tipo de trámite actualizado correctamente.');
    }

    public function destroy(TipoTramite $tipoTramite)
    {
        $tipoTramite->delete();
        return redirect()->route('admin.tipo-tramites.index')
            ->with('success', 'Tipo de trámite eliminado correctamente.');
    }
}
