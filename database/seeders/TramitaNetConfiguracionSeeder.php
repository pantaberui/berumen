<?php

namespace Database\Seeders;

use App\Models\TramitaNetConfiguracion;
use Illuminate\Database\Seeder;

class TramitaNetConfiguracionSeeder extends Seeder
{
    public function run(): void
    {
        $configuraciones = [
            [
                'clave' => 'servicio_abierto',
                'valor' => '1',
                'tipo' => 'booleano',
                'grupo' => 'horario',
                'descripcion' => 'Indica si TramitaNet está atendiendo solicitudes en este momento.',
                'editable' => true,
            ],
            [
                'clave' => 'mensaje_servicio_abierto',
                'valor' => 'Estamos en horario de atención.',
                'tipo' => 'texto',
                'grupo' => 'horario',
                'descripcion' => 'Mensaje público cuando el servicio está abierto.',
                'editable' => true,
            ],
            [
                'clave' => 'mensaje_servicio_cerrado',
                'valor' => 'Fuera del horario de atención. Puedes registrar tu solicitud y será atendida en el siguiente horario disponible.',
                'tipo' => 'texto',
                'grupo' => 'horario',
                'descripcion' => 'Mensaje público cuando el servicio está cerrado.',
                'editable' => true,
            ],
            [
                'clave' => 'horario_atencion',
                'valor' => "Lunes a viernes:\n7:00 a 14:00 y de 15:00 a 19:00 horas.\n\nSábados:\n9:00 a 13:00 y de 15:00 a 19:00 horas.\n\nDomingos:\n9:00 a 13:00 horas.",
                'tipo' => 'texto',
                'grupo' => 'horario',
                'descripcion' => 'Horario habitual de atención mostrado al público.',
                'editable' => true,
            ],
            [
                'clave' => 'zona_horaria',
                'valor' => 'Tiempo del Pacífico (UTC-7).',
                'tipo' => 'texto',
                'grupo' => 'horario',
                'descripcion' => 'Zona horaria utilizada para los horarios de atención.',
                'editable' => true,
            ],
        ];

        foreach ($configuraciones as $configuracion) {
            TramitaNetConfiguracion::updateOrCreate(
                ['clave' => $configuracion['clave']],
                $configuracion
            );
        }
    }
}
