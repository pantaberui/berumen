<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoServicioModalidadCampo extends Model
{
    protected $table = 'catalogo_servicio_modalidad_campos';

    protected $fillable = [
        'catalogo_servicio_modalidad_id',
        'catalogo_campo_id',
        'requerido',
        'orden',
        'activo',
        'opciones_personalizadas',
    ];

    protected $casts = [
        'requerido' => 'boolean',
        'activo' => 'boolean',
        'opciones_personalizadas' => 'array',
    ];

    public function modalidad()
    {
        return $this->belongsTo(CatalogoServicioModalidad::class, 'catalogo_servicio_modalidad_id');
    }

    public function campoMaestro()
    {
        return $this->belongsTo(CatalogoCampo::class, 'catalogo_campo_id');
    }

    protected function casts(): array
    {
        return [
            'opciones_personalizadas' => 'array',
            'requerido' => 'boolean',
            'activo' => 'boolean',
        ];
    }
}
