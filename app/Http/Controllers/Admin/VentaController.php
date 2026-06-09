<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $query = Venta::with('vendedor', 'cliente');                
        $fechaDesde = $request->get('fecha_desde', now()->format('Y-m-d'));
        $fechaHasta = $request->get('fecha_hasta', now()->format('Y-m-d'));

        $query->whereDate('fecha_hora_venta', '>=', $fechaDesde)
              ->whereDate('fecha_hora_venta', '<=', $fechaHasta);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        // sin filtro de usuario por defecto = muestra todos

        $totalAcumulado = $query->sum('total');
        $ventas = $query->with(['vendedor', 'cliente', 'detalles.producto'])
                ->orderBy('fecha_hora_venta', 'desc')
                ->paginate(15)
                ->withQueryString();

        //$ventas         = $query->orderBy('fecha_hora_venta', 'desc')->paginate(15)->withQueryString();
        $usuarios       = \App\Models\User::orderBy('name')->get();

        return view('admin.ventas.index', compact('ventas', 'usuarios', 'fechaDesde', 'fechaHasta', 'totalAcumulado'));
    }

    public function create()
    {
        return view('admin.ventas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'productos'                 => 'required|array|min:1',
            'productos.*.id'            => 'required|exists:productos,id',
            'productos.*.cantidad'      => 'required|integer|min:1',
            'productos.*.descuento'     => 'nullable|numeric|min:0',
            'tipo_pago'                 => 'required|in:efectivo,transferencia,tarjeta',
        ]);

        // Validar stock ANTES de iniciar la transacción
        foreach ($request->productos as $item) {
            $producto = Producto::findOrFail($item['id']);
            if (!$producto->tieneStockSuficiente($item['cantidad'])) {
                return back()->withErrors([
                    'stock' => "Stock insuficiente para \"{$producto->descripcion}\". Stock disponible: {$producto->stock}, solicitado: {$item['cantidad']}."
                ])->withInput();
            }
        }

        DB::beginTransaction();
        try {
            $subtotal       = 0;
            $descuentoTotal = 0;
            $detalles       = [];

            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['id']);

                $precioUnitario = $producto->precio_unitario;
                $descuento      = $item['descuento'] ?? 0;
                $itemSubtotal   = ($precioUnitario * $item['cantidad']) - $descuento;

                $subtotal       += $precioUnitario * $item['cantidad'];
                $descuentoTotal += $descuento;

                $detalles[] = [
                    'producto_id'    => $producto->id,
                    'cantidad'       => $item['cantidad'],
                    'precio_unitario'=> $precioUnitario,
                    'descuento'      => $descuento,
                    'subtotal'       => $itemSubtotal,
                ];

                if ($producto->categoria === 'producto') {
                    $producto->decrement('stock', $item['cantidad']);
                }
            }

            $total = $subtotal - $descuentoTotal;

            $venta = Venta::create([
                'user_id'          => auth()->id(),
                'cliente_id'       => $request->cliente_id ?? null,
                'cliente_nombre'   => $request->cliente_nombre ?? 'PÚBLICO EN GENERAL',
                'subtotal'         => $subtotal,
                'descuento_total'  => $descuentoTotal,
                'total'            => $total,
                'tipo_pago'        => $request->tipo_pago,
                'estatus'          => 'completada',
                'fecha_hora_venta' => now(),
                'observaciones'    => $request->observaciones,
            ]);

            foreach ($detalles as $detalle) {
                $detalle['venta_id'] = $venta->id;
                VentaDetalle::create($detalle);
            }

            DB::commit();

            return redirect()->route('admin.ventas.show', $venta)
                ->with('success', 'Venta registrada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al registrar la venta: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Venta $venta)
    {
        $venta->load('detalles.producto', 'vendedor', 'cliente', 'canceladoPor');
        return view('admin.ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        if ($venta->estatus === 'cancelada') {
            return back()->with('error', 'No se puede editar una venta cancelada.');
        }
        $venta->load('detalles.producto');
        return view('admin.ventas.edit', compact('venta'));
    }

    public function update(Request $request, Venta $venta)
    {
        if (auth()->user()->hasRole('admin') && $request->estatus === 'cancelada' && $venta->estatus !== 'cancelada') {
            // Revertir stock
            foreach ($venta->detalles as $detalle) {
                if ($detalle->producto->categoria === 'producto') {
                    $detalle->producto->increment('stock', $detalle->cantidad);
                }
            }

            $venta->update([
                'estatus'                => 'cancelada',
                'fecha_hora_cancelacion' => now(),
                'cancelado_por'          => auth()->id(),
            ]);

            return redirect()->route('admin.ventas.show', $venta)
                ->with('success', 'Venta cancelada correctamente.');
        }

        $venta->update([
            'tipo_pago'     => $request->tipo_pago,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('admin.ventas.show', $venta)
            ->with('success', 'Venta actualizada correctamente.');
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

    public function buscarProducto(Request $request)
    {
        $termino = strtoupper(trim($request->q));
        if (strlen($termino) < 2) return response()->json([]);

        $productos = Producto::where('activo', true)
            ->where(function ($q) use ($termino) {
                $q->whereRaw('UPPER(descripcion) LIKE ?', ["%{$termino}%"])
                  ->orWhereRaw('UPPER(clave) LIKE ?', ["%{$termino}%"]);
            })
            ->limit(10)
            ->get();

        return response()->json($productos);
    }

    public function enviarCorreo(Request $request, Venta $venta)
    {
        $request->validate(['email' => 'required|email']);
        $venta->load('detalles.producto', 'vendedor');

        try {
            \Mail::to($request->email)->send(new \App\Mail\TicketVentaMail($venta));
            return back()->with('success_correo', 'Ticket enviado a ' . $request->email);
        } catch (\Exception $e) {
            return back()->with('error_correo', 'Error al enviar el correo.');
        }
    }
}
