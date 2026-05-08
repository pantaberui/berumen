<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CodigoNetplus;
use Illuminate\Http\Request;

class FichaWifiController extends Controller
{
    public function create()
    {
        $tipos      = CodigoNetplus::tiposFicha();
        $disponibles = [];

        foreach ($tipos as $key => $tipo) {
            $disponibles[$key] = CodigoNetplus::where('estatus', 'disponible')
                ->where('tiempo', $tipo['tiempo'])
                ->count();
        }

        return view('admin.fichas_wifi.create', compact('tipos', 'disponibles'));
    }

    public function vender(Request $request)
    {
        $request->validate([
            'tipo_ficha' => 'required|in:' . implode(',', array_keys(CodigoNetplus::tiposFicha())),
        ]);

        $tipos = CodigoNetplus::tiposFicha();
        $tipo  = $tipos[$request->tipo_ficha];

        // Tomar el código disponible con menor ID
        $codigo = CodigoNetplus::where('estatus', 'disponible')
            ->where('tiempo', $tipo['tiempo'])
            ->orderBy('id', 'asc')
            ->lockForUpdate()
            ->first();

        if (!$codigo) {
            return back()->with('error', "No hay códigos disponibles para {$tipo['label']}.");
        }

        $codigo->update([
            'estatus'    => 'vendido',
            'importe'    => $tipo['importe'],
            'tipo_ficha' => $request->tipo_ficha,
            'fecha_venta'=> now(),
            'user_id'    => auth()->id(),
        ]);

        return redirect()->route('admin.fichas-wifi.ticket', $codigo);
    }

    public function ticket(CodigoNetplus $codigoNetplus)
    {
        $codigoNetplus->load('vendedor');
        $tipos = CodigoNetplus::tiposFicha();
        $tipo  = $tipos[$codigoNetplus->tipo_ficha] ?? null;
        return view('admin.fichas_wifi.ticket', compact('codigoNetplus', 'tipo'));
    }

    public function buscar(Request $request)
    {
        $codigo = null;

        if ($request->filled('folio')) {
            $codigo = CodigoNetplus::find($request->folio);
        } elseif ($request->filled('codigo')) {
            $codigo = CodigoNetplus::where('codigo', $request->codigo)->first();
        } elseif ($request->has('ultimo')) {
            $codigo = CodigoNetplus::where('estatus', 'vendido')
                ->where('user_id', auth()->id())
                ->latest('fecha_venta')
                ->first();
        }

        if (!$codigo) {
            return back()->with('error', 'No se encontró ninguna ficha con ese criterio.');
        }

        $codigo->load('vendedor');
        $tipos = CodigoNetplus::tiposFicha();
        $tipo  = $tipos[$codigo->tipo_ficha] ?? null;

        return view('admin.fichas_wifi.ticket', [
            'codigoNetplus' => $codigo,
            'tipo'          => $tipo,
        ]);
    }
}
