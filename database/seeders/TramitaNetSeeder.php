<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TramitaNetSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    
    public function run(): void
    {
        $this->call([
            CatalogoInstitucionSeeder::class,
            CatalogoCampoSeeder::class,
            CatalogoServicioSeeder::class,
            
            CatalogoServicioModalidadSeeder::class,
            CatalogoServicioModalidadCampoSeeder::class,
            CostoActaEntidadSeeder::class,
        ]);
    }

    
}
