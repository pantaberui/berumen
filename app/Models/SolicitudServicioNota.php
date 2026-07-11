<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudServicioNota extends Model
{
    protected $fillable = [
        'solicitud_servicio_id',
        'user_id',
        'nota',
        'tipo',
        'visible_cliente',
    ];

    protected $casts = [
        'visible_cliente' => 'boolean',
    ];

    public function solicitud()
    {
        return $this->belongsTo(SolicitudServicio::class, 'solicitud_servicio_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
