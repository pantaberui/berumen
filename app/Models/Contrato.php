<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contrato extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id', 'numero_contrato', 'fecha_inicio',
        'mensualidad', 'estatus', 'velocidad', 'observaciones',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
