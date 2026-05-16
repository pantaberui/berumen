<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pago;
use App\Models\PagoServicio;
use App\Models\CodigoNetplus;
use App\Models\Venta;
use App\Models\Renta;
use App\Models\Tramite;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReporteVentasExport;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $usuarios   = User::orderBy('name')->get();
        $fechaDesde = $request->get('fecha_desde', now()->format('Y-m-d'));
        $fechaHasta = $request->get('fecha_hasta', now()->format('Y-m-d'));
        $userId     = $request->get('user_id');

        // =============================================
        // SECCIÓN 1 — RESUMEN
        // =============================================

        // Grupo 1: Pago de Servicios + Trámites
        $qServicios = PagoServicio::where('estatus', 'pagado')
            ->whereDate('fecha_hora_registro', '>=', $fechaDesde)
            ->whereDate('fecha_hora_registro', '<=', $fechaHasta);
        $qTramites = Tramite::where('estatus', 'cobrado')
            ->whereDate('fecha_hora_cobro', '>=', $fechaDesde)
            ->whereDate('fecha_hora_cobro', '<=', $fechaHasta);

        // Grupo 2: Pagos Internet + Fichas WiFi
        $qPagosInternet = Pago::whereDate('fecha_pago', '>=', $fechaDesde)
            ->whereDate('fecha_pago', '<=', $fechaHasta);
        $qFichas = CodigoNetplus::where('estatus', 'vendido')
            ->whereDate('fecha_venta', '>=', $fechaDesde)
            ->whereDate('fecha_venta', '<=', $fechaHasta);

        // Grupo 3: Ventas + Rentas
        $qVentas = Venta::where('estatus', 'completada')
            ->whereDate('fecha_hora_venta', '>=', $fechaDesde)
            ->whereDate('fecha_hora_venta', '<=', $fechaHasta);
        $qRentas = Renta::where('estatus', 'cobrada')
            ->whereDate('hora_cobro', '>=', $fechaDesde)
            ->whereDate('hora_cobro', '<=', $fechaHasta);

        if ($userId) {
            $qServicios->where('user_id', $userId);
            $qTramites->where('user_id', $userId);
            $qPagosInternet->where('user_id', $userId);
            $qFichas->where('user_id', $userId);
            $qVentas->where('user_id', $userId);
            $qRentas->where('user_id', $userId);
        }

        $resumen = [
            'grupo1' => [
                'label'    => 'Pago de Servicios y Trámites',
                'servicios'=> $qServicios->sum('total'),
                'tramites' => $qTramites->sum('subtotal'),
                'total'    => $qServicios->sum('total') + $qTramites->sum('subtotal'),
            ],
            'grupo2' => [
                'label'          => 'Pagos de Internet y Fichas WiFi',
                'internet'       => $qPagosInternet->sum('total'),
                'fichas'         => $qFichas->sum('importe'),
                'total'          => $qPagosInternet->sum('total') + $qFichas->sum('importe'),
            ],
            'grupo3' => [
                'label'   => 'Ventas y Tiempos de Renta',
                'ventas'  => $qVentas->sum('total'),
                'rentas'  => $qRentas->sum('total'),
                'total'   => $qVentas->sum('total') + $qRentas->sum('total'),
            ],
        ];

        $granTotal = $resumen['grupo1']['total'] + $resumen['grupo2']['total'] + $resumen['grupo3']['total'];

        // =============================================
        // SECCIÓN 2 — DETALLE
        // =============================================
        $detalle = $this->obtenerDetalle($fechaDesde, $fechaHasta, $userId);

        // =============================================
        // SECCIÓN 3 — GRÁFICA comparativa
        // =============================================
        $grafica = $this->obtenerDatosGrafica($userId);

        return view('admin.dashboard', compact(
            'usuarios', 'fechaDesde', 'fechaHasta', 'userId',
            'resumen', 'granTotal', 'detalle', 'grafica'
        ));
    }

    private function obtenerDetalle($fechaDesde, $fechaHasta, $userId): Collection
    {
        $filas = collect();

        // Pagos de servicios
        $servicios = PagoServicio::with('tipoServicio', 'cajero', 'cliente')
            ->where('estatus', 'pagado')
            ->whereDate('fecha_hora_registro', '>=', $fechaDesde)
            ->whereDate('fecha_hora_registro', '<=', $fechaHasta)
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->get();

        foreach ($servicios as $s) {
            $filas->push([
                'fecha'      => $s->fecha_hora_registro?->format('d/m/Y H:i'),
                'categoria'  => 'Pago de Servicio',
                'concepto'   => $s->tipoServicio->nombre,
                'cliente'    => $s->cliente->nombre_completo ?? '—',
                'referencia' => $s->referencia,
                'importe'    => $s->total,
                'usuario'    => $s->cajero->name,
            ]);
        }

        // Trámites
        $tramites = Tramite::with('cajero', 'cliente', 'detalles.tipoTramite')
            ->where('estatus', 'cobrado')
            ->whereDate('fecha_hora_cobro', '>=', $fechaDesde)
            ->whereDate('fecha_hora_cobro', '<=', $fechaHasta)
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->get();

        foreach ($tramites as $t) {
            $conceptos = $t->detalles->map(fn($d) => $d->tipoTramite->nombre)->join(', ');
            $filas->push([
                'fecha'      => $t->fecha_hora_cobro?->format('d/m/Y H:i'),
                'categoria'  => 'Trámite',
                'concepto'   => $conceptos,
                'cliente'    => $t->cliente_nombre,
                'referencia' => '—',
                'importe'    => $t->subtotal,
                'usuario'    => $t->cajero->name,
            ]);
        }

        // Pagos Internet
        $pagosInternet = Pago::with('contrato.cliente', 'cajero')
            ->whereDate('fecha_pago', '>=', $fechaDesde)
            ->whereDate('fecha_pago', '<=', $fechaHasta)
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->get();

        foreach ($pagosInternet as $p) {
            $filas->push([
                'fecha'      => $p->fecha_pago->format('d/m/Y'),
                'categoria'  => 'Pago Internet',
                'concepto'   => 'Renta Internet — ' . $p->contrato->numero_contrato,
                'cliente'    => $p->contrato->cliente->nombre_completo,
                'referencia' => $p->contrato->numero_contrato,
                'importe'    => $p->total,
                'usuario'    => $p->cajero->name,
            ]);
        }

        // Fichas WiFi
        $fichas = CodigoNetplus::with('vendedor')
            ->where('estatus', 'vendido')
            ->whereDate('fecha_venta', '>=', $fechaDesde)
            ->whereDate('fecha_venta', '<=', $fechaHasta)
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->get();

        foreach ($fichas as $f) {
            $filas->push([
                'fecha'      => $f->fecha_venta?->format('d/m/Y H:i'),
                'categoria'  => 'Ficha WiFi',
                'concepto'   => 'NetPlus — ' . $f->tipo_ficha,
                'cliente'    => '—',
                'referencia' => $f->codigo,
                'importe'    => $f->importe,
                'usuario'    => $f->vendedor->name,
            ]);
        }

        // Ventas
        $ventas = Venta::with('vendedor', 'cliente')
            ->where('estatus', 'completada')
            ->whereDate('fecha_hora_venta', '>=', $fechaDesde)
            ->whereDate('fecha_hora_venta', '<=', $fechaHasta)
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->get();

        foreach ($ventas as $v) {
            $filas->push([
                'fecha'      => $v->fecha_hora_venta?->format('d/m/Y H:i'),
                'categoria'  => 'Venta',
                'concepto'   => 'Venta de Productos/Servicios',
                'cliente'    => $v->cliente_nombre,
                'referencia' => '#' . str_pad($v->id, 6, '0', STR_PAD_LEFT),
                'importe'    => $v->total,
                'usuario'    => $v->vendedor->name,
            ]);
        }

        // Rentas
        $rentas = Renta::with('equipo', 'cajero')
            ->where('estatus', 'cobrada')
            ->whereDate('hora_cobro', '>=', $fechaDesde)
            ->whereDate('hora_cobro', '<=', $fechaHasta)
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->get();

        foreach ($rentas as $r) {
            $filas->push([
                'fecha'      => $r->hora_cobro?->format('d/m/Y H:i'),
                'categoria'  => 'Renta Equipo',
                'concepto'   => 'Equipo ' . $r->equipo->numero . ' (' . $r->equipo->tipo . ')',
                'cliente'    => '—',
                'referencia' => '#' . str_pad($r->id, 6, '0', STR_PAD_LEFT),
                'importe'    => $r->total,
                'usuario'    => $r->cajero->name,
            ]);
        }

        return $filas->sortBy('fecha')->values();
    }

    private function obtenerDatosGrafica($userId): array
    {
        $hoy          = Carbon::now();
        $inicioMesAct = $hoy->copy()->startOfMonth();
        $inicioMesAnt = $hoy->copy()->subMonth()->startOfMonth();
        $finMesAnt    = $hoy->copy()->subMonth()->endOfMonth();

        $labels   = [];
        $mesActual = [];
        $mesAnterior = [];

        // Generar días del mes actual (del 1 al día de hoy)
        $diasMesAct = $inicioMesAct->diffInDays($hoy) + 1;

        for ($i = 0; $i < $diasMesAct; $i++) {
            $fecha = $inicioMesAct->copy()->addDays($i);
            $labels[]     = $fecha->format('d');
            $mesActual[]  = $this->totalDia($fecha->format('Y-m-d'), $userId);
            $fechaAnt     = $inicioMesAnt->copy()->addDays($i);
            $mesAnterior[]= $fechaAnt->lte($finMesAnt)
                ? $this->totalDia($fechaAnt->format('Y-m-d'), $userId)
                : null;
        }

        return [
            'labels'        => $labels,
            'mes_actual'    => $mesActual,
            'mes_anterior'  => $mesAnterior,
            'nombre_actual' => $hoy->translatedFormat('F Y'),
            'nombre_anterior'=> $hoy->copy()->subMonth()->translatedFormat('F Y'),
        ];
    }

    private function totalDia(string $fecha, $userId): float
    {
        $total = 0;

        $queries = [
            PagoServicio::where('estatus', 'pagado')->whereDate('fecha_hora_registro', $fecha),
            Tramite::where('estatus', 'cobrado')->whereDate('fecha_hora_cobro', $fecha),
            Pago::whereDate('fecha_pago', $fecha),
            CodigoNetplus::where('estatus', 'vendido')->whereDate('fecha_venta', $fecha),
            Venta::where('estatus', 'completada')->whereDate('fecha_hora_venta', $fecha),
            Renta::where('estatus', 'cobrada')->whereDate('hora_cobro', $fecha),
        ];

        $campos = ['total', 'subtotal', 'total', 'importe', 'total', 'total'];

        foreach ($queries as $i => $q) {
            if ($userId) $q->where('user_id', $userId);
            $total += $q->sum($campos[$i]);
        }

        return round($total, 2);
    }

    public function exportarExcel(Request $request)
    {
        $fechaDesde = $request->get('fecha_desde', now()->format('Y-m-d'));
        $fechaHasta = $request->get('fecha_hasta', now()->format('Y-m-d'));
        $userId     = $request->get('user_id');

        $detalle = $this->obtenerDetalle($fechaDesde, $fechaHasta, $userId);

        $filas = $detalle->map(fn($f) => [
            $f['fecha'],
            $f['categoria'],
            $f['concepto'],
            $f['cliente'],
            $f['referencia'],
            '$' . number_format($f['importe'], 2),
            $f['usuario'],
        ]);

        return Excel::download(
            new ReporteVentasExport(collect($filas)),
            "reporte_ventas_{$fechaDesde}_{$fechaHasta}.xlsx"
        );
    }
}
