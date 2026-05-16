<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tramite;
use App\Models\TipoTramite;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;

class TramiteController extends Controller
{
    public function index(Request $request)
    {
        $query = Tramite::with('tipoTramite', 'cajero', 'cliente');

        $fechaDesde = $request->get('fecha_desde', now()->format('Y-m-d'));
        $fechaHasta = $request->get('fecha_hasta', now()->format('Y-m-d'));

        $query->whereDate('fecha_hora_cobro', '>=', $fechaDesde)
              ->whereDate('fecha_hora_cobro', '<=', $fechaHasta);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('tipo_tramite_id')) {
            $query->where('tipo_tramite_id', $request->tipo_tramite_id);
        }

        $totalAcumulado = $query->sum('subtotal');
        $tramites       = $query->orderBy('fecha_hora_cobro', 'desc')->paginate(15)->withQueryString();
        $tiposTramite   = TipoTramite::where('activo', true)->orderBy('nombre')->get();
        $usuarios       = User::orderBy('name')->get();
        $busqueda       = $request->q;

        return view('admin.tramites.index', compact(
            'tramites', 'tiposTramite', 'usuarios',
            'fechaDesde', 'fechaHasta', 'totalAcumulado', 'busqueda'
        ));
    }

    public function create()
    {
        $tiposTramite = TipoTramite::where('activo', true)->orderBy('nombre')->get();
        return view('admin.tramites.create', compact('tiposTramite'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_tramite_id' => 'required|exists:tipo_tramites,id',
            'cantidad'        => 'required|integer|min:1',
            'importe'         => 'required|numeric|min:0',
            'observaciones'   => 'nullable|string',
        ]);

        $subtotal = $request->importe * $request->cantidad;

        $tramite = Tramite::create([
            'tipo_tramite_id' => $request->tipo_tramite_id,
            'user_id'         => auth()->id(),
            'cliente_id'      => $request->cliente_id ?: null,
            'cliente_nombre'  => $request->cliente_nombre ?: 'PÚBLICO EN GENERAL',
            'cantidad'        => $request->cantidad,
            'importe'         => $request->importe,
            'subtotal'        => $subtotal,
            'observaciones'   => $request->observaciones,
            'fecha_hora_cobro'=> now(),
            'estatus'         => 'cobrado',
        ]);

        // Si solicitó ticket redirigir al show, sino al index
        if ($request->has('imprimir')) {
            return redirect()->route('admin.tramites.show', $tramite)
                ->with('success', 'Trámite registrado correctamente.');
        }

        return redirect()->route('admin.tramites.index')
            ->with('success', 'Trámite registrado correctamente.');
    }

    public function show(Tramite $tramite)
    {
        $tramite->load('tipoTramite', 'cajero', 'cliente', 'canceladoPor');
        return view('admin.tramites.show', compact('tramite'));
    }

    public function edit(Tramite $tramite)
    {
        $tiposTramite = TipoTramite::where('activo', true)->orderBy('nombre')->get();
        return view('admin.tramites.edit', compact('tramite', 'tiposTramite'));
    }

    public function update(Request $request, Tramite $tramite)
    {
        $request->validate([
            'cantidad'      => 'required|integer|min:1',
            'importe'       => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
            'estatus'       => 'required|in:cobrado,cancelado',
        ]);

        $data = [
            'cantidad'      => $request->cantidad,
            'importe'       => $request->importe,
            'subtotal'      => $request->importe * $request->cantidad,
            'observaciones' => $request->observaciones,
        ];

        if (auth()->user()->hasRole('admin') &&
            $request->estatus === 'cancelado' &&
            $tramite->estatus !== 'cancelado') {
            $data['estatus']                  = 'cancelado';
            $data['fecha_hora_cancelacion']   = now();
            $data['cancelado_por']            = auth()->id();
        }

        $tramite->update($data);

        return redirect()->route('admin.tramites.show', $tramite)
            ->with('success', 'Trámite actualizado correctamente.');
    }

    public function buscarCliente(Request $request)
    {
        $termino = strtoupper(trim($request->q));
        if (strlen($termino) < 3) return response()->json([]);

        $palabras = array_filter(explode(' ', $termino), fn($p) => strlen($p) >= 2);

        $clientes = Cliente::where('activo', true)
            ->where(function ($query) use ($palabras) {
                foreach ($palabras as $palabra) {
                    $query->where(function ($q) use ($palabra) {
                        $q->whereRaw('UPPER(nombre) LIKE ?', ["%{$palabra}%"])
                          ->orWhereRaw('UPPER(apellido_paterno) LIKE ?', ["%{$palabra}%"])
                          ->orWhereRaw('UPPER(apellido_materno) LIKE ?', ["%{$palabra}%"]);
                    });
                }
            })->limit(10)->get();

        return response()->json($clientes);
    }

    public function enviarCorreo(Request $request, Tramite $tramite)
    {
        $request->validate(['email' => 'required|email']);
        $tramite->load('tipoTramite', 'cajero');

        try {
            \Mail::to($request->email)->send(new \App\Mail\TicketTramiteMail($tramite));
            return back()->with('success_correo', 'Ticket enviado a ' . $request->email);
        } catch (\Exception $e) {
            return back()->with('error_correo', 'Error al enviar el correo.');
        }
    }
}
