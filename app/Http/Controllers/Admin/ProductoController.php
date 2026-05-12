<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::query();

        if ($request->filled('q')) {
            $termino = strtoupper(trim($request->q));
            $query->where(function ($q) use ($termino) {
                $q->whereRaw('UPPER(descripcion) LIKE ?', ["%{$termino}%"])
                  ->orWhereRaw('UPPER(clave) LIKE ?', ["%{$termino}%"]);
            });
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        $productos = $query->orderBy('descripcion')->paginate(20)->withQueryString();
        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        return view('admin.productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'clave'          => 'required|string|max:20|unique:productos,clave',
            'descripcion'    => 'required|string|max:200',
            'categoria'      => 'required|in:producto,servicio',
            'stock'          => 'nullable|integer|min:0',
            'stock_minimo'   => 'nullable|integer|min:0',
            'precio_unitario'=> 'required|numeric|min:0',
        ], [
            'clave.unique' => 'Ya existe un producto con esa clave.',
        ]);

        Producto::create([
            'clave'          => strtoupper($request->clave),
            'descripcion'    => strtoupper($request->descripcion),
            'categoria'      => $request->categoria,
            'stock'          => $request->categoria === 'producto' ? ($request->stock ?? 0) : 0,
            'stock_minimo'   => $request->stock_minimo ?? 0,
            'precio_unitario'=> $request->precio_unitario,
            'activo'         => $request->has('activo') ? 1 : 0,
        ]);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    public function edit(Producto $producto)
    {
        return view('admin.productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'clave'          => 'required|string|max:20|unique:productos,clave,' . $producto->id,
            'descripcion'    => 'required|string|max:200',
            'categoria'      => 'required|in:producto,servicio',
            'stock'          => 'nullable|integer|min:0',
            'stock_minimo'   => 'nullable|integer|min:0',
            'precio_unitario'=> 'required|numeric|min:0',
        ]);

        $producto->update([
            'clave'          => strtoupper($request->clave),
            'descripcion'    => strtoupper($request->descripcion),
            'categoria'      => $request->categoria,
            'stock'          => $request->categoria === 'producto' ? ($request->stock ?? 0) : 0,
            'stock_minimo'   => $request->stock_minimo ?? 0,
            'precio_unitario'=> $request->precio_unitario,
            'activo'         => $request->has('activo') ? 1 : 0,
        ]);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    public function buscar(Request $request)
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
}
