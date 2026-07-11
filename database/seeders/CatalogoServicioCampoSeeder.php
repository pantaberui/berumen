<?php

namespace Database\Seeders;

use App\Models\CatalogoCampo;
use App\Models\CatalogoServicio;
use App\Models\CatalogoServicioCampo;
use Illuminate\Database\Seeder;

class CatalogoServicioCampoSeeder extends Seeder
{
    public function run(): void
    {
        $configuracion = [
            'numero-de-seguro-social' => ['CURP'],

            'semanas-cotizadas-del-imss' => ['CURP', 'NSS'],

            'vigencia-imss' => ['CURP', 'NSS'],

            'activacion-primera-vez-nss' => [
                'CURP',
                'Código postal',
                'Colonia',
                'Calle',
                'Número exterior',
                'Ciudad',
                'Estado',
            ],

            'constancia-de-no-derechohabiencia-afiliacion-al-imss' => ['CURP'],

            'carta-de-retencion-de-infonavit' => [
                'CURP',
                'NSS',
                'Número de crédito',
            ],

            'carta-de-suspension-de-infonavit' => [
                'CURP',
                'NSS',
            ],

            'estado-de-cuenta-infonavit' => [
                'CURP',
                'NSS',
                'Número de crédito',
            ],

            'constancia-de-no-afiliacion-al-issste' => ['CURP'],

            'acta-de-nacimiento' => ['CURP'],

            'acta-de-matrimonio' => ['CURP'],

            'acta-de-defuncion' => ['CURP'],

            'comunicado-rfc-del-sat' => ['CURP'],

            'constancia-de-situacion-fiscal-del-sat' => ['CURP', 'RFC'],

            'opinion-de-cumplimiento-del-sat' => ['CURP'],
        ];

        foreach ($configuracion as $servicioSlug => $campos) {
            $servicio = CatalogoServicio::where('slug', $servicioSlug)->first();

            if (!$servicio) {
                continue;
            }

            foreach ($campos as $index => $nombreCampo) {
                $campo = CatalogoCampo::where('nombre', $nombreCampo)->first();

                if (!$campo) {
                    continue;
                }

                CatalogoServicioCampo::updateOrCreate(
                    [
                        'catalogo_servicio_id' => $servicio->id,
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
