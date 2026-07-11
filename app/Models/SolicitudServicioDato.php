<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CatalogoCampo;

class SolicitudServicioDato extends Model
{
    protected $table = 'solicitud_servicio_datos';

    protected $fillable = [
        'solicitud_servicio_id',
        'campo',
        'etiqueta',
        'valor',
        'tipo_campo',
        'requerido',
        'catalogo_campo_id',
        'es_archivo',
        'ruta_archivo',
        'nombre_original_archivo',
        'mime_type',
        'tamano_archivo',
    ];

    protected $casts = [
        'requerido' => 'boolean',
        'es_archivo' => 'boolean',
        'tamano_archivo' => 'integer',
    ];

    public function solicitud()
    {
        return $this->belongsTo(SolicitudServicio::class, 'solicitud_servicio_id');
    }

    public function campoMaestro()
    {
        return $this->belongsTo(CatalogoCampo::class, 'catalogo_campo_id');
    }

    public function catalogoCampo()
    {
        return $this->belongsTo(CatalogoCampo::class);
    }
}
