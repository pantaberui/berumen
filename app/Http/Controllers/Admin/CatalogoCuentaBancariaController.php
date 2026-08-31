<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CatalogoCuentaBancariaRequest;
use App\Models\CatalogoCuentaBancaria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CatalogoCuentaBancariaController extends Controller
{
    public function index(): View
    {
        $cuentas = CatalogoCuentaBancaria::query()
            ->ordenadas()
            ->paginate(15);

        return view('admin.catalogo-cuentas-bancarias.index', compact('cuentas'));
    }

    public function create(): View
    {
        $cuenta = new CatalogoCuentaBancaria([
            'moneda' => 'MXN',
            'acepta_transferencia' => true,
            'acepta_deposito' => true,
            'activo' => true,
            'es_principal' => false,
            'orden' => 1,
        ]);

        return view('admin.catalogo-cuentas-bancarias.create', compact('cuenta'));
    }

    public function store(
        CatalogoCuentaBancariaRequest $request
    ): RedirectResponse {
        $cuenta = DB::transaction(function () use ($request) {
            $datos = $request->validated();

            $datos['slug'] = strtolower(trim($datos['slug']));
            $datos['logo'] = filled($datos['logo'] ?? null)
                ? strtolower(trim($datos['logo']))
                : null;

            if ($datos['es_principal'] ?? false) {
                CatalogoCuentaBancaria::query()
                    ->where('es_principal', true)
                    ->update(['es_principal' => false]);
            }

            return CatalogoCuentaBancaria::create($datos);
        });

        return redirect()
            ->route('admin.catalogo-cuentas-bancarias.edit', $cuenta)
            ->with('success', 'La cuenta bancaria fue registrada correctamente.');
    }

    public function edit(
        CatalogoCuentaBancaria $catalogoCuentaBancaria
    ): View {
        return view(
            'admin.catalogo-cuentas-bancarias.edit',
            ['cuenta' => $catalogoCuentaBancaria]
        );
    }

    public function update(
        CatalogoCuentaBancariaRequest $request,
        CatalogoCuentaBancaria $catalogoCuentaBancaria
    ): RedirectResponse {
        DB::transaction(function () use ($request, $catalogoCuentaBancaria) {
            $datos = $request->validated();

            $datos['slug'] = strtolower(trim($datos['slug']));
            $datos['logo'] = filled($datos['logo'] ?? null)
                ? strtolower(trim($datos['logo']))
                : null;

            if ($datos['es_principal'] ?? false) {
                CatalogoCuentaBancaria::query()
                    ->whereKeyNot($catalogoCuentaBancaria->id)
                    ->where('es_principal', true)
                    ->update(['es_principal' => false]);
            }

            $catalogoCuentaBancaria->update($datos);
        });

        return redirect()
            ->route(
                'admin.catalogo-cuentas-bancarias.edit',
                $catalogoCuentaBancaria
            )
            ->with('success', 'La cuenta bancaria fue actualizada correctamente.');
    }

    public function destroy(
        CatalogoCuentaBancaria $catalogoCuentaBancaria
    ): RedirectResponse {
        if ($catalogoCuentaBancaria->es_principal) {
            return back()->with(
                'error',
                'No puedes eliminar la cuenta bancaria principal. Marca primero otra cuenta como principal.'
            );
        }

        $catalogoCuentaBancaria->delete();

        return redirect()
            ->route('admin.catalogo-cuentas-bancarias.index')
            ->with('success', 'La cuenta bancaria fue eliminada correctamente.');
    }
}
