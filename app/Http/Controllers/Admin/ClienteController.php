<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::orderBy('apellido_paterno')->paginate(15);
        return view('admin.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('admin.clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'           => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'telefono'         => 'nullable|string|max:15',
            'celular'          => 'nullable|string|max:15',
            'email'            => 'nullable|email|max:100',
            'curp'             => 'nullable|string|max:18',
            'rfc'              => 'nullable|string|max:13',
            'calle'            => 'nullable|string|max:150',
            'numero_exterior'  => 'nullable|string|max:10',
            'colonia'          => 'nullable|string|max:100',
            'ciudad'           => 'nullable|string|max:100',
            'codigo_postal'    => 'nullable|string|max:10',
            'referencias'      => 'nullable|string',
        ]);

        Cliente::create($request->all());

        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente registrado correctamente.');
    }

    public function show(Cliente $cliente)
    {
        $cliente->load('contratos', 'incidencias');
        return view('admin.clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre'           => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'telefono'         => 'nullable|string|max:15',
            'celular'          => 'nullable|string|max:15',
            'email'            => 'nullable|email|max:100',
            'curp'             => 'nullable|string|max:18',
            'rfc'              => 'nullable|string|max:13',
            'calle'            => 'nullable|string|max:150',
            'numero_exterior'  => 'nullable|string|max:10',
            'colonia'          => 'nullable|string|max:100',
            'ciudad'           => 'nullable|string|max:100',
            'codigo_postal'    => 'nullable|string|max:10',
            'referencias'      => 'nullable|string',
        ]);

        $cliente->update($request->all());

        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}