<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incidencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id', 'user_id', 'titulo',
        'descripcion', 'estatus', 'fecha_atencion', 'solucion',
    ];

    protected $casts = [
        'fecha_atencion' => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}