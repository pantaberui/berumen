<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use App\Models\Contrato;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with('contrato.cliente', 'cajero')
                     ->orderBy('created_at', 'desc')
                     ->paginate(15);
        $busqueda = null;
        return view('admin.pagos.index', compact('pagos', 'busqueda'));
    }

    public function create()
    {
        $contratos = Contrato::with('cliente')
                             ->whereIn('estatus', ['activo', 'adeudo'])
                             ->orderBy('numero_contrato')
                             ->get();
        return view('admin.pagos.create', compact('contratos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contrato_id'   => 'required|exists:contratos,id',
            'fecha_pago'    => 'required|date',
            'periodo_desde' => 'required|date',
            'periodo_hasta' => 'required|date|after_or_equal:periodo_desde',
            'importe'       => 'required|numeric|min:0',
            'descuento'     => 'nullable|numeric|min:0',
            'tipo_pago'     => 'required|in:efectivo,transferencia,tarjeta',
            'observaciones' => 'nullable|string',
        ]);

        $importe   = $request->importe;
        $descuento = $request->descuento ?? 0;
        $total     = $importe - $descuento;

        // Validar pago duplicado para el mismo contrato y periodo
        $duplicado = Pago::where('contrato_id', $request->contrato_id)
            ->where('periodo_desde', $request->periodo_desde)
            ->where('periodo_hasta', $request->periodo_hasta)
            ->exists();

        if ($duplicado) {
            return back()->withErrors([
                'contrato_id' => 'Ya existe un pago registrado para este contrato en el mismo periodo.'
            ])->withInput();
        }


        $pago = Pago::create([
            'contrato_id'   => $request->contrato_id,
            'user_id'       => auth()->id(),
            'fecha_pago'    => $request->fecha_pago,
            'periodo_desde' => $request->periodo_desde,
            'periodo_hasta' => $request->periodo_hasta,
            'importe'       => $importe,
            'descuento'     => $descuento,
            'total'         => $total,
            'tipo_pago'     => $request->tipo_pago,
            'observaciones' => $request->observaciones,
            'fecha_hora_registro'  => now(),
        ]);

        // Actualizar estatus del contrato a activo
        $pago->contrato->update(['estatus' => 'activo']);

        return redirect()->route('admin.pagos.show', $pago)
            ->with('success', 'Pago registrado correctamente.');
    }

    public function show(Pago $pago)
    {
        $pago->load('contrato.cliente', 'cajero');
        return view('admin.pagos.show', compact('pago'));
    }

    public function edit(Pago $pago)
    {
        $contratos = Contrato::with('cliente')->orderBy('numero_contrato')->get();
        return view('admin.pagos.edit', compact('pago', 'contratos'));
    }

    public function update(Request $request, Pago $pago)
    {
        $request->validate([
            'fecha_pago'    => 'required|date',
            'periodo_desde' => 'required|date',
            'periodo_hasta' => 'required|date|after_or_equal:periodo_desde',
            'importe'       => 'required|numeric|min:0',
            'descuento'     => 'nullable|numeric|min:0',
            'tipo_pago'     => 'required|in:efectivo,transferencia,tarjeta',
            'observaciones' => 'nullable|string',
        ]);

        $total = $request->importe - ($request->descuento ?? 0);

        $pago->update([
            'fecha_pago'    => $request->fecha_pago,
            'periodo_desde' => $request->periodo_desde,
            'periodo_hasta' => $request->periodo_hasta,
            'importe'       => $request->importe,
            'descuento'     => $request->descuento ?? 0,
            'total'         => $total,
            'tipo_pago'     => $request->tipo_pago,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('admin.pagos.show', $pago)
            ->with('success', 'Pago actualizado correctamente.');
    }

    public function buscar(Request $request)
    {
        $termino  = strtoupper(trim($request->q));
        if (strlen($termino) < 3) {
            return redirect()->route('admin.pagos.index');
        }

        $palabras = array_filter(explode(' ', $termino), fn($p) => strlen($p) >= 2);

        $pagos = Pago::with('contrato.cliente', 'cajero')
            ->whereHas('contrato.cliente', function ($query) use ($palabras) {
                foreach ($palabras as $palabra) {
                    $query->where(function ($q) use ($palabra) {
                        $q->whereRaw('UPPER(nombre) LIKE ?', ["%{$palabra}%"])
                        ->orWhereRaw('UPPER(apellido_paterno) LIKE ?', ["%{$palabra}%"])
                        ->orWhereRaw('UPPER(apellido_materno) LIKE ?', ["%{$palabra}%"]);
                    });
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $busqueda = $request->q;
        return view('admin.pagos.index', compact('pagos', 'busqueda'));
    }

    public function enviarCorreo(Request $request, Pago $pago)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'El correo es obligatorio.',
            'email.email'    => 'El formato del correo no es válido.',
        ]);

        $pago->load('contrato.cliente', 'cajero');

        try {
            \Mail::to($request->email)->send(new \App\Mail\TicketPagoMail($pago));
            return back()->with('success_correo', 'Ticket enviado correctamente a ' . $request->email);
        } catch (\Exception $e) {
            return back()->with('error_correo', 'Error al enviar el correo. Verifique la configuración.');
        }
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();
        return redirect()->route('admin.pagos.index')
            ->with('success', 'Pago eliminado correctamente.');
    }
}
