<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TramitaNetConfiguracion extends Model
{
    protected $table = 'tramitanet_configuraciones';

    protected $fillable = [
        'clave',
        'valor',
        'tipo',
        'grupo',
        'descripcion',
        'editable',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'editable' => 'boolean',
        ];
    }

    public static function obtener(
        string $clave,
        mixed $valorPorDefecto = null
    ): mixed {
        $configuracion = static::where('clave', $clave)->first();

        if (!$configuracion) {
            return $valorPorDefecto;
        }

    return match ($configuracion->tipo) {
        'booleano' => filter_var(
            $configuracion->valor,
            FILTER_VALIDATE_BOOLEAN
        ),

        'entero' => (int) $configuracion->valor,

        'decimal' => (float) $configuracion->valor,

        'json' => json_decode(
            $configuracion->valor,
            true
        ) ?? $valorPorDefecto,

        default => $configuracion->valor,
    };

    }
}
