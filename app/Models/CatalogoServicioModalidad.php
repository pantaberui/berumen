<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoServicioModalidad extends Model
{
    protected $table = 'catalogo_servicio_modalidades';

    protected $fillable = [
        'catalogo_servicio_id',
        'nombre',
        'slug',
        'descripcion',
        'precio',
        'tipo_precio',
        'tiempo_estimado',
        'activo',
        'orden',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean',
    ];

    public function servicio()
    {
        return $this->belongsTo(CatalogoServicio::class, 'catalogo_servicio_id');
    }

    public function campos()
    {
        return $this->hasMany(CatalogoServicioModalidadCampo::class, 'catalogo_servicio_modalidad_id')
            ->orderBy('orden');
    }
}
