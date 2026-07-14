<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoCampo extends Model
{
    protected $table = 'catalogo_campos';

    protected $fillable = [
        'nombre',
        'slug',
        'tipo_campo',
        'validacion',
        'placeholder',
        'ayuda',
        'titulo_ayuda',
        'imagen_ayuda',
        'longitud_minima',
        'longitud_maxima',
        'opciones',
        'activo',
        'orden',
    ];

    protected $casts = [
        'opciones' => 'array',
        'activo' => 'boolean',
        'multiple' => 'boolean',
    ];
}
