<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'contrato_id', 'user_id', 'fecha_pago',
        'periodo_desde', 'periodo_hasta', 'importe',
        'descuento', 'total', 'tipo_pago', 'observaciones',
    ];

    protected $casts = [
        'fecha_pago'    => 'date',
        'periodo_desde' => 'date',
        'periodo_hasta' => 'date',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    public function cajero()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
