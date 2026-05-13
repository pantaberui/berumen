<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero', 'tipo', 'descripcion', 'estatus', 'activo',
    ];

    public function rentas()
    {
        return $this->hasMany(Renta::class);
    }

    public function rentaActiva()
    {
        return $this->hasOne(Renta::class)->whereIn('estatus', ['activa', 'pausada']);
    }

    public function estaDisponible(): bool
    {
        return $this->estatus === 'disponible';
    }

    // Calcula el costo según tipo y segundos
    public static function calcularCosto(string $tipo, int $segundos): float
    {
        if ($segundos <= 0) return 0;

        $minutos = ceil($segundos / 60);
        $costo   = 0;

        if ($tipo === 'computadora') {
            // $5 por cada 15 minutos
            $rangos = ceil($minutos / 15);
            $costo  = $rangos * 5;
        } else {
            // Videojuego: cada hora el rango 46-60 min es gratis
            $horas         = intdiv($minutos, 60);
            $minRestantes  = $minutos % 60;

            // Costo por horas completas: solo 45 min de cada hora
            $costo = $horas * (ceil(45 / 15) * 5); // 3 rangos * $5 = $15/hora

            // Costo por minutos restantes
            if ($minRestantes > 0 && $minRestantes <= 45) {
                $costo += ceil($minRestantes / 15) * 5;
            } elseif ($minRestantes > 45) {
                // Rango 46-60 es gratis
                $costo += ceil(45 / 15) * 5;
            }
        }

        return (float) $costo;
    }
}
