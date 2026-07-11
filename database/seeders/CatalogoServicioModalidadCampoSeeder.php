<?php

namespace Database\Seeders;

use App\Models\CatalogoCampo;
use App\Models\CatalogoServicio;
use App\Models\CatalogoServicioModalidad;
use App\Models\CatalogoServicioModalidadCampo;
use Illuminate\Database\Seeder;

class CatalogoServicioModalidadCampoSeeder extends Seeder
{
    public function run(): void
    {
        $servicio = CatalogoServicio::where('slug', 'constancia-de-situacion-fiscal-del-sat')->first();

        if (!$servicio) {
            return;
        }

        $configuracion = [
            'solo-curp' => [
                'curp',
            ],

            'expres-con-rfc-e-id-cif' => [
                'rfc',
                'id_cif',
            ],

            'constancia-anterior' => [
                'constancia_anterior',
            ],

            'con-efirma-vigente' => [
                'archivo_cer',
                'archivo_key',
                'password_efirma',
                'autorizacion_efirma',
            ],
        ];

        foreach ($configuracion as $modalidadSlug => $campos) {
            $modalidad = CatalogoServicioModalidad::where('catalogo_servicio_id', $servicio->id)
                ->where('slug', $modalidadSlug)
                ->first();

            if (!$modalidad) {
                continue;
            }

            foreach ($campos as $index => $campoSlug) {
                $campo = CatalogoCampo::where('slug', $campoSlug)->first();

                if (!$campo) {
                    continue;
                }

                CatalogoServicioModalidadCampo::updateOrCreate(
                    [
                        'catalogo_servicio_modalidad_id' => $modalidad->id,
                        'catalogo_campo_id' => $campo->id,
                    ],
                    [
                        'requerido' => true,
                        'orden' => $index + 1,
                        'activo' => true,
                    ]
                );
            }
        }
    }
}
