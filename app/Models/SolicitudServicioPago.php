<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudServicioPago extends Model
{
    protected $fillable = [
        'solicitud_servicio_id',
        'user_id',
        'estatus',
        'ruta_archivo',
        'nombre_original_archivo',
        'mime_type',
        'tamano_archivo',
        'monto_reportado',
        'referencia_reportada',
        'observacion',
        'fecha_validacion',
    ];

    protected $casts = [
        'fecha_validacion' => 'datetime',
        'monto_reportado' => 'decimal:2',
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
