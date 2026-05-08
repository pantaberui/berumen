<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PagoServicio;
use App\Models\TipoServicio;
use App\Models\Cliente;
use Illuminate\Http\Request;

class PagoServicioController extends Controller
{
    public function index(Request $request)
    {
        $query = PagoServicio::with('tipoServicio', 'cliente', 'cajero');

        // Filtro por cliente
        if ($request->filled('q')) {
            $palabras = array_filter(explode(' ', strtoupper(trim($request->q))), fn($p) => strlen($p) >= 2);
            $query->whereHas('cliente', function ($q) use ($palabras) {
                foreach ($palabras as $palabra) {
                    $q->where(function ($sq) use ($palabra) {
                        $sq->whereRaw('UPPER(nombre) LIKE ?', ["%{$palabra}%"])
                          ->orWhereRaw('UPPER(apellido_paterno) LIKE ?', ["%{$palabra}%"])
                          ->orWhereRaw('UPPER(apellido_materno) LIKE ?', ["%{$palabra}%"]);
                    });
                }
            });
        }

        // Filtro por tipo de servicio
        if ($request->filled('tipo_servicio_id')) {
            $query->where('tipo_servicio_id', $request->tipo_servicio_id);
        }

        // Filtro por fecha
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_hora_registro', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_hora_registro', '<=', $request->fecha_hasta);
        }

        $pagos     = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $servicios = TipoServicio::where('activo', true)->orderBy('nombre')->get();
        $busqueda  = $request->q;

        return view('admin.pagos_servicios.index', compact('pagos', 'servicios', 'busqueda'));
    }

    public function create()
    {
        $servicios = TipoServicio::where('activo', true)->orderBy('nombre')->get();
        return view('admin.pagos_servicios.create', compact('servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_servicio_id' => 'required|exists:tipo_servicios,id',
            'cliente_id'       => 'required|exists:clientes,id',
            'referencia'       => 'required|string|max:100',
            'importe'          => 'required|numeric|min:1',
            'comision'         => 'required|numeric|min:10|max:100',
            'tipo_pago'        => 'required|in:efectivo,transferencia,tarjeta',
            'observaciones'    => 'nullable|string',
        ], [
            'comision.min' => 'La comisión mínima es $10.',
            'comision.max' => 'La comisión máxima es $100.',
        ]);

        $total = $request->importe + $request->comision;

        $pago = PagoServicio::create([
            'tipo_servicio_id'    => $request->tipo_servicio_id,
            'cliente_id'          => $request->cliente_id,
            'user_id'             => auth()->id(),
            'referencia'          => strtoupper($request->referencia),
            'importe'             => $request->importe,
            'comision'            => $request->comision,
            'total'               => $total,
            'tipo_pago'           => $request->tipo_pago,
            'estatus'             => 'pagado',
            'fecha_hora_registro' => now(),
            'observaciones'       => $request->observaciones,
        ]);

        return redirect()->route('admin.pagos-servicios.show', $pago)
            ->with('success', 'Pago registrado correctamente.');
    }

    public function show(PagoServicio $pagoServicio)
    {
        $pagoServicio->load('tipoServicio', 'cliente', 'cajero', 'canceladoPor');
        return view('admin.pagos_servicios.show', compact('pagoServicio'));
    }

    public function edit(PagoServicio $pagoServicio)
    {
        $pagoServicio->load('tipoServicio', 'cliente', 'cajero');
        $servicios = TipoServicio::where('activo', true)->orderBy('nombre')->get();
        return view('admin.pagos_servicios.edit', compact('pagoServicio', 'servicios'));
    }

    public function update(Request $request, PagoServicio $pagoServicio)
    {
        $request->validate([
            'referencia'    => 'required|string|max:100',
            'importe'       => 'required|numeric|min:1',
            'comision'      => 'required|numeric|min:10|max:100',
            'tipo_pago'     => 'required|in:efectivo,transferencia,tarjeta',
            'observaciones' => 'nullable|string',
            'estatus'       => 'required|in:pagado,cancelado',
        ]);

        $data = [
            'referencia'    => strtoupper($request->referencia),
            'importe'       => $request->importe,
            'comision'      => $request->comision,
            'total'         => $request->importe + $request->comision,
            'tipo_pago'     => $request->tipo_pago,
            'observaciones' => $request->observaciones,
        ];

        // Cancelación solo admin
        if (auth()->user()->hasRole('admin') && $request->estatus === 'cancelado' && $pagoServicio->estatus !== 'cancelado') {
            $data['estatus']                  = 'cancelado';
            $data['fecha_hora_cancelacion']   = now();
            $data['cancelado_por']            = auth()->id();
        }

        $pagoServicio->update($data);

        return redirect()->route('admin.pagos-servicios.show', $pagoServicio)
            ->with('success', 'Pago actualizado correctamente.');
    }

    public function buscarCliente(Request $request)
    {
        $termino = strtoupper(trim($request->q));
        if (strlen($termino) < 3) return response()->json([]);

        $palabras = array_filter(explode(' ', $termino), fn($p) => strlen($p) >= 2);

        $clientes = Cliente::where(function ($query) use ($palabras) {
            foreach ($palabras as $palabra) {
                $query->where(function ($q) use ($palabra) {
                    $q->whereRaw('UPPER(nombre) LIKE ?', ["%{$palabra}%"])
                      ->orWhereRaw('UPPER(apellido_paterno) LIKE ?', ["%{$palabra}%"])
                      ->orWhereRaw('UPPER(apellido_materno) LIKE ?', ["%{$palabra}%"]);
                });
            }
        })->where('activo', true)->limit(10)->get();

        return response()->json($clientes);
    }

    public function ultimaReferencia(Request $request)
    {
        $ultimo = PagoServicio::where('cliente_id', $request->cliente_id)
            ->where('tipo_servicio_id', $request->tipo_servicio_id)
            ->where('estatus', 'pagado')
            ->latest()
            ->first();

        return response()->json([
            'referencia' => $ultimo?->referencia,
        ]);
    }

    public function enviarCorreo(Request $request, PagoServicio $pagoServicio)
    {
        $request->validate(['email' => 'required|email']);

        $pagoServicio->load('tipoServicio', 'cliente', 'cajero');

        try {
            \Mail::to($request->email)->send(new \App\Mail\TicketPagoServicioMail($pagoServicio));
            return back()->with('success_correo', 'Ticket enviado a ' . $request->email);
        } catch (\Exception $e) {
            return back()->with('error_correo', 'Error al enviar el correo.');
        }
    }
}
