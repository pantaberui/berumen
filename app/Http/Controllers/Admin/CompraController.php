<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index(Request $request)
    {
        $query = Compra::with('detalles.producto', 'usuario');

        $fechaDesde = $request->get('fecha_desde', now()->format('Y-m-d'));
        $fechaHasta = $request->get('fecha_hasta', now()->format('Y-m-d'));

        $query->whereDate('fecha_compra', '>=', $fechaDesde)
              ->whereDate('fecha_compra', '<=', $fechaHasta);

        if ($request->filled('proveedor')) {
            $query->where('proveedor', $request->proveedor);
        }

        $compras        = $query->orderBy('fecha_compra', 'desc')->paginate(15)->withQueryString();
        $totalAcumulado = $query->sum('total');
        $proveedores    = Compra::PROVEEDORES;
        $productos      = Producto::where('activo', true)->where('categoria', 'producto')->orderBy('descripcion')->get();

        return view('admin.compras.index', compact(
            'compras', 'proveedores', 'productos', 'fechaDesde', 'fechaHasta', 'totalAcumulado'
        ));
    }

    public function create()
    {
        $productos   = Producto::where('activo', true)
                               ->where('categoria', 'producto')
                               ->orderBy('descripcion')
                               ->get();
        $proveedores = Compra::PROVEEDORES;
        return view('admin.compras.create', compact('productos', 'proveedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor'             => 'required|string',
            'fecha_compra'          => 'required|date|before_or_equal:today',
            'productos'             => 'required|array|min:1',
            'productos.*.id'        => 'required|exists:productos,id',
            'productos.*.cantidad'  => 'required|integer|min:1',
            'productos.*.precio'    => 'required|numeric|min:0',
            'observaciones'         => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $totalGeneral = 0;
            $detalles     = [];

            foreach ($request->productos as $item) {
                $total         = $item['cantidad'] * $item['precio'];
                $totalGeneral += $total;
                $detalles[]    = [
                    'producto_id'  => $item['id'],
                    'cantidad'     => $item['cantidad'],
                    'precio_compra'=> $item['precio'],
                    'total'        => $total,
                ];

                // Incrementar stock
                Producto::find($item['id'])->increment('stock', $item['cantidad']);
            }

            $compra = Compra::create([
                'producto_id'  => $detalles[0]['producto_id'], // Compatibilidad con campo original
                'user_id'      => auth()->id(),
                'proveedor'    => $request->proveedor,
                'fecha_compra' => $request->fecha_compra,
                'cantidad'     => array_sum(array_column($detalles, 'cantidad')),
                'precio_compra'=> $detalles[0]['precio_compra'],
                'total'        => $totalGeneral,
                'observaciones'=> $request->observaciones,
            ]);

            foreach ($detalles as $detalle) {
                $detalle['compra_id'] = $compra->id;
                CompraDetalle::create($detalle);
            }

            DB::commit();
            return redirect()->route('admin.compras.index')
                ->with('success', 'Compra registrada y stock actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Compra $compra)
    {
        $compra->load('detalles.producto', 'usuario');
        return view('admin.compras.show', compact('compra'));
    }

    public function edit(Compra $compra)
    {
        $compra->load('detalles.producto');
        $proveedores = Compra::PROVEEDORES;
        return view('admin.compras.edit', compact('compra', 'proveedores'));
    }

    public function update(Request $request, Compra $compra)
    {
        $request->validate([
            'observaciones' => 'nullable|string',
        ]);

        $compra->update(['observaciones' => $request->observaciones]);

        return redirect()->route('admin.compras.show', $compra)
            ->with('success', 'Compra actualizada correctamente.');
    }

    public function destroy(Compra $compra)
    {
        DB::beginTransaction();
        try {
            // Revertir stock de cada detalle
            foreach ($compra->detalles as $detalle) {
                $detalle->producto->decrement('stock', $detalle->cantidad);
            }
            $compra->delete();
            DB::commit();
            return redirect()->route('admin.compras.index')
                ->with('success', 'Compra eliminada y stock revertido.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }

    public function ultimoPrecio(Request $request)
    {
        $ultimaCompra = CompraDetalle::where('producto_id', $request->producto_id)
            ->orderBy('created_at', 'desc')
            ->first();

        return response()->json([
            'precio' => $ultimaCompra?->precio_compra,
        ]);
    }
}