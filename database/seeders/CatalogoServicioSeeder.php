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
            ['NÚMERO DE SEGURO SOCIAL','Número de Seguro Social', 'IMSS', 'CURP', 120, 'fijo'],
            ['SEMANAS COTIZADAS DEL IMSS','Semanas Cotizadas del IMSS', 'IMSS', 'CURP Y NSS', 120, 'fijo'],
            ['VIGENCIA IMSS','Vigencia IMSS', 'IMSS', 'CURP Y NSS', 120, 'fijo'],
            ['ACTIVACIÓN PRIMERA VEZ NSS','Activación Primera Vez NSS', 'IMSS', 'CURP, CÓDIGO POSTAL, COLONIA, CALLE, NÚMERO EXTERIOR, CIUDAD, ESTADO', 120, 'fijo'],
            ['CONSTANCIA DE NO DERECHOHABIENCIA / AFILIACIÓN AL IMSS','Constancia de No Derechohabiencia / Afiliación al IMSS', 'IMSS', 'CURP', 100, 'fijo'],

            ['CARTA DE RETENCIÓN DE INFONAVIT', 'Carta de Retención de INFONAVIT','INFONAVIT', 'CURP, NSS, NÚMERO DE CRÉDITO', 150, 'fijo'],
            ['CARTA DE SUSPENSIÓN DE INFONAVIT', 'Carta de Suspensión de INFONAVIT','INFONAVIT', 'CURP, NSS', 150, 'fijo'],
            ['ESTADO DE CUENTA INFONAVIT', 'Estado de Cuenta INFONAVIT','INFONAVIT', 'CURP, NSS, NÚMERO DE CRÉDITO', 240, 'fijo'],

            ['CONSTANCIA DE NO AFILIACIÓN AL ISSSTE', 'Constancia de No Afiliación al ISSSTE','ISSSTE', 'CURP', 100, 'fijo'],

            ['ACTA DE NACIMIENTO','Acta de Nacimiento', 'Registro Civil', 'CURP', null, 'por_entidad'],
            ['ACTA DE MATRIMONIO', 'Acta de Matrimonio','Registro Civil', 'CURP DEL ESPOSO O ESPOSA', null, 'por_entidad'],
            ['ACTA DE DEFUNCIÓN', 'Acta de Defunción','Registro Civil', 'CURP', null, 'por_entidad'],

            ['COMUNICADO RFC DEL SAT', 'Comunicado RFC del SAT','SAT', 'CURP', 220, 'fijo'],
            ['CONSTANCIA DE SITUACIÓN FISCAL DEL SAT', 'Constancia de situación Fiscal del SAT','SAT', 'CURP O RFC E idCIF', 220, 'fijo'],
            ['OPINIÓN DE CUMPLIMIENTO DEL SAT', 'Opinión de Cumplimiento del SAT','SAT', 'CURP', 220, 'fijo'],
            ['CURP CERTIFICADA','CURP Certificada', 'RENAPO','CURP O DATOS PERSONALES', 20, 'fijo'],
            ['RECIBO DE LUZ CFE','Recibo de Luz CFE','CFE', 'NOMBRE Y NÚMERO DE SERVICIO O RECIBO ANTERIOR', 30, 'fijo'],
        ];

        foreach ($servicios as [$nombre, $tituloPublico, $institucionNombre, $requisitos, $precio, $tipoPrecio]) {
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
                    'titulo_publico' => $tituloPublico,
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
                        'CONSTANCIA DE SITUACIÓN FISCAL DEL SAT',
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
