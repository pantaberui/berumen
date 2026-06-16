<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CodigoNetplus extends Model
{
    use HasFactory;

    protected $table = 'codigos_netplus';

    protected $fillable = [
        'codigo', 'tiempo', 'estatus', 'importe', 'tipo_ficha',
        'fecha_alta', 'fecha_venta', 'user_id',
        'cancelado_por', 'fecha_cancelacion',
    ];

    protected $casts = [
        'fecha_alta'        => 'datetime',
        'fecha_venta'       => 'datetime',
        'fecha_cancelacion' => 'datetime',
    ];

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function canceladoPor()
    {
        return $this->belongsTo(User::class, 'cancelado_por');
    }

    // Tipos de ficha con precio e importe
    public static function tiposFicha(): array
    {
        return [
            'media_hora' => ['label' => 'Media Hora',  'tiempo' => '00:30:00', 'importe' => 5.00,  'color' => 'blue'],
            '1_hora'     => ['label' => '1 Hora',       'tiempo' => '01:00:00', 'importe' => 9.00,  'color' => 'green'],
            '3_horas'    => ['label' => '3 Horas',      'tiempo' => '03:00:00', 'importe' => 15.00, 'color' => 'yellow'],
            '1_dia'      => ['label' => '1 Día',        'tiempo' => '24:00:00', 'importe' => 25.00, 'color' => 'orange'],
            '1_semana'   => ['label' => '1 Semana',     'tiempo' => '1w','importe' => 60.00, 'color' => 'purple'],
            '1_mes'      => ['label' => '1 Mes',       'tiempo' => '4w', 'importe' => 120.00,'color' => 'red'],
        ];
    }
}
