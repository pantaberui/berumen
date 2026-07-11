<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostoActaEntidad extends Model
{
    protected $table = 'costos_actas_entidad';

    protected $fillable = [
        'codigo_curp',
        'entidad',
        'costo',
        'activo',
    ];

    protected $casts = [
        'costo' => 'decimal:2',
        'activo' => 'boolean',
    ];
}
