<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatalogoCampo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TramitaNetCampoAdminController extends Controller
{
    public function index()
    {
        $campos = CatalogoCampo::query()
            ->orderBy('orden')
            ->orderBy('nombre')
            ->paginate(25);

        return view(
            'admin.tramitanet.campos.index',
            compact('campos')
        );
    }

    public function create()
    {
        return view('admin.tramitanet.campos.create');
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);

        $datos = $this->normalizarDatos($request, $datos);

        CatalogoCampo::create($datos);

        return redirect()
            ->route('admin.tramitanet.campos.index')
            ->with('success', 'Campo creado correctamente.');
    }

    public function edit(CatalogoCampo $campo)
    {
        return view(
            'admin.tramitanet.campos.edit',
            compact('campo')
        );
    }

    public function update(
        Request $request,
        CatalogoCampo $campo
    ) {
        $datos = $this->validar($request, $campo);

        $datos = $this->normalizarDatos(
            $request,
            $datos
        );

        $campo->update($datos);

        return redirect()
            ->route('admin.tramitanet.campos.index')
            ->with('success', 'Campo actualizado correctamente.');
    }

    private function validar(
        Request $request,
        ?CatalogoCampo $campo = null
    ): array {
        return $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('catalogo_campos', 'slug')
                    ->ignore($campo?->id),
            ],

            'tipo_campo' => [
                'required',
                Rule::in([
                    'text',
                    'curp',
                    'rfc',
                    'nss',
                    'email',
                    'tel',
                    'date',
                    'password',
                    'checkbox',
                    'select',
                    'file',
                ]),
            ],

            'grupo_expediente' => [
                'required',
                Rule::in([
                    'datos',
                    'documentos',
                    'credenciales',
                ]),
            ],

            'validacion' => [
                'nullable',
                Rule::in([
                    'required',
                    'accepted',
                    'curp',
                    'email',
                    'nss',
                    'rfc',
                    'telefono',
                ]),
            ],

            'transformacion' => [
                'nullable',
                Rule::in([
                    'mayusculas',
                    'minusculas',
                ]),
            ],

            'autocomplete' => [
                'nullable',
                'string',
                'max:100',
            ],

            'placeholder' => [
                'nullable',
                'string',
                'max:255',
            ],

            'ayuda' => [
                'nullable',
                'string',
            ],

            'ayuda_operador' => [
                'nullable',
                'string',
            ],

            'titulo_ayuda' => [
                'nullable',
                'string',
                'max:255',
            ],

            'imagen_ayuda' => [
                'nullable',
                'string',
                'max:255',
            ],

            'accept' => [
                'nullable',
                'string',
                'max:255',
            ],

            'tamano_maximo_mb' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'longitud_minima' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'longitud_maxima' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'icono' => [
                'nullable',
                'string',
                'max:255',
            ],

            'orden' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'multiple' => [
                'nullable',
                'boolean',
            ],

            'activo' => [
                'nullable',
                'boolean',
            ],

            'opciones_texto' => [
                'nullable',
                'string',
            ],
        ]);
    }

    private function normalizarDatos(
        Request $request,
        array $datos
    ): array {
        $datos['multiple'] = $request->boolean('multiple');
        $datos['activo'] = $request->boolean('activo');

        if ($request->filled('opciones_texto')) {
            $lineas = preg_split(
                '/\r\n|\r|\n/',
                $request->input('opciones_texto')
            );

            $opciones = collect($lineas)
                ->map(fn ($linea) => trim($linea))
                ->filter()
                ->map(function ($linea) {
                    if (str_contains($linea, '|')) {
                        [$valor, $etiqueta] = array_pad(
                            explode('|', $linea, 2),
                            2,
                            null
                        );

                        return [
                            'value' => trim($valor),
                            'label' => trim($etiqueta),
                        ];
                    }

                    return trim($linea);
                })
                ->values()
                ->all();

            $datos['opciones'] = $opciones;
        } else {
            $datos['opciones'] = null;
        }

        unset($datos['opciones_texto']);

        return $datos;
    }
}
