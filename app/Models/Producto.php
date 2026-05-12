<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'clave', 'descripcion', 'categoria',
        'stock', 'stock_minimo', 'precio_unitario', 'activo',
    ];

    public function ventaDetalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }

    public function tieneStockSuficiente(int $cantidad): bool
    {
        if ($this->categoria === 'servicio') return true;
        return $this->stock >= $cantidad;
    }
}
