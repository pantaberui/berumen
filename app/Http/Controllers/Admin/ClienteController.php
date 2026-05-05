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
            'curp'             => [
                'nullable',
                'size:18',
                'regex:/^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z0-9]\d$/',
                'unique:clientes,curp',
            ],
            'rfc'              => [
                'nullable',
                'size:13',
                'regex:/^[A-Z]{4}\d{6}[A-Z0-9]{3}$/',
                'unique:clientes,rfc',
            ],
            'calle'            => 'nullable|string|max:150',
            'numero_exterior'  => 'nullable|string|max:10',
            'colonia'          => 'nullable|string|max:100',
            'ciudad'           => 'nullable|string|max:100',
            'codigo_postal'    => 'nullable|string|max:10',
            'referencias'      => 'nullable|string',
        ], [
            'curp.size'    => 'La CURP debe tener exactamente 18 caracteres.',
            'curp.regex'   => 'El formato de la CURP no es válido.',
            'curp.unique'  => 'Ya existe un cliente registrado con esta CURP.',
            'rfc.size'     => 'El RFC de persona física debe tener exactamente 13 caracteres.',
            'rfc.regex'    => 'El formato del RFC no es válido.',
            'rfc.unique'   => 'Ya existe un cliente registrado con este RFC.',
        ]);

        // Validar nombre duplicado
        $duplicado = Cliente::whereRaw('UPPER(nombre) = ?', [strtoupper($request->nombre)])
            ->whereRaw('UPPER(apellido_paterno) = ?', [strtoupper($request->apellido_paterno)])
            ->whereRaw('UPPER(apellido_materno) = ?', [strtoupper($request->apellido_materno)])
            ->exists();

        if ($duplicado) {
            return back()->withErrors([
                'nombre' => 'Ya existe un cliente registrado con el mismo nombre completo.'
            ])->withInput();
        }

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
            'curp'             => [
                'nullable',
                'size:18',
                'regex:/^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z0-9]\d$/',
                'unique:clientes,curp,' . $cliente->id,
            ],
            'rfc'              => [
                'nullable',
                'size:13',
                'regex:/^[A-Z]{4}\d{6}[A-Z0-9]{3}$/',
                'unique:clientes,rfc,' . $cliente->id,
            ],
            'calle'            => 'nullable|string|max:150',
            'numero_exterior'  => 'nullable|string|max:10',
            'colonia'          => 'nullable|string|max:100',
            'ciudad'           => 'nullable|string|max:100',
            'codigo_postal'    => 'nullable|string|max:10',
            'referencias'      => 'nullable|string',
        ], [
            'curp.size'    => 'La CURP debe tener exactamente 18 caracteres.',
            'curp.regex'   => 'El formato de la CURP no es válido.',
            'curp.unique'  => 'Ya existe un cliente registrado con esta CURP.',
            'rfc.size'     => 'El RFC de persona física debe tener exactamente 13 caracteres.',
            'rfc.regex'    => 'El formato del RFC no es válido.',
            'rfc.unique'   => 'Ya existe un cliente registrado con este RFC.',
        ]);

        // Validar nombre duplicado excluyendo el cliente actual
        $duplicado = Cliente::whereRaw('UPPER(nombre) = ?', [strtoupper($request->nombre)])
            ->whereRaw('UPPER(apellido_paterno) = ?', [strtoupper($request->apellido_paterno)])
            ->whereRaw('UPPER(apellido_materno) = ?', [strtoupper($request->apellido_materno)])
            ->where('id', '!=', $cliente->id)
            ->exists();

        if ($duplicado) {
            return back()->withErrors([
                'nombre' => 'Ya existe un cliente registrado con el mismo nombre completo.'
            ])->withInput();
        }

        $cliente->update($request->all());

        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }


    public function buscar(Request $request)
    {
        $termino = strtoupper(trim($request->q));

        if (strlen($termino) < 3) {
            return response()->json([]);
        }

        // Dividir en palabras para buscar cada una
        $palabras = array_filter(explode(' ', $termino), fn($p) => strlen($p) >= 2);

        $clientes = Cliente::where(function ($query) use ($palabras) {
            foreach ($palabras as $palabra) {
                $query->where(function ($q) use ($palabra) {
                    $q->whereRaw('UPPER(nombre) LIKE ?', ["%{$palabra}%"])
                    ->orWhereRaw('UPPER(apellido_paterno) LIKE ?', ["%{$palabra}%"])
                    ->orWhereRaw('UPPER(apellido_materno) LIKE ?', ["%{$palabra}%"])
                    ->orWhereRaw('UPPER(curp) LIKE ?', ["%{$palabra}%"])
                    ->orWhereRaw('UPPER(rfc) LIKE ?', ["%{$palabra}%"]);
                });
            }
        })->limit(10)->get();

        return response()->json($clientes);
    }


    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}
