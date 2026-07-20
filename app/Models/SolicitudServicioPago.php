<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudServicioPago extends Model
{
    protected $fillable = [
        'solicitud_servicio_id',
        'catalogo_cuenta_bancaria_id',
        'user_id',

        'estatus',

        'banco',
        'titular',
        'numero_cuenta',
        'clabe_interbancaria',

        'ruta_archivo',
        'nombre_original_archivo',
        'mime_type',
        'tamano_archivo',

        'monto_reportado',
        'referencia_reportada',
        'codigo_autorizacion',

        'observacion',
        'fecha_subida',
        'fecha_validacion',
    ];

    protected $casts = [
        'monto_reportado' => 'decimal:2',
        'tamano_archivo' => 'integer',
        'fecha_subida' => 'datetime',
        'fecha_validacion' => 'datetime',
    ];

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(
            SolicitudServicio::class,
            'solicitud_servicio_id'
        );
    }

    public function cuentaBancaria(): BelongsTo
    {
        return $this->belongsTo(
            CatalogoCuentaBancaria::class,
            'catalogo_cuenta_bancaria_id'
        );
    }

    public function usuarioValidacion(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}
