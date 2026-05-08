<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PagoServicio extends Model
{
    use HasFactory;

    protected $table = 'pagos_servicios';
    

    protected $fillable = [
        'tipo_servicio_id', 'cliente_id', 'user_id',
        'referencia', 'importe', 'comision', 'total',
        'tipo_pago', 'estatus', 'fecha_hora_registro',
        'fecha_hora_cancelacion', 'cancelado_por', 'observaciones',
    ];

    protected $casts = [
        'fecha_hora_registro'   => 'datetime',
        'fecha_hora_cancelacion' => 'datetime',
    ];

    public function tipoServicio()
    {
        return $this->belongsTo(TipoServicio::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cajero()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function canceladoPor()
    {
        return $this->belongsTo(User::class, 'cancelado_por');
    }
    public function getRouteKeyName()
    {
        return 'id';
    }

    // Calcular comisión automática por rango de importe
    public static function calcularComision(float $importe): float
    {
        if ($importe < 1000) return 25;
        if ($importe < 1500) return 50;
        if ($importe < 2000) return 75;
        return 100;
    }
}
