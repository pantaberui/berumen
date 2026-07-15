<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'activo' => 'boolean',
        ];
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(
            CatalogoServicio::class,
            'catalogo_servicio_id'
        );
    }

    public function campos(): HasMany
    {
        return $this->hasMany(
            CatalogoServicioModalidadCampo::class,
            'catalogo_servicio_modalidad_id'
        )
            ->where('activo', true)
            ->orderBy('orden');
    }
}
