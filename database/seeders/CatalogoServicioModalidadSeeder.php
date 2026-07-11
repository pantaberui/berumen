<?php

namespace Database\Seeders;

use App\Models\CatalogoServicio;
use App\Models\CatalogoServicioModalidad;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogoServicioModalidadSeeder extends Seeder
{
    public function run(): void
    {
        $servicio = CatalogoServicio::where('slug', 'constancia-de-situacion-fiscal-del-sat')->first();

        if (!$servicio) {
            return;
        }

        $modalidades = [
            [
                'nombre' => 'Solo CURP',
                'descripcion' => 'Opción para clientes que únicamente cuentan con su CURP. El tiempo puede ser mayor porque requiere validación adicional.',
                'precio' => 220,
                'tipo_precio' => 'fijo',
                'tiempo_estimado' => 'Sujeto a validación dentro del horario de atención',
                'orden' => 1,
            ],
            [
                'nombre' => 'Exprés con RFC e ID CIF',
                'descripcion' => 'Opción recomendada si cuentas con RFC e ID CIF. Normalmente se gestiona en menor tiempo dentro del horario de atención.',
                'precio' => 220,
                'tipo_precio' => 'fijo',
                'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                'orden' => 2,
            ],
            [
                'nombre' => 'Constancia anterior',
                'descripcion' => 'Sube únicamente la primera página de una constancia anterior en PDF, imagen o captura. Debe verse claramente el RFC, ID CIF o el código QR. No es necesario subir todas las páginas.',
                'precio' => 220,
                'tipo_precio' => 'fijo',
                'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                'orden' => 3,
            ],
            [
                'nombre' => 'Con e.firma vigente',
                'descripcion' => 'Opción para clientes que cuentan con e.firma vigente. Requiere autorización expresa para usar los archivos únicamente en este trámite.',
                'precio' => 50,
                'tipo_precio' => 'fijo',
                'tiempo_estimado' => '5 a 20 minutos dentro del horario de atención',
                'orden' => 4,
            ],
        ];

        foreach ($modalidades as $modalidad) {
            CatalogoServicioModalidad::updateOrCreate(
                [
                    'catalogo_servicio_id' => $servicio->id,
                    'slug' => Str::slug($modalidad['nombre']),
                ],
                $modalidad + [
                    'catalogo_servicio_id' => $servicio->id,
                    'slug' => Str::slug($modalidad['nombre']),
                    'activo' => true,
                ]
            );
        }
    }
}