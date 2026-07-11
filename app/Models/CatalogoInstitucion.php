<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoInstitucion extends Model
{
    protected $table = 'catalogo_instituciones';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'logo',
        'icono',
        'color_principal',
        'color_secundario',
        'orden',
        'activo',
        'mostrar_en_portada',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'mostrar_en_portada' => 'boolean',
    ];

    public function servicios()
    {
        return $this->hasMany(CatalogoServicio::class, 'catalogo_institucion_id');
    }
}
