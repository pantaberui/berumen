<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Renta extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipo_id', 'user_id', 'hora_inicio',
        'segundos_acumulados', 'hora_pausa', 'hora_fin',
        'tiempo_asignado_segundos', 'total_renta',
        'total_productos', 'total', 'estatus',
        'hora_cobro', 'observaciones',
    ];

    protected $casts = [
        'hora_inicio'  => 'datetime',
        'hora_pausa'   => 'datetime',
        'hora_fin'     => 'datetime',
        'hora_cobro'   => 'datetime',
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function cajero()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function productos()
    {
        return $this->hasMany(RentaProducto::class);
    }

    // Calcula segundos transcurridos incluyendo pausas
    public function segundosTranscurridos(): int
    {
        if ($this->estatus === 'pausada') {
            return $this->segundos_acumulados;
        }
        return $this->segundos_acumulados + now()->diffInSeconds($this->hora_inicio);
    }
}
