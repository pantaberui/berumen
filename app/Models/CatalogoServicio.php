<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoServicio extends Model
{
    protected $table = 'catalogo_servicios';

    protected $fillable = [
        'categoria',
        'catalogo_institucion_id',
        'nombre',
        'descripcion',
        'requisitos',
        'tipo_precio',
        'precio',
        'cobra_comision',
        'montos_disponibles',
        'icono',
        'color',
        'activo',
        'orden',
        'slug',
        'titulo_publico',
        'descripcion_corta',
        'logo',
        'color_principal',
        'color_secundario',
        'tiempo_estimado',
        'es_documento_oficial',
        'entrega_digital',
        'mostrar_en_portada',
        'mostrar_precio',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'cobra_comision' => 'boolean',
        'montos_disponibles' => 'array',
        'activo' => 'boolean',
        'es_documento_oficial' => 'boolean',
        'entrega_digital' => 'boolean',
        'mostrar_en_portada' => 'boolean',
        'mostrar_precio' => 'boolean',
    ];

    public function solicitudes()
    {
        return $this->hasMany(SolicitudServicio::class);
    }

    public function institucion()
    {
        return $this->belongsTo(CatalogoInstitucion::class, 'catalogo_institucion_id');
    }

    public function modalidades()
    {
        return $this->hasMany(CatalogoServicioModalidad::class, 'catalogo_servicio_id')
            ->orderBy('orden');
    }
}
