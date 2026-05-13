<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipo;

class EquiposSeeder extends Seeder
{
    public function run(): void
    {
        // Computadoras 1-5
        for ($i = 1; $i <= 5; $i++) {
            Equipo::create([
                'numero'      => $i,
                'tipo'        => 'computadora',
                'descripcion' => "Computadora $i",
                'estatus'     => 'disponible',
                'activo'      => true,
            ]);
        }

        // Videojuegos 11-17
        for ($i = 11; $i <= 17; $i++) {
            Equipo::create([
                'numero'      => $i,
                'tipo'        => 'videojuego',
                'descripcion' => "Videojuego $i",
                'estatus'     => 'disponible',
                'activo'      => true,
            ]);
        }
    }
}
