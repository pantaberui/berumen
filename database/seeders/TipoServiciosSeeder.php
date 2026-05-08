<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoServicio;

class TipoServiciosSeeder extends Seeder
{
    public function run(): void
    {
        $servicios = [
            'TELMEX', 'CFE (LUZ)', 'SKY', 'VETV', 'TELCEL',
            'DISH', 'TOTAL PLAY', 'MEGACABLE', 'MOVISTAR',
            'ELEKTRA', 'ARABELA', 'AVON', 'AT&T',
            'INFONAVIT', 'IZZI', 'JAFRA', 'STARTV',
        ];

        foreach ($servicios as $nombre) {
            TipoServicio::create(['nombre' => $nombre]);
        }
    }
}
