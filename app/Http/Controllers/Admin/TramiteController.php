<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tramite;
use App\Models\TipoTramite;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TramiteDetalle;

class TramiteController extends Controller
{
    public function index(Request $request)
    {
        $query = Tramite::with('cajero', 'cliente', 'detalles.tipoTramite');

        $fechaDesde = $request->get('fecha_desde', now()->format('Y-m-d'));
        $fechaHasta = $request->get('fecha_hasta', now()->format('Y-m-d'));

        $query->whereDate('fecha_hora_cobro', '>=', $fechaDesde)
              ->whereDate('fecha_hora_cobro', '<=', $fechaHasta);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('tipo_tramite_id')) {
            $query->whereHas('detalles', function ($q) use ($request) {
                $q->where('tipo_tramite_id', $request->tipo_tramite_id);
            });
        }

        $totalAcumulado = $query->sum('subtotal');
        $tramites       = $query->orderBy('fecha_hora_cobro', 'desc')->paginate(15)->withQueryString();
        $tiposTramite   = TipoTramite::where('activo', true)->orderBy('nombre')->get();
        $usuarios       = User::orderBy('name')->get();
        $busqueda       = $request->q;

        return view('admin.tramites.index', compact(
            'tramites', 'tiposTramite', 'usuarios',
            'fechaDesde', 'fechaHasta', 'totalAcumulado', 'busqueda'
        ));
    }

    public function create()
    {
        $tiposTramite = TipoTramite::where('activo', true)->orderBy('nombre')->get();
        return view('admin.tramites.create', compact('tiposTramite'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tramites'                => 'required|array|min:1',
            'tramites.*.tipo_tramite_id' => 'required|exists:tipo_tramites,id',
            'tramites.*.cantidad'     => 'required|integer|min:1',
            'tramites.*.importe'      => 'required|numeric|min:0',
            'observaciones'           => 'nullable|string',
        ]);

        $subtotalTotal = 0;
        $detalles      = [];

        foreach ($request->tramites as $item) {
            $subtotal       = $item['importe'] * $item['cantidad'];
            $subtotalTotal += $subtotal;
            $detalles[]     = [
                'tipo_tramite_id' => $item['tipo_tramite_id'],
                'cantidad'        => $item['cantidad'],
                'importe'         => $item['importe'],
                'subtotal'        => $subtotal,
            ];
        }

        $tramite = Tramite::create([
            'user_id'          => auth()->id(),
            'cliente_id'       => $request->cliente_id ?: null,
            'cliente_nombre'   => $request->cliente_nombre ?: 'PÚBLICO EN GENERAL',
            'subtotal'         => $subtotalTotal,
            'observaciones'    => $request->observaciones,
            'fecha_hora_cobro' => now(),
            'estatus'          => 'cobrado',
        ]);

        foreach ($detalles as $detalle) {
            $detalle['tramite_id'] = $tramite->id;
            TramiteDetalle::create($detalle);
        }

        if ($request->has('imprimir')) {
            return redirect()->route('admin.tramites.show', $tramite)
                ->with('success', 'Trámite registrado correctamente.');
        }

        return redirect()->route('admin.tramites.index')
            ->with('success', 'Trámite registrado correctamente.');
    }

    public function show(Tramite $tramite)
    {
        $tramite->load(
            'cajero',
            'cliente',
            'canceladoPor',
            'detalles.tipoTramite'
        );
        return view('admin.tramites.show', compact('tramite'));
    }

    public function edit(Tramite $tramite)
    {
        $tramite->load('detalles.tipoTramite', 'cajero', 'cliente', 'canceladoPor');

        $tiposTramite = TipoTramite::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('admin.tramites.edit', compact(
            'tramite',
            'tiposTramite'
        ));
    }

    public function update(Request $request, Tramite $tramite)
    {
        $request->validate([
            'detalles' => 'required|array|min:1',

            'detalles.*.id' => 'nullable|integer',

            'detalles.*.tipo_tramite_id' => [
                'required',
                'exists:tipo_tramites,id',
            ],

            'detalles.*.cantidad' => [
                'required',
                'integer',
                'min:1',
            ],

            'detalles.*.importe' => [
                'required',
                'numeric',
                'min:0',
            ],

            'eliminar_detalles' => 'nullable|array',

            'eliminar_detalles.*' => [
                'integer',
            ],

            'observaciones' => 'nullable|string',

            'estatus' => [
                'required',
                'in:cobrado,cancelado',
            ],
        ]);


        \DB::transaction(function () use ($request, $tramite) {

            /*
            * ============================================================
            * 1. CARGAR DETALLES ACTUALES
            * ============================================================
            */

            $tramite->load('detalles');


            /*
            * ============================================================
            * 2. IDS MARCADOS PARA ELIMINAR
            * ============================================================
            */

            $eliminarIds = collect(
                $request->input('eliminar_detalles', [])
            )
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values();


            /*
            * Verificar que los detalles que se quieren eliminar
            * realmente pertenecen a este folio.
            */

            if ($eliminarIds->isNotEmpty()) {

                $idsPermitidos = $tramite->detalles
                    ->pluck('id');

                $idsInvalidos = $eliminarIds
                    ->diff($idsPermitidos);

                if ($idsInvalidos->isNotEmpty()) {
                    abort(422, 'Uno de los detalles seleccionados no pertenece a este trámite.');
                }
            }


            /*
            * ============================================================
            * 3. ELIMINAR DETALLES
            * ============================================================
            */

            if ($eliminarIds->isNotEmpty()) {

                $tramite->detalles()
                    ->whereIn('id', $eliminarIds)
                    ->delete();
            }


            /*
            * ============================================================
            * 4. ACTUALIZAR / CREAR DETALLES
            * ============================================================
            */

            $totalFolio = 0;

            foreach ($request->detalles as $detalleData) {

                /*
                * Si el detalle fue marcado para eliminar,
                * no debemos volver a actualizarlo.
                */

                if (
                    !empty($detalleData['id']) &&
                    $eliminarIds->contains((int) $detalleData['id'])
                ) {
                    continue;
                }


                $cantidad = (int) $detalleData['cantidad'];

                $importe = (float) $detalleData['importe'];

                $subtotal = round(
                    $cantidad * $importe,
                    2
                );


                /*
                * ========================================================
                * DETALLE EXISTENTE
                * ========================================================
                */

                if (!empty($detalleData['id'])) {

                    $detalle = $tramite->detalles()
                        ->where('id', $detalleData['id'])
                        ->first();

                    if (!$detalle) {
                        abort(
                            422,
                            'Uno de los detalles enviados no pertenece a este folio.'
                        );
                    }

                    $detalle->update([
                        'tipo_tramite_id' => $detalleData['tipo_tramite_id'],
                        'cantidad'        => $cantidad,
                        'importe'         => $importe,
                        'subtotal'        => $subtotal,
                    ]);
                }


                /*
                * ========================================================
                * DETALLE NUEVO
                * ========================================================
                */

                else {

                    $tramite->detalles()->create([
                        'tipo_tramite_id' => $detalleData['tipo_tramite_id'],
                        'cantidad'        => $cantidad,
                        'importe'         => $importe,
                        'subtotal'        => $subtotal,
                    ]);
                }


                $totalFolio += $subtotal;
            }


            /*
            * ============================================================
            * 5. VERIFICAR QUE QUEDE AL MENOS UN DETALLE
            * ============================================================
            */

            $tramite->load('detalles');

            if ($tramite->detalles->isEmpty()) {

                throw \Illuminate\Validation\ValidationException::withMessages([
                    'detalles' => 'El folio debe contener al menos un trámite.',
                ]);
            }


            /*
            * ============================================================
            * 6. RECALCULAR EL TOTAL DESDE LA BD
            * ============================================================
            *
            * Lo volvemos a calcular desde los detalles ya guardados.
            * Esto evita depender únicamente del cálculo enviado
            * por el navegador.
            */

            $totalFolio = $tramite->detalles->sum('subtotal');

            $totalFolio = round($totalFolio, 2);


            /*
            * ============================================================
            * 7. DATOS GENERALES DEL FOLIO
            * ============================================================
            */

            $data = [
                'subtotal'      => $totalFolio,
                'observaciones' => $request->observaciones,
                'estatus'       => $request->estatus,
            ];


            /*
            * ============================================================
            * 8. CANCELACIÓN
            * ============================================================
            */

            if (
                $request->estatus === 'cancelado' &&
                $tramite->estatus !== 'cancelado'
            ) {

                $data['fecha_hora_cancelacion'] = now();

                $data['cancelado_por'] = auth()->id();
            }


            /*
            * ============================================================
            * 9. REGRESAR DE CANCELADO A COBRADO
            * ============================================================
            *
            * Si el administrador revierte la cancelación,
            * limpiamos los datos de cancelación.
            */

            if (
                $request->estatus === 'cobrado' &&
                $tramite->estatus === 'cancelado'
            ) {

                $data['fecha_hora_cancelacion'] = null;

                $data['cancelado_por'] = null;
            }


            /*
            * ============================================================
            * 10. ACTUALIZAR FOLIO
            * ============================================================
            */

            $tramite->update($data);
        });


        /*
        * ================================================================
        * REDIRECCIÓN
        * ================================================================
        */

        return redirect()
            ->route('admin.tramites.show', $tramite)
            ->with(
                'success',
                'Trámite actualizado correctamente.'
            );
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

    public function enviarCorreo(Request $request, Tramite $tramite)
    {
        $request->validate(['email' => 'required|email']);
        $tramite->load('detalles.tipoTramite', 'cajero', 'cliente');

        try {
            \Mail::to($request->email)->send(new \App\Mail\TicketTramiteMail($tramite));
            return back()->with('success_correo', 'Ticket enviado a ' . $request->email);
        } catch (\Exception $e) {
            return back()->with('error_correo', 'Error al enviar el correo.');
        }
    }
}
