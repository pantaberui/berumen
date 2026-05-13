<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RentaProducto extends Model
{
    use HasFactory;

    protected $table = 'renta_productos';

    protected $fillable = [
        'renta_id', 'producto_id', 'cantidad',
        'precio_unitario', 'subtotal', 'fecha_hora',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function renta()
    {
        return $this->belongsTo(Renta::class);
    }
}