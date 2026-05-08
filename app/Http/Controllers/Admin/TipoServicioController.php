<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoServicio;
use Illuminate\Http\Request;

class TipoServicioController extends Controller
{
    public function index()
    {
        $servicios = TipoServicio::orderBy('nombre')->paginate(20);
        return view('admin.tipo_servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('admin.tipo_servicios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipo_servicios,nombre',
        ], [
            'nombre.unique' => 'Ya existe un servicio con ese nombre.',
        ]);

        TipoServicio::create([
            'nombre' => strtoupper($request->nombre),
            'activo' => $request->has('activo') ? 1 : 0,
        ]);

        return redirect()->route('admin.tipo-servicios.index')
            ->with('success', 'Servicio registrado correctamente.');
    }

    public function edit(TipoServicio $tipoServicio)
    {
        return view('admin.tipo_servicios.edit', compact('tipoServicio'));
    }

    public function update(Request $request, TipoServicio $tipoServicio)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipo_servicios,nombre,' . $tipoServicio->id,
        ], [
            'nombre.unique' => 'Ya existe un servicio con ese nombre.',
        ]);

        $tipoServicio->update([
            'nombre' => strtoupper($request->nombre),
            'activo' => $request->has('activo') ? 1 : 0,
        ]);

        return redirect()->route('admin.tipo-servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(TipoServicio $tipoServicio)
    {
        $tipoServicio->delete();
        return redirect()->route('admin.tipo-servicios.index')
            ->with('success', 'Servicio eliminado correctamente.');
    }
}
