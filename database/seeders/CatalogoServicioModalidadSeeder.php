<?php

namespace Database\Seeders;

use App\Models\CatalogoServicio;
use App\Models\CatalogoServicioModalidad;
use Illuminate\Database\Seeder;

class CatalogoServicioModalidadSeeder extends Seeder
{
    public function run(): void
    {
        $modalidadesPorServicio = [

            /*
            |--------------------------------------------------------------------------
            | SAT
            |--------------------------------------------------------------------------
            */
            'constancia-de-situacion-fiscal-del-sat' => [
                [
                    'nombre' => 'Solo CURP',
                    'slug' => 'solo-curp',
                    'descripcion' => 'Opción para clientes que únicamente cuentan con su CURP. El tiempo puede ser mayor porque requiere validación adicional.',
                    'precio' => 220.00,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '2 a 24 horas dentro del horario de atención',
                    'orden' => 1,
                ],
                [
                    'nombre' => 'Exprés con RFC e ID CIF',
                    'slug' => 'expres-con-rfc-e-id-cif',
                    'descripcion' => 'Opción recomendada si cuentas con RFC e ID CIF.',
                    'precio' => 220.00,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '10 a 30 minutos dentro del horario de atención',
                    'orden' => 2,
                ],
                [
                    'nombre' => 'Constancia anterior',
                    'slug' => 'constancia-anterior',
                    'descripcion' => 'Sube la primera página de una constancia anterior en PDF o imagen. Debe verse claramente el RFC, ID CIF o código QR.',
                    'precio' => 220.00,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '10 a 30 minutos dentro del horario de atención',
                    'orden' => 3,
                ],
                [
                    'nombre' => 'Con e.firma vigente',
                    'slug' => 'con-efirma-vigente',
                    'descripcion' => 'Requiere los archivos .cer y .key, la contraseña de la llave privada y autorización expresa.',
                    'precio' => 50.00,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '10 a 30 minutos dentro del horario de atención',
                    'orden' => 4,
                ],
            ],

            'comunicado-rfc-del-sat' => [
                [
                    'nombre' => 'Por CURP',
                    'slug' => 'por-curp',
                    'descripcion' => 'Obtén tu comunicado RFC proporcionando tu CURP.',
                    'precio' => null,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
            ],

            'opinion-de-cumplimiento-del-sat' => [
                [
                    'nombre' => 'Por CURP',
                    'slug' => 'por-curp',
                    'descripcion' => 'Solicita tu Opinión de Cumplimiento proporcionando tu CURP.',
                    'precio' => null,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
            ],

  
            /*
            |--------------------------------------------------------------------------
            | Registro Civil
            |--------------------------------------------------------------------------
            */
            'acta-de-nacimiento' => [
                [
                    'nombre' => 'Por CURP',
                    'slug' => 'por-curp',
                    'descripcion' => 'Solicita tu acta de nacimiento proporcionando tu CURP.',
                    'precio' => null,
                    'tipo_precio' => 'por_entidad',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
            ],

            'acta-de-matrimonio' => [
                [
                    'nombre' => 'Por CURP',
                    'slug' => 'por-curp',
                    'descripcion' => 'Captura la CURP del esposo o de la esposa para solicitar el acta de matrimonio.',
                    'precio' => null,
                    'tipo_precio' => 'por_entidad',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
            ],

            'acta-de-defuncion' => [
                [
                    'nombre' => 'Por CURP',
                    'slug' => 'por-curp',
                    'descripcion' => 'Captura la CURP de la persona fallecida para solicitar el acta de defunción.',
                    'precio' => null,
                    'tipo_precio' => 'por_entidad',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | IMSS
            |--------------------------------------------------------------------------
            */
            'numero-de-seguro-social' => [
                [
                    'nombre' => 'Por CURP',
                    'slug' => 'por-curp',
                    'descripcion' => 'Obtén tu Número de Seguro Social utilizando tu CURP.',
                    'precio' => null,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
            ],

            'semanas-cotizadas-del-imss' => [
                [
                    'nombre' => 'Consulta por CURP y NSS',
                    'slug' => 'por-curp-y-nss',
                    'descripcion' => 'Obtén tu reporte de semanas cotizadas proporcionando CURP y NSS.',
                    'precio' => null,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
            ],

            'vigencia-imss' => [
                [
                    'nombre' => 'Por CURP',
                    'slug' => 'por-curp',
                    'descripcion' => 'Obtén tu constancia de vigencia de derechos utilizando tu CURP.',
                    'precio' => null,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
            ],

            'activacion-primera-vez-nss' => [
                [
                    'nombre' => 'Por CURP y domicilio',
                    'slug' => 'por-curp-y-domicilio',
                    'descripcion' => 'Solicita la activación inicial de tu NSS proporcionando CURP y domicilio.',
                    'precio' => null,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
            ],

            'constancia-de-no-derechohabiencia-afiliacion-al-imss' => [
                [
                    'nombre' => 'Por CURP',
                    'slug' => 'por-curp',
                    'descripcion' => 'Obtén tu constancia de no derechohabiencia utilizando tu CURP.',
                    'precio' => null,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | ISSSTE
            |--------------------------------------------------------------------------
            */

            'constancia-de-no-afiliacion-al-issste' => [
                [
                    'nombre' => 'Por CURP',
                    'slug' => 'por-curp',
                    'descripcion' => 'Obtén tu constancia de no afiliación al ISSSTE proporcionando tu CURP.',
                    'precio' => null,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | RENAPO
            |--------------------------------------------------------------------------
            */
            'curp-certificada' => [
                [
                    'nombre' => 'Por CURP',
                    'slug' => 'por-curp',
                    'descripcion' => 'Obtén tu CURP certificada proporcionando tu CURP completa.',
                    'precio' => null,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
                [
                    'nombre' => 'No conozco mi CURP',
                    'slug' => 'por-datos-personales',
                    'descripcion' => 'Localizaremos tu CURP certificada utilizando tus datos personales registrados ante RENAPO.',
                    'precio' => null,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 2,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | CFE
            |--------------------------------------------------------------------------
            */
            'recibo-de-luz-cfe' => [
                [
                    'nombre' => 'Por datos del recibo',
                    'slug' => 'por-datos-del-recibo',
                    'descripcion' => 'Proporciona el nombre del titular y el número de servicio.',
                    'precio' => null,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
                [
                    'nombre' => 'Con recibo anterior',
                    'slug' => 'con-recibo-anterior',
                    'descripcion' => 'Adjunta una fotografía o archivo PDF de un recibo anterior.',
                    'precio' => null,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 2,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | INFONAVIT
            |--------------------------------------------------------------------------
            */
            'carta-de-retencion-de-infonavit' => [
                [
                    'nombre' => 'Por datos del crédito',
                    'slug' => 'por-datos-del-credito',
                    'descripcion' => 'Solicita tu carta proporcionando CURP, NSS y número de crédito INFONAVIT.',
                    'precio' => null,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
            ],

            'carta-de-suspension-de-infonavit' => [
                [
                    'nombre' => 'Por CURP y NSS',
                    'slug' => 'por-curp-y-nss',
                    'descripcion' => 'Solicita tu carta de suspensión proporcionando CURP y NSS.',
                    'precio' => null,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
            ],

            'estado-de-cuenta-infonavit' => [
                [
                    'nombre' => 'Por datos del crédito',
                    'slug' => 'por-datos-del-credito',
                    'descripcion' => 'Obtén tu estado de cuenta proporcionando CURP, NSS y número de crédito INFONAVIT.',
                    'precio' => null,
                    'tipo_precio' => 'fijo',
                    'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                    'orden' => 1,
                ],
            ],
        ];

        foreach ($modalidadesPorServicio as $servicioSlug => $modalidades) {
            $servicio = CatalogoServicio::where('slug', $servicioSlug)->first();

            if (!$servicio) {
                $this->command?->warn(
                    "No se encontró el servicio: {$servicioSlug}"
                );

                continue;
            }

            foreach ($modalidades as $modalidad) {
                CatalogoServicioModalidad::updateOrCreate(
                    [
                        'catalogo_servicio_id' => $servicio->id,
                        'slug' => $modalidad['slug'],
                    ],
                    [
                        'nombre' => $modalidad['nombre'],
                        'descripcion' => $modalidad['descripcion'],
                        'precio' => $modalidad['precio'],
                        'tipo_precio' => $modalidad['tipo_precio'],
                        'tiempo_estimado' => $modalidad['tiempo_estimado'],
                        'orden' => $modalidad['orden'],
                        'activo' => true,
                    ]
                );
            }
        }
    }
}