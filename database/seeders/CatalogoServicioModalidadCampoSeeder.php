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
        $configuracion = [

            /*
            |--------------------------------------------------------------------------
            | SAT
            |--------------------------------------------------------------------------
            */
            'constancia-de-situacion-fiscal-del-sat' => [

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
            ],
            'comunicado-rfc-del-sat' => [
                'por-curp' => [
                    'curp',
                ],
            ],

            'opinion-de-cumplimiento-del-sat' => [
                'por-curp' => [
                    'curp',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Registro Civil
            |--------------------------------------------------------------------------
            */
            'acta-de-nacimiento' => [
                'por-curp' => [
                    'curp',
                ],
            ],

            'acta-de-matrimonio' => [
                'por-curp' => [
                    'curp',
                ],
            ],

            'acta-de-defuncion' => [
                'por-curp' => [
                    'curp',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | IMSS
            |--------------------------------------------------------------------------
            */
            'numero-de-seguro-social' => [
                'por-curp' => [
                    'curp',
                ],
            ],

            'semanas-cotizadas-del-imss' => [
                'por-curp-y-nss' => [
                    'curp',
                    'nss',
                ],
            ],

            'vigencia-imss' => [
                'por-curp' => [
                    'curp',
                ],
            ],

            'activacion-primera-vez-nss' => [
                'por-curp-y-domicilio' => [
                    'curp',
                    'codigo_postal',
                    'colonia',
                    'calle',
                    'numero_exterior',
                    'ciudad',
                    'estado',
                ],
            ],

            'constancia-de-no-derechohabiencia-afiliacion-al-imss' => [
                'por-curp' => [
                    'curp',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | ISSSTE
            |--------------------------------------------------------------------------
            */

            'constancia-de-no-afiliacion-al-issste' => [
                'por-curp' => [
                    'curp',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | RENAPO
            |--------------------------------------------------------------------------
            */
            'curp-certificada' => [

                'por-curp' => [
                    'curp',
                ],

                /*
                 * Pendiente:
                 * nombre(s)
                 * apellido_paterno
                 * apellido_materno
                 * fecha_nacimiento
                 * sexo
                 * estado
                 */
                'por-datos-personales' => [
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | CFE
            |--------------------------------------------------------------------------
            */
            'recibo-de-luz-cfe' => [

                'por-datos-del-recibo' => [
                    'nombre_recibo',
                    'numero_servicio',
                ],

                'con-recibo-anterior' => [
                    'recibo_anterior',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | INFONAVIT
            |--------------------------------------------------------------------------
            */
            'carta-de-retencion-de-infonavit' => [
                'por-datos-del-credito' => [
                    'curp',
                    'nss',
                    'numero_de_credito_infonavit',
                ],
            ],

            'carta-de-suspension-de-infonavit' => [
                'por-curp-y-nss' => [
                    'curp',
                    'nss',
                ],
            ],

            'estado-de-cuenta-infonavit' => [
                'por-datos-del-credito' => [
                    'curp',
                    'nss',
                    'numero_de_credito_infonavit',
                ],
            ],

        ];

        foreach ($configuracion as $servicioSlug => $modalidades) {

            $servicio = CatalogoServicio::where('slug', $servicioSlug)->first();

            if (!$servicio) {
                $this->command?->warn("No existe el servicio: {$servicioSlug}");
                continue;
            }

            foreach ($modalidades as $modalidadSlug => $campos) {

                $modalidad = CatalogoServicioModalidad::where(
                    'catalogo_servicio_id',
                    $servicio->id
                )
                    ->where('slug', $modalidadSlug)
                    ->first();

                if (!$modalidad) {
                    $this->command?->warn(
                        "No existe la modalidad '{$modalidadSlug}' del servicio '{$servicioSlug}'"
                    );
                    continue;
                }

                foreach ($campos as $orden => $campoSlug) {

                    $campo = CatalogoCampo::where('slug', $campoSlug)->first();

                    if (!$campo) {
                        $this->command?->warn("No existe el campo: {$campoSlug}");
                        continue;
                    }

                    CatalogoServicioModalidadCampo::updateOrCreate(
                        [
                            'catalogo_servicio_modalidad_id' => $modalidad->id,
                            'catalogo_campo_id' => $campo->id,
                        ],
                        [
                            'requerido' => true,
                            'orden' => $orden + 1,
                            'activo' => true,
                        ]
                    );
                }
            }
        }
    }
}
