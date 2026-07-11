<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialEstatusSolicitud extends Model
{
    protected $table = 'historial_estatus_solicitudes';

    protected $fillable = [
        'solicitud_servicio_id',
        'estatus_anterior',
        'estatus_nuevo',
        'observacion',
        'user_id',
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
