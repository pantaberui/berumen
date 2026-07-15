<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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



    public function modalidad(): BelongsTo
    {
        return $this->belongsTo(
            CatalogoServicioModalidad::class,
            'catalogo_servicio_modalidad_id'
        );
    }

    public function campoMaestro(): BelongsTo
    {
        return $this->belongsTo(
            CatalogoCampo::class,
            'catalogo_campo_id'
        );
    }

    protected function casts(): array
    {
        return [
            'requerido' => 'boolean',
            'activo' => 'boolean',
            'opciones_personalizadas' => 'array',
        ];
    }
}
