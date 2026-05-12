<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'cliente_id', 'cliente_nombre',
        'subtotal', 'descuento_total', 'total', 'tipo_pago',
        'estatus', 'fecha_hora_venta', 'fecha_hora_cancelacion',
        'cancelado_por', 'observaciones',
    ];

    protected $casts = [
        'fecha_hora_venta'       => 'datetime',
        'fecha_hora_cancelacion' => 'datetime',
    ];

    public function detalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }

    public function vendedor()
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
