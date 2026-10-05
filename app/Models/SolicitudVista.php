<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudVista extends Model
{
    protected $table = 'solicitudes_vistas';

    public $timestamps = false;

    protected $fillable = [
        'solicitud_servicio_id',
        'user_id',
        'vista_en',
    ];

    protected $casts = [
        'vista_en' => 'datetime',
    ];

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(
            SolicitudServicio::class,
            'solicitud_servicio_id'
        );
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}
