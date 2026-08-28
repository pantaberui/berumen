<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tramite extends Model
{
    use HasFactory;

    protected $table = 'tramites';

    protected $fillable = [
        'user_id',
        'cliente_id',
        'cliente_nombre',
        'subtotal',
        'observaciones',
        'fecha_hora_cobro',
        'estatus',
        'fecha_hora_cancelacion',
        'cancelado_por',
    ];

    protected $casts = [
        'fecha_hora_cobro'       => 'datetime',
        'fecha_hora_cancelacion' => 'datetime',
    ];

    public function detalles()
    {
        return $this->hasMany(TramiteDetalle::class);
    }

    public function cajero()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function canceladoPor()
    {
        return $this->belongsTo(User::class, 'cancelado_por');
    }
}