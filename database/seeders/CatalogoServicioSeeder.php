<?php

namespace Database\Seeders;

use App\Models\CatalogoInstitucion;
use App\Models\CatalogoServicio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogoServicioSeeder extends Seeder
{
    public function run(): void
    {
        $servicios = [
            ['NÚMERO DE SEGURO SOCIAL', 'IMSS', 'CURP', 120, 'fijo'],
            ['SEMANAS COTIZADAS DEL IMSS', 'IMSS', 'CURP Y NSS', 120, 'fijo'],
            ['VIGENCIA IMSS', 'IMSS', 'CURP Y NSS', 120, 'fijo'],
            ['ACTIVACIÓN PRIMERA VEZ NSS', 'IMSS', 'CURP, CÓDIGO POSTAL, COLONIA, CALLE, NÚMERO EXTERIOR, CIUDAD, ESTADO', 120, 'fijo'],
            ['CONSTANCIA DE NO DERECHOHABIENCIA / AFILIACIÓN AL IMSS', 'IMSS', 'CURP', 100, 'fijo'],

            ['CARTA DE RETENCIÓN DE INFONAVIT', 'INFONAVIT', 'CURP, NSS, NÚMERO DE CRÉDITO', 150, 'fijo'],
            ['CARTA DE SUSPENSIÓN DE INFONAVIT', 'INFONAVIT', 'CURP, NSS', 150, 'fijo'],
            ['ESTADO DE CUENTA INFONAVIT', 'INFONAVIT', 'CURP, NSS, NÚMERO DE CRÉDITO', 240, 'fijo'],

            ['CONSTANCIA DE NO AFILIACIÓN AL ISSSTE', 'ISSSTE', 'CURP', 100, 'fijo'],

            ['ACTA DE NACIMIENTO', 'Registro Civil', 'CURP', null, 'por_entidad'],
            ['ACTA DE MATRIMONIO', 'Registro Civil', 'CURP DEL ESPOSO O ESPOSA', null, 'por_entidad'],
            ['ACTA DE DEFUNCIÓN', 'Registro Civil', 'CURP', null, 'por_entidad'],

            ['COMUNICADO RFC', 'SAT', 'CURP', 220, 'fijo'],
            ['CONSTANCIA DE SITUACIÓN FISCAL', 'SAT', 'CURP O RFC E idCIF', 220, 'fijo'],
            ['OPINIÓN DE CUMPLIMIENTO', 'SAT', 'CURP', 220, 'fijo'],
            ['CURP CERTIFICADA', 'RENAPO','CURP O DATOS PERSONALES', 20, 'fijo'],
            ['RECIBO DE LUZ CFE','CFE', 'NOMBRE Y NÚMERO DE SERVICIO O RECIBO ANTERIOR', 30, 'fijo'],
        ];

        foreach ($servicios as [$nombre, $institucionNombre, $requisitos, $precio, $tipoPrecio]) {
            $institucion = CatalogoInstitucion::where('slug',    Str::slug($institucionNombre))->first();

            if (!$institucion) {
                continue;
            }

            CatalogoServicio::updateOrCreate(
                ['slug' => Str::slug($nombre)],
                [
                    'categoria' => 'tramite',
                    'catalogo_institucion_id' => $institucion->id,
                    'nombre' => $nombre,
                    'slug' => Str::slug($nombre),
                    'titulo_publico' => Str::title(mb_strtolower($nombre)),
                    'descripcion' => 'Servicio digital disponible por TramitaNet.',
                    'descripcion_corta' => $requisitos,
                    'requisitos' => $requisitos,
                    'tipo_precio' => $tipoPrecio,
                    'precio' => $precio,
                    'cobra_comision' => false,
                    'activo' => true,
                    'orden' => 1,
                    'tiempo_estimado' => 'Sujeto a validación',
                    'es_documento_oficial' => true,
                    'entrega_digital' => true,
                    'mostrar_en_portada' => in_array($nombre, [
                        'ACTA DE NACIMIENTO',
                        'CONSTANCIA DE SITUACIÓN FISCAL',
                        'SEMANAS COTIZADAS DEL IMSS',
                        'RECIBO DE LUZ CFE',
                        'CURP CERTIFICADA',
                    ]),
                    'mostrar_precio' => true,
                ]
            );
        }
    }
}
