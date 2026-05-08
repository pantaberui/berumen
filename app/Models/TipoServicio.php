<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoServicio extends Model
{
    use HasFactory;

    protected $table = 'tipo_servicios';

    protected $fillable = ['nombre', 'activo'];

    public function pagosServicios()
    {
        return $this->hasMany(PagoServicio::class);
    }
}
