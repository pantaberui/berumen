<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudServicioDocumento extends Model
{
    protected $fillable = [
        'solicitud_servicio_id',
        'user_id',
        'tipo',
        'titulo',
        'ruta_archivo',
        'nombre_original_archivo',
        'mime_type',
        'tamano_archivo',
        'visible_cliente',
    ];

    protected $casts = [
        'visible_cliente' => 'boolean',
    ];

    public function solicitud()
    {
        return $this->belongsTo(
            SolicitudServicio::class,
            'solicitud_servicio_id'
        );
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
