<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contrato;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function index()
    {
        $contratos = Contrato::with('cliente')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.contratos.index', compact('contratos'));
    }

    public function create()
    {
        $clientes = Cliente::where('activo', true)->orderBy('apellido_paterno')->get();
        $numero   = 'CON-' . str_pad(Contrato::count() + 1, 5, '0', STR_PAD_LEFT);
        return view('admin.contratos.create', compact('clientes', 'numero'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'       => 'required|exists:clientes,id',
            'numero_contrato'  => 'required|unique:contratos,numero_contrato',
            'fecha_inicio'     => 'required|date',
            'mensualidad'      => 'required|numeric|min:0',
            'velocidad'        => 'nullable|string|max:50',
            'estatus'          => 'required|in:activo,adeudo,cancelado',
            'observaciones'    => 'nullable|string',
        ]);

        Contrato::create($request->all());

        return redirect()->route('admin.contratos.index')
            ->with('success', 'Contrato registrado correctamente.');
    }

    public function show(Contrato $contrato)
    {
        $contrato->load('cliente', 'pagos');
        return view('admin.contratos.show', compact('contrato'));
    }

    public function edit(Contrato $contrato)
    {
        $clientes = Cliente::where('activo', true)->orderBy('apellido_paterno')->get();
        return view('admin.contratos.edit', compact('contrato', 'clientes'));
    }

    public function update(Request $request, Contrato $contrato)
    {
        $request->validate([
            'cliente_id'      => 'required|exists:clientes,id',
            'numero_contrato' => 'required|unique:contratos,numero_contrato,' . $contrato->id,
            'fecha_inicio'    => 'required|date',
            'mensualidad'     => 'required|numeric|min:0',
            'velocidad'       => 'nullable|string|max:50',
            'estatus'         => 'required|in:activo,adeudo,cancelado',
            'observaciones'   => 'nullable|string',
        ]);

        $contrato->update($request->all());

        return redirect()->route('admin.contratos.index')
            ->with('success', 'Contrato actualizado correctamente.');
    }

    public function destroy(Contrato $contrato)
    {
        $contrato->delete();
        return redirect()->route('admin.contratos.index')
            ->with('success', 'Contrato eliminado correctamente.');
    }
}