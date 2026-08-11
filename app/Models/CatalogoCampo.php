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
        'grupo_expediente',
        'validacion',
        'transformacion',
        'autocomplete',
        'placeholder',
        'ayuda',
        'ayuda_operador',
        'titulo_ayuda',
        'imagen_ayuda',
        'accept',
        'tamano_maximo_mb',
        'multiple',
        'icono',
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
        'tamano_maximo_mb' => 'decimal:2',
    ];
}
