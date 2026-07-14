<?php

namespace Database\Seeders;

use App\Models\CostoActaEntidad;
use Illuminate\Database\Seeder;

class CostoActaEntidadSeeder extends Seeder
{
    public function run(): void
    {
        $costos = [
            ['codigo_curp' => 'AS', 'entidad' => 'AGUASCALIENTES',       'costo' => 140.00],
            ['codigo_curp' => 'BC', 'entidad' => 'BAJA CALIFORNIA',      'costo' => 280.00],
            ['codigo_curp' => 'BS', 'entidad' => 'BAJA CALIFORNIA SUR',  'costo' => 262.00],
            ['codigo_curp' => 'CC', 'entidad' => 'CAMPECHE',             'costo' => 100.00],
            ['codigo_curp' => 'CL', 'entidad' => 'COAHUILA',             'costo' => 231.00],
            ['codigo_curp' => 'CM', 'entidad' => 'COLIMA',               'costo' => 106.00],
            ['codigo_curp' => 'CS', 'entidad' => 'CHIAPAS',              'costo' => 153.00],
            ['codigo_curp' => 'CH', 'entidad' => 'CHIHUAHUA',            'costo' => 163.00],
            ['codigo_curp' => 'DF', 'entidad' => 'CIUDAD DE MÉXICO',     'costo' => 128.00],
            ['codigo_curp' => 'DG', 'entidad' => 'DURANGO',              'costo' => 194.00],
            ['codigo_curp' => 'GT', 'entidad' => 'GUANAJUATO',           'costo' => 160.00],
            ['codigo_curp' => 'GR', 'entidad' => 'GUERRERO',             'costo' => 130.00],
            ['codigo_curp' => 'HG', 'entidad' => 'HIDALGO',              'costo' => 182.00],
            ['codigo_curp' => 'JC', 'entidad' => 'JALISCO',              'costo' => 128.00],
            ['codigo_curp' => 'MC', 'entidad' => 'MÉXICO',               'costo' => 104.00],
            ['codigo_curp' => 'MN', 'entidad' => 'MICHOACÁN',            'costo' => 198.00],
            ['codigo_curp' => 'MS', 'entidad' => 'MORELOS',              'costo' => 147.00],
            ['codigo_curp' => 'NT', 'entidad' => 'NAYARIT',              'costo' => 112.00],
            ['codigo_curp' => 'NL', 'entidad' => 'NUEVO LEÓN',           'costo' => 98.00],
            ['codigo_curp' => 'OC', 'entidad' => 'OAXACA',               'costo' => 166.00],
            ['codigo_curp' => 'PL', 'entidad' => 'PUEBLA',               'costo' => 170.00],
            ['codigo_curp' => 'QT', 'entidad' => 'QUERÉTARO',            'costo' => 177.00],
            ['codigo_curp' => 'QR', 'entidad' => 'QUINTANA ROO',         'costo' => 89.00],
            ['codigo_curp' => 'SP', 'entidad' => 'SAN LUIS POTOSÍ',      'costo' => 162.00],
            ['codigo_curp' => 'SL', 'entidad' => 'SINALOA',              'costo' => 159.00],
            ['codigo_curp' => 'SR', 'entidad' => 'SONORA',               'costo' => 134.00],
            ['codigo_curp' => 'TC', 'entidad' => 'TABASCO',              'costo' => 147.00],
            ['codigo_curp' => 'TS', 'entidad' => 'TAMAULIPAS',           'costo' => 148.00],
            ['codigo_curp' => 'TL', 'entidad' => 'TLAXCALA',             'costo' => 206.00],
            ['codigo_curp' => 'VZ', 'entidad' => 'VERACRUZ',             'costo' => 245.00],
            ['codigo_curp' => 'YN', 'entidad' => 'YUCATÁN',              'costo' => 267.00],
            ['codigo_curp' => 'ZS', 'entidad' => 'ZACATECAS',            'costo' => 140.00],
        ];

        foreach ($costos as $costo) {
            CostoActaEntidad::updateOrCreate(
                [
                    'codigo_curp' => $costo['codigo_curp'],
                ],
                [
                    'entidad' => $costo['entidad'],
                    'costo' => $costo['costo'],
                    'activo' => true,
                ]
            );
        }
    }
}
