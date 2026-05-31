<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id', 'user_id', 'proveedor',
        'fecha_compra', 'cantidad', 'precio_compra',
        'total', 'observaciones',
    ];

    protected $casts = [
        'fecha_compra'     => 'date',
        'fecha_hora_compra'=> 'datetime',
    ];

    // Catálogo de proveedores
    public const PROVEEDORES = [
        'COCA-COLA'   => 'COCA-COLA',
        'SABRITAS'    => 'SABRITAS',
        'SAMS'       => 'SAMS',
        'MERCADO LIBRE'        => 'MERCADO LIBRE',
        'WALMART'    => 'WALMART',
        'AMAZON'      => 'AMAZON',
        'OFFICE DEPOT' => 'OFFICE DEPOT',
        'PAPELERÍA EL CONTADOR'       => 'PAPELERÍA EL CONTADOR',        
        'OTROS'       => 'OTROS',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function detalles()
    {
        return $this->hasMany(CompraDetalle::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}