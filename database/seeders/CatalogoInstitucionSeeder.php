<?php

namespace Database\Seeders;

use App\Models\CatalogoInstitucion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogoInstitucionSeeder extends Seeder
{
    public function run(): void
    {
        $instituciones = [
            [
                'nombre' => 'SAT',
                'descripcion' => 'Trámites fiscales y constancias relacionadas con el Servicio de Administración Tributaria.',
                'icono' => 'receipt-tax',
                'color_principal' => '#1E40AF',
                'color_secundario' => '#DBEAFE',
                'orden' => 1,
            ],
            [
                'nombre' => 'IMSS',
                'descripcion' => 'Servicios digitales relacionados con seguridad social, NSS y semanas cotizadas.',
                'icono' => 'shield-check',
                'color_principal' => '#047857',
                'color_secundario' => '#D1FAE5',
                'orden' => 2,
            ],
            [
                'nombre' => 'INFONAVIT',
                'descripcion' => 'Consulta y gestión de servicios relacionados con créditos y precalificación.',
                'icono' => 'home',
                'color_principal' => '#C2410C',
                'color_secundario' => '#FFEDD5',
                'orden' => 3,
            ],
            [
                'nombre' => 'Registro Civil',
                'descripcion' => 'Actas certificadas y documentos oficiales del Registro Civil.',
                'icono' => 'file-text',
                'color_principal' => '#7C3AED',
                'color_secundario' => '#EDE9FE',
                'orden' => 4,
            ],
            [
                'nombre' => 'ISSSTE',
                'descripcion' => 'Servicios digitales relacionados con afiliación y constancias del ISSSTE.',
                'icono' => 'badge-check',
                'color_principal' => '#0F766E',
                'color_secundario' => '#CCFBF1',
                'orden' => 5,
            ],
        ];

        foreach ($instituciones as $institucion) {
            CatalogoInstitucion::updateOrCreate(
                ['slug' => Str::slug($institucion['nombre'])],
                $institucion + [
                    'slug' => Str::slug($institucion['nombre']),
                    'activo' => true,
                    'mostrar_en_portada' => true,
                ]
            );
        }
    }
}
