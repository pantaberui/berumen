<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoTramite extends Model
{
    use HasFactory;

    protected $table = 'tipo_tramites';

    protected $fillable = ['nombre', 'precio_sugerido', 'activo'];

    public function tramites()
    {
        return $this->hasMany(Tramite::class);
    }
}
