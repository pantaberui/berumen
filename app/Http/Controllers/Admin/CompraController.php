<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\Producto;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index(Request $request)
    {
        $query = Compra::with('producto', 'usuario');

        $fechaDesde = $request->get('fecha_desde', now()->format('Y-m-d'));
        $fechaHasta = $request->get('fecha_hasta', now()->format('Y-m-d'));

        $query->whereDate('fecha_hora_compra', '>=', $fechaDesde)
              ->whereDate('fecha_hora_compra', '<=', $fechaHasta);

        if ($request->filled('producto_id')) {
            $query->where('producto_id', $request->producto_id);
        }

        $compras    = $query->orderBy('fecha_hora_compra', 'desc')->paginate(15)->withQueryString();
        $productos  = Producto::where('activo', true)->orderBy('descripcion')->get();
        $totalAcumulado = $query->sum('total');

        return view('admin.compras.index', compact('compras', 'productos', 'fechaDesde', 'fechaHasta', 'totalAcumulado'));
    }

    public function create()
    {
        $productos = Producto::where('activo', true)
                             ->where('categoria', 'producto')
                             ->orderBy('descripcion')
                             ->get();
        return view('admin.compras.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id'   => 'required|exists:productos,id',
            'cantidad'      => 'required|integer|min:1',
            'precio_compra' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
        ]);

        $total = $request->cantidad * $request->precio_compra;

        Compra::create([
            'producto_id'      => $request->producto_id,
            'user_id'          => auth()->id(),
            'cantidad'         => $request->cantidad,
            'precio_compra'    => $request->precio_compra,
            'total'            => $total,
            'fecha_hora_compra'=> now(),
            'observaciones'    => $request->observaciones,
        ]);

        // Incrementar stock
        Producto::find($request->producto_id)->increment('stock', $request->cantidad);

        return redirect()->route('admin.compras.index')
            ->with('success', 'Compra registrada y stock actualizado correctamente.');
    }

    public function show(Compra $compra)
    {
        $compra->load('producto', 'usuario');
        return view('admin.compras.show', compact('compra'));
    }

    public function edit(Compra $compra)
    {
        $productos = Producto::where('activo', true)->where('categoria', 'producto')->orderBy('descripcion')->get();
        return view('admin.compras.edit', compact('compra', 'productos'));
    }

    public function update(Request $request, Compra $compra)
    {
        $request->validate([
            'cantidad'      => 'required|integer|min:1',
            'precio_compra' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
        ]);

        // Ajustar stock: revertir cantidad anterior y aplicar nueva
        $diferencia = $request->cantidad - $compra->cantidad;
        $compra->producto->increment('stock', $diferencia);

        $compra->update([
            'cantidad'      => $request->cantidad,
            'precio_compra' => $request->precio_compra,
            'total'         => $request->cantidad * $request->precio_compra,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('admin.compras.index')
            ->with('success', 'Compra actualizada correctamente.');
    }

    public function destroy(Compra $compra)
    {
        // Revertir stock
        $compra->producto->decrement('stock', $compra->cantidad);
        $compra->delete();

        return redirect()->route('admin.compras.index')
            ->with('success', 'Compra eliminada y stock revertido.');
    }
}
