<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Pago;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EstatusClientesController extends Controller
{
    public function index(Request $request)
    {
        $hoy = Carbon::now('America/Mazatlan')->startOfDay();

        $contratos = Contrato::with(['cliente', 'pagos' => function ($q) {
            $q->orderBy('periodo_hasta', 'desc');
        }])
        ->where('estatus', 'activo')
        ->whereHas('cliente', fn($q) => $q->where('activo', true))
        ->get();

        $clientes = $contratos->map(function ($contrato) use ($hoy) {
            $ultimoPago = $contrato->pagos->first();

            // Calcular periodo actual
            $periodoDesde = null;
            $periodoHasta = null;
            $estatus      = 'sin_pagos';
            $colorEstatus = 'gray';

            if ($ultimoPago) {
                $periodoDesde = Carbon::parse($ultimoPago->periodo_hasta)->addDay();
                // Duración del último período para estimar el siguiente
                $duracion     = Carbon::parse($ultimoPago->periodo_desde)->diffInDays($ultimoPago->periodo_hasta);
                $periodoHasta = $periodoDesde->copy()->addDays($duracion);

                $ultimoPeriodoHasta = Carbon::parse($ultimoPago->periodo_hasta);

                // Determinar estatus
                if ($hoy->lte($ultimoPeriodoHasta)) {
                    // Está dentro del período pagado
                    $estatus      = 'pagado';
                    $colorEstatus = 'green';
                    $periodoDesde = Carbon::parse($ultimoPago->periodo_desde);
                    $periodoHasta = $ultimoPeriodoHasta;
                } else {
                    // Ya venció el período pagado
                    $diasVencido = $ultimoPeriodoHasta->diffInDays($hoy);

                    // Verificar si hay pago previo al último
                    $penultimoPago = $contrato->pagos->skip(1)->first();

                    if ($diasVencido <= $duracion) {
                        // Solo 1 período sin pagar
                        $estatus      = 'pendiente';
                        $colorEstatus = 'yellow';
                    } elseif ($diasVencido <= $duracion * 2) {
                        // 2 períodos sin pagar
                        $estatus      = 'vencido';
                        $colorEstatus = 'orange';
                    } else {
                        // Más de 2 períodos sin pagar
                        $estatus      = 'critico';
                        $colorEstatus = 'red';
                    }
                }
            }

            return [
                'contrato'       => $contrato,
                'cliente'        => $contrato->cliente,
                'ultimo_pago'    => $ultimoPago,
                'periodo_desde'  => $periodoDesde,
                'periodo_hasta'  => $periodoHasta,
                'estatus'        => $estatus,
                'color'          => $colorEstatus,
            ];
        });

        // Filtros
        if ($request->filled('estatus')) {
            $clientes = $clientes->filter(fn($c) => $c['estatus'] === $request->estatus);
        }

        if ($request->filled('q')) {
            $q = strtoupper(trim($request->q));
            $clientes = $clientes->filter(fn($c) =>
                str_contains(strtoupper($c['cliente']->nombre), $q) ||
                str_contains(strtoupper($c['cliente']->apellido_paterno), $q) ||
                str_contains(strtoupper($c['contrato']->numero_contrato ?? ''), $q)
            );
        }

        // Ordenar: vencidos primero
        $orden = ['critico' => 0, 'vencido' => 1, 'pendiente' => 2, 'pagado' => 3, 'sin_pagos' => 4];
        $clientes = $clientes->sortBy(fn($c) => $orden[$c['estatus']] ?? 5)->values();

        return view('admin.estatus_clientes.index', compact('clientes', 'hoy'));
    }
}
