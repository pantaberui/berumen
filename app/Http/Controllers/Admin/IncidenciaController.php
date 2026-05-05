<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incidencia;
use App\Models\Cliente;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    public function index()
    {
        $incidencias = Incidencia::with('cliente', 'usuario')
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(15);
        return view('admin.incidencias.index', compact('incidencias'));
    }

    public function create()
    {
        $clientes = Cliente::where('activo', true)->orderBy('apellido_paterno')->get();
        return view('admin.incidencias.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'  => 'required|exists:clientes,id',
            'titulo'      => 'required|string|max:150',
            'descripcion' => 'required|string',
            'estatus'     => 'required|in:en_espera,en_atencion,atendido',
        ]);

        Incidencia::create([
            'cliente_id'  => $request->cliente_id,
            'user_id'     => auth()->id(),
            'titulo'      => strtoupper($request->titulo),
            'descripcion' => strtoupper($request->descripcion),
            'estatus'     => $request->estatus,
        ]);

        return redirect()->route('admin.incidencias.index')
            ->with('success', 'Incidencia registrada correctamente.');
    }

    public function show(Incidencia $incidencia)
    {
        $incidencia->load('cliente', 'usuario');
        return view('admin.incidencias.show', compact('incidencia'));
    }

    public function edit(Incidencia $incidencia)
    {
        $clientes = Cliente::where('activo', true)->orderBy('apellido_paterno')->get();
        return view('admin.incidencias.edit', compact('incidencia', 'clientes'));
    }

    public function update(Request $request, Incidencia $incidencia)
    {
        $request->validate([
            'cliente_id'     => 'required|exists:clientes,id',
            'titulo'         => 'required|string|max:150',
            'descripcion'    => 'required|string',
            'estatus'        => 'required|in:en_espera,en_atencion,atendido',
            'solucion'       => 'nullable|string',
            'fecha_atencion' => 'nullable|date',
        ]);

        $incidencia->update([
            'cliente_id'     => $request->cliente_id,
            'titulo'         => strtoupper($request->titulo),
            'descripcion'    => strtoupper($request->descripcion),
            'estatus'        => $request->estatus,
            'solucion'       => $request->solucion ? strtoupper($request->solucion) : null,
            'fecha_atencion' => $request->fecha_atencion,
        ]);

        return redirect()->route('admin.incidencias.show', $incidencia)
            ->with('success', 'Incidencia actualizada correctamente.');
    }

    public function destroy(Incidencia $incidencia)
    {
        $incidencia->delete();
        return redirect()->route('admin.incidencias.index')
            ->with('success', 'Incidencia eliminada correctamente.');
    }
}
