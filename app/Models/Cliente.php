<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'apellido_paterno', 'apellido_materno',
        'telefono', 'celular', 'email', 'curp', 'rfc',
        'calle', 'numero_exterior', 'colonia', 'ciudad',
        'codigo_postal', 'referencias', 'activo',
    ];

    public function contratos()
    {
        return $this->hasMany(Contrato::class);
    }

    public function incidencias()
    {
        return $this->hasMany(Incidencia::class);
    }

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }
}
