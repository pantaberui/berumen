<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CodigoNetplus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CodigoNetplusController extends Controller
{
    public function index()
    {
        $stats = [
            'disponibles' => CodigoNetplus::where('estatus', 'disponible')->count(),
            'vendidos'    => CodigoNetplus::where('estatus', 'vendido')->count(),
            'cancelados'  => CodigoNetplus::where('estatus', 'cancelado')->count(),
        ];
        return view('admin.codigos_netplus.index', compact('stats'));
    }

    public function cargar(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt|max:10240',
        ], [
            'archivo.required' => 'Selecciona un archivo CSV.',
            'archivo.mimes'    => 'El archivo debe ser formato CSV.',
        ]);

        $archivo  = $request->file('archivo');
        $handle   = fopen($archivo->getRealPath(), 'r');
        $cargados = 0;
        $errores  = [];
        $fila     = 0;

        DB::beginTransaction();

        try {
            while (($linea = fgetcsv($handle)) !== false) {
                $fila++;

                // Saltar encabezado
                if ($fila === 1) continue;

                // Limpiar caracteres raros (CRLF)
                $codigo = trim(preg_replace('/\s+/', '', $linea[0] ?? ''));
                $tiempo = trim($linea[1] ?? '');

                if (empty($codigo) || empty($tiempo)) continue;

                // Verificar si ya existe
                if (CodigoNetplus::where('codigo', $codigo)->exists()) {
                    $errores[] = "Fila {$fila}: código '{$codigo}' ya existe.";
                    continue;
                }

                CodigoNetplus::create([
                    'codigo'     => $codigo,
                    'tiempo'     => $tiempo,
                    'estatus'    => 'disponible',
                    'fecha_alta' => now(),
                ]);

                $cargados++;
            }

            fclose($handle);
            DB::commit();

            return response()->json([
                'success'  => true,
                'cargados' => $cargados,
                'errores'  => $errores,
                'mensaje'  => "Archivo cargado exitosamente. {$cargados} códigos registrados.",
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al cargar el archivo: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function listarRecientes(Request $request)
    {
        $codigos = CodigoNetplus::where('fecha_alta', '>=', $request->desde ?? now()->startOfDay())
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('admin.codigos_netplus.recientes', compact('codigos'));
    }

    public function cancelar(Request $request, CodigoNetplus $codigoNetplus)
    {
        if ($codigoNetplus->estatus === 'cancelado') {
            return back()->with('error', 'Este código ya está cancelado.');
        }

        $codigoNetplus->update([
            'estatus'            => 'cancelado',
            'cancelado_por'      => auth()->id(),
            'fecha_cancelacion'  => now(),
        ]);

        return back()->with('success', 'Código cancelado correctamente.');
    }

    public function reporte(Request $request)
    {
        $usuarios   = \App\Models\User::orderBy('name')->get();
        $fechaDesde = $request->get('fecha_desde', now()->format('Y-m-d'));
        $fechaHasta = $request->get('fecha_hasta', now()->format('Y-m-d'));       

         $query = CodigoNetplus::where('estatus', 'vendido')
        ->with('vendedor')
        ->whereDate('fecha_venta', '>=', $fechaDesde)
        ->whereDate('fecha_venta', '<=', $fechaHasta);

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_venta', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_venta', '<=', $request->fecha_hasta);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $ventas   = $query->orderBy('fecha_venta', 'desc')->get();
        $total    = $ventas->sum('importe');
        $cantidad = $ventas->count();

        // Acumulado por tipo de ficha
        $porTipo = $ventas->groupBy('tipo_ficha')->map(function ($grupo) {
            return [
                'cantidad' => $grupo->count(),
                'total'    => $grupo->sum('importe'),
            ];
        });

        return view('admin.codigos_netplus.reporte', compact(
            'ventas', 'total', 'cantidad', 'porTipo', 'usuarios'
        ));
    }
}
