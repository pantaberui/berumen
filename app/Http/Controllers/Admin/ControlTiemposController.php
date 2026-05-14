<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\Renta;
use App\Models\RentaProducto;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControlTiemposController extends Controller
{
    public function index()
    {
        $equipos = Equipo::where('activo', true)
            ->with('rentaActiva.productos.producto')
            ->orderBy('numero')
            ->get();

        $equiposData = $equipos->map(function ($equipo) {
        $renta = $equipo->rentaActiva;

        $segundosActuales = 0;
        if ($renta) {
            $segundosActuales = (int) $renta->segundos_acumulados;
            if ($renta->estatus === 'activa' && $renta->hora_inicio) {
                $horaInicio = \Carbon\Carbon::parse($renta->hora_inicio->format('Y-m-d H:i:s'));
                $ahora      = \Carbon\Carbon::now();                
                $diff = max(0, (int) $horaInicio->diffInSeconds($ahora));
                $segundosActuales += $diff;
            }
        }

        return [
            'id'                  => $equipo->id,
            'numero'              => $equipo->numero,
            'tipo'                => $equipo->tipo,
            'descripcion'         => $equipo->descripcion,
            'estatus'             => $equipo->estatus,
            'renta_id'            => $renta?->id,
            'segundos_acumulados' => max(0, $segundosActuales),
            'hora_inicio'         => $renta?->hora_inicio?->format('Y-m-d H:i:s'),
            'estatus_renta'       => $renta?->estatus,
            'tiempo_asignado'     => $renta?->tiempo_asignado_segundos,
            'total_productos'     => $renta?->productos->sum('subtotal') ?? 0,
            'num_productos'       => $renta?->productos->count() ?? 0,
        ];
    });

        return view('admin.control_tiempos.index', compact('equipos', 'equiposData'));
    }

    public function iniciarRenta(Request $request)
    {
        $request->validate([
            'equipo_id'               => 'required|exists:equipos,id',
            'tiempo_asignado_minutos' => 'nullable|integer|min:15|max:480',
        ]);

        $equipo = Equipo::findOrFail($request->equipo_id);

        if (!$equipo->estaDisponible()) {
            return response()->json(['error' => 'El equipo no está disponible.'], 422);
        }

        DB::beginTransaction();
        try {
            $renta = Renta::create([
                'equipo_id'                => $equipo->id,
                'user_id'                  => auth()->id(),
                'hora_inicio'              => now(),
                'segundos_acumulados'      => 0,
                'tiempo_asignado_segundos' => $request->tiempo_asignado_minutos
                    ? $request->tiempo_asignado_minutos * 60
                    : null,
                'estatus' => 'activa',
            ]);

            $equipo->update(['estatus' => 'en_uso']);

            DB::commit();
            return response()->json(['success' => true, 'renta' => $renta]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

   public function pausarRenta(Request $request, Renta $renta)
    {
        if ($renta->estatus !== 'activa') {
            return response()->json(['error' => 'La renta no está activa.'], 422);
        }

        $horaInicio = \Carbon\Carbon::parse($renta->hora_inicio)->utc();
        $ahora      = \Carbon\Carbon::now()->utc();
        $segundos   = $renta->segundos_acumulados + max(0, $ahora->diffInSeconds($horaInicio));

        $renta->update([
            'estatus'             => 'pausada',
            'hora_pausa'          => now(),
            'segundos_acumulados' => round($segundos),
        ]);

        $renta->equipo->update(['estatus' => 'pausado']);

        return response()->json([
            'success'  => true,
            'segundos' => round($segundos),
        ]);
    }

    public function reanudarRenta(Request $request, Renta $renta)
    {
        if ($renta->estatus !== 'pausada') {
            return response()->json(['error' => 'La renta no está pausada.'], 422);
        }

        $renta->update([
            'estatus'     => 'activa',
            'hora_inicio' => now(), // Nueva hora de inicio desde donde se reanuda
            'hora_pausa'  => null,
            // segundos_acumulados ya tiene lo acumulado antes de la pausa
        ]);

        $renta->equipo->update(['estatus' => 'en_uso']);

        return response()->json([
            'success'  => true,
            'segundos' => $renta->segundos_acumulados, // Devolver acumulado para que el frontend lo use
        ]);
    }

    public function cambiarEquipo(Request $request, Renta $renta)
    {
        $request->validate([
            'nuevo_equipo_id' => 'required|exists:equipos,id',
        ]);

        $nuevoEquipo = Equipo::findOrFail($request->nuevo_equipo_id);

        if (!$nuevoEquipo->estaDisponible()) {
            return response()->json(['error' => 'El equipo destino no está disponible.'], 422);
        }

        DB::beginTransaction();
        try {
            // Acumular segundos antes del cambio
            $segundos = $renta->estatus === 'activa'
                ? $renta->segundos_acumulados + now()->diffInSeconds($renta->hora_inicio)
                : $renta->segundos_acumulados;

            // Liberar equipo anterior
            $equipoAnterior = $renta->equipo;
            $equipoAnterior->update(['estatus' => 'disponible']);

            // Actualizar renta con nuevo equipo
            $renta->update([
                'equipo_id'           => $nuevoEquipo->id,
                'hora_inicio'         => now(),
                'segundos_acumulados' => $segundos,
                'estatus'             => 'activa',
                'hora_pausa'          => null,
            ]);

            $nuevoEquipo->update(['estatus' => 'en_uso']);

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function agregarProducto(Request $request, Renta $renta)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad'    => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        if ($producto->categoria === 'producto' && $producto->stock < $request->cantidad) {
            return response()->json([
                'error' => "Stock insuficiente. Disponible: {$producto->stock}"
            ], 422);
        }

        $subtotal = $producto->precio_unitario * $request->cantidad;

        $rentaProducto = RentaProducto::create([
            'renta_id'       => $renta->id,
            'producto_id'    => $producto->id,
            'cantidad'       => $request->cantidad,
            'precio_unitario'=> $producto->precio_unitario,
            'subtotal'       => $subtotal,
            'fecha_hora'     => now(),
        ]);

        // Descontar stock
        if ($producto->categoria === 'producto') {
            $producto->decrement('stock', $request->cantidad);
        }

        return response()->json([
            'success'       => true,
            'producto'      => $rentaProducto->load('producto'),
            'total_productos' => $renta->fresh()->productos->sum('subtotal'),
        ]);
    }

    public function calcularCobro(Renta $renta)
    {
        $segundos          = $renta->segundosTranscurridos();
        $tolerancia        = 3 * 60;
        $segundosEfectivos = max(0, $segundos - $tolerancia);
        $costoRenta        = Equipo::calcularCosto($renta->equipo->tipo, $segundosEfectivos);
        $totalProductos    = $renta->productos->sum('subtotal');
        $total             = $costoRenta + $totalProductos;

        return response()->json([
            'segundos'        => $segundos,
            'costo_renta'     => $costoRenta,
            'total_productos' => $totalProductos,
            'total'           => $total,
            'productos'       => $renta->productos->load('producto'),
        ]);
    }

    public function cobrar(Request $request, Renta $renta)
    {
        // Usar segundos del frontend si vienen, sino calcular del servidor
        $segundos = $request->segundos_frontend
            ? (int) $request->segundos_frontend
            : $renta->segundosTranscurridos();

        $tolerancia        = 3 * 60;
        $segundosEfectivos = max(0, $segundos - $tolerancia);
        $costoRenta        = Equipo::calcularCosto($renta->equipo->tipo, $segundosEfectivos);
        $totalProductos    = $renta->productos->sum('subtotal');
        $total             = $costoRenta + $totalProductos;

        DB::beginTransaction();
        try {
            $renta->update([
                'estatus'             => 'cobrada',
                'hora_fin'            => now(),
                'hora_cobro'          => now(),
                'total_renta'         => $costoRenta,
                'total_productos'     => $totalProductos,
                'total'               => $total,
                'segundos_acumulados' => $segundos,
            ]);
            $renta->equipo->update(['estatus' => 'disponible']);
            DB::commit();
            return response()->json(['success' => true, 'total' => $total]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function estadoActual(Renta $renta)
    {
        $segundos = $renta->segundosTranscurridos();
        return response()->json([
            'segundos'        => $segundos,
            'estatus'         => $renta->estatus,
            'costo_actual'    => Equipo::calcularCosto($renta->equipo->tipo, $segundos),
            'total_productos' => $renta->productos->sum('subtotal'),
        ]);
    }

    public function reporte(Request $request)
    {
        $usuarios   = User::orderBy('name')->get();
        $fechaDesde = $request->get('fecha_desde', now()->format('Y-m-d'));
        $fechaHasta = $request->get('fecha_hasta', now()->format('Y-m-d'));

        $query = Renta::with('equipo', 'cajero', 'productos.producto')
            ->where('estatus', 'cobrada')
            ->whereDate('hora_cobro', '>=', $fechaDesde)
            ->whereDate('hora_cobro', '<=', $fechaHasta);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $rentas         = $query->orderBy('hora_cobro', 'desc')->get();
        $totalRentas    = $rentas->sum('total_renta');
        $totalProductos = $rentas->sum('total_productos');
        $totalGeneral   = $rentas->sum('total');

        return view('admin.control_tiempos.reporte', compact(
            'rentas', 'usuarios', 'fechaDesde', 'fechaHasta',
            'totalRentas', 'totalProductos', 'totalGeneral'
        ));
    }

    public function asignarTiempo(Request $request, Renta $renta)
    {
        $request->validate(['minutos' => 'required|integer|min:15|max:480']);

        $renta->update([
            'tiempo_asignado_segundos' => $request->minutos * 60,
        ]);

        return response()->json(['success' => true]);
    }
}
