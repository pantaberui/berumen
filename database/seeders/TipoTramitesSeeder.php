<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoTramite;

class TipoTramitesSeeder extends Seeder
{
    public function run(): void
    {
        $tramites = [
            ['nombre' => 'CONSTANCIA DE SITUACIÓN FISCAL (RFC/SAT)',    'precio_sugerido' => 220],
            ['nombre' => 'ACTAS DE REGISTRO CIVIL (NACIMIENTO, MATRIMONIO, DEFUNCIÓN)', 'precio_sugerido' => 130],
            ['nombre' => 'NÚMERO DEL SEGURO SOCIAL (NO. IMSS)',          'precio_sugerido' => 120],
            ['nombre' => 'SEMANAS COTIZADAS DEL SEGURO SOCIAL',          'precio_sugerido' => 120],
            ['nombre' => 'COMUNICADO RFC (SAT)',                          'precio_sugerido' => null],
            ['nombre' => 'OPINIÓN DE CUMPLIMIENTO (SAT)',                 'precio_sugerido' => null],
            ['nombre' => 'VIGENCIA IMSS',                                 'precio_sugerido' => 100],
            ['nombre' => 'ESTADO DE CUENTA INFONAVIT',                   'precio_sugerido' => null],
            ['nombre' => 'CARTA DE RETENCIÓN DE INFONAVIT',              'precio_sugerido' => null],
            ['nombre' => 'CARTA DE SUSPENSIÓN DE INFONAVIT',             'precio_sugerido' => null],
            ['nombre' => 'CITA PARA PASAPORTES (SRE)',                   'precio_sugerido' => 60],
            ['nombre' => 'OTRAS CITAS EN LÍNEA',                         'precio_sugerido' => 40],
            ['nombre' => 'BECA DEL BIENESTAR',                           'precio_sugerido' => 80],
            ['nombre' => 'OTROS TRÁMITES',                               'precio_sugerido' => null],
        ];

        foreach ($tramites as $tramite) {
            TipoTramite::create($tramite);
        }
    }
}
