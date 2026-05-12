<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id', 'user_id', 'cantidad',
        'precio_compra', 'total', 'fecha_hora_compra', 'observaciones',
    ];

    protected $casts = [
        'fecha_hora_compra' => 'datetime',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}