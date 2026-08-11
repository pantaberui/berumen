<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatalogoInstitucion;
use App\Models\CatalogoServicio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\CatalogoCampo;

class TramitaNetServicioAdminController extends Controller
{
    public function index()
    {
        $servicios = CatalogoServicio::with('institucion')
            ->where('categoria', 'tramite')
            ->orderBy('orden')
            ->orderBy('nombre')
            ->paginate(20);

        return view('admin.tramitanet.servicios.index', compact('servicios'));
    }

    public function create()
    {
        $instituciones = CatalogoInstitucion::query()
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('admin.tramitanet.servicios.create', compact('instituciones'));
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);

        $datos['categoria'] = 'tramite';

        $datos['cobra_comision'] = $request->boolean('cobra_comision');
        $datos['es_documento_oficial'] = $request->boolean('es_documento_oficial');
        $datos['entrega_digital'] = $request->boolean('entrega_digital');
        $datos['mostrar_en_portada'] = $request->boolean('mostrar_en_portada');
        $datos['mostrar_precio'] = $request->boolean('mostrar_precio');
        $datos['activo'] = $request->boolean('activo');

        CatalogoServicio::create($datos);

        return redirect()
            ->route('admin.tramitanet.servicios.index')
            ->with('success', 'Servicio creado correctamente.');
    }

    public function edit(CatalogoServicio $servicio)
    {
        $servicio->load([
            'institucion',
            'modalidades' => fn ($query) => $query->orderBy('orden'),
            'modalidades.camposAdmin.campoMaestro',
        ]);

        $instituciones = CatalogoInstitucion::query()
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        $camposDisponibles = CatalogoCampo::query()
            ->where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        return view('admin.tramitanet.servicios.edit', compact(
            'servicio',
            'instituciones',
            'camposDisponibles'
        ));
    }

    public function update(Request $request, CatalogoServicio $servicio)
    {
        $datos = $this->validar($request, $servicio);

        $datos['categoria'] = 'tramite';

        $datos['cobra_comision'] = $request->boolean('cobra_comision');
        $datos['es_documento_oficial'] = $request->boolean('es_documento_oficial');
        $datos['entrega_digital'] = $request->boolean('entrega_digital');
        $datos['mostrar_en_portada'] = $request->boolean('mostrar_en_portada');
        $datos['mostrar_precio'] = $request->boolean('mostrar_precio');
        $datos['activo'] = $request->boolean('activo');

        $servicio->update($datos);

        return redirect()
            ->route('admin.tramitanet.servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    private function validar(
        Request $request,
        ?CatalogoServicio $servicio = null
    ): array {
        return $request->validate([
            'catalogo_institucion_id' => [
                'required',
                'exists:catalogo_instituciones,id',
            ],

            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('catalogo_servicios', 'slug')
                    ->ignore($servicio?->id),
            ],

            'titulo_publico' => [
                'nullable',
                'string',
                'max:255',
            ],

            'descripcion' => [
                'nullable',
                'string',
            ],

            'descripcion_corta' => [
                'nullable',
                'string',
                'max:500',
            ],

            'requisitos' => [
                'nullable',
                'string',
            ],

            'tipo_precio' => [
                'required',
                Rule::in([
                    'fijo',
                    'variable',
                    'gratuito',
                    'por_entidad',
                ]),
            ],

            'precio' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'cobra_comision' => [
                'nullable',
                'boolean',
            ],

            'tiempo_estimado' => [
                'nullable',
                'string',
                'max:255',
            ],

            'orden' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'es_documento_oficial' => [
                'nullable',
                'boolean',
            ],

            'entrega_digital' => [
                'nullable',
                'boolean',
            ],

            'mostrar_en_portada' => [
                'nullable',
                'boolean',
            ],

            'mostrar_precio' => [
                'nullable',
                'boolean',
            ],

            'activo' => [
                'nullable',
                'boolean',
            ],

            'seo_title' => [
                'nullable',
                'string',
                'max:70',
            ],

            'seo_description' => [
                'nullable',
                'string',
                'max:170',
            ],
        ]);
    }
}
