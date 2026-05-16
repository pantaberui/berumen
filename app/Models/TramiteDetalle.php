<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TramiteDetalle extends Model
{
    use HasFactory;

    protected $table = 'tramite_detalles';

    protected $fillable = [
        'tramite_id', 'tipo_tramite_id', 'cantidad', 'importe', 'subtotal',
    ];

    public function tipoTramite()
    {
        return $this->belongsTo(TipoTramite::class);
    }

    public function tramite()
    {
        return $this->belongsTo(Tramite::class);
    }
}
