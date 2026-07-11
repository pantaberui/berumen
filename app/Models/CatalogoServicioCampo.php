<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoServicioCampo extends Model
{
    protected $table = 'catalogo_servicio_campos';

    protected $fillable = [
        'catalogo_servicio_id',
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

    public function servicio()
    {
        return $this->belongsTo(CatalogoServicio::class, 'catalogo_servicio_id');
    }

    public function campoMaestro()
    {
        return $this->belongsTo(CatalogoCampo::class, 'catalogo_campo_id');
    }
}
