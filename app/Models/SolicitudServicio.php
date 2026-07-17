<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudServicio extends Model
{
    protected $table = 'solicitud_servicios';

    protected $fillable = [
        'folio',
        'referencia_pago',
        'catalogo_servicio_id',
        'estatus',
        'curp',
        'entidad_curp_codigo',
        'entidad_curp_nombre',
        'nombre_solicitante',
        'correo',
        'telefono_whatsapp',
        'medio_entrega',
        'monto_base',
        'comision',
        'total_pagar',
        'metodo_pago',
        'banco_pago',
        'concepto_pago',
        'observaciones_cliente',
        'observaciones_admin',
        'archivo_pdf_final',
        'fecha_pago_confirmado',
        'fecha_enviado',
        'catalogo_servicio_modalidad_id',
        'codigo_consulta',
    ];

    protected $casts = [
        'monto_base' => 'decimal:2',
        'comision' => 'decimal:2',
        'total_pagar' => 'decimal:2',
        'fecha_pago_confirmado' => 'datetime',
        'fecha_enviado' => 'datetime',
    ];

    public function servicio()
    {
        return $this->belongsTo(CatalogoServicio::class, 'catalogo_servicio_id');
    }

    public function datos()
    {
        return $this->hasMany(SolicitudServicioDato::class);
    }

    public function historial()
    {
        return $this->hasMany(HistorialEstatusSolicitud::class);
    }

    public function modalidad()
    {
        return $this->belongsTo(CatalogoServicioModalidad::class, 'catalogo_servicio_modalidad_id');
    }

    public function notas()
    {
        return $this->hasMany(SolicitudServicioNota::class, 'solicitud_servicio_id')
            ->latest();
    }

    public function documentosGenerados()
    {
        return $this->hasMany(
            SolicitudServicioDocumento::class
        )->latest();
    }    

    public function pagos()
    {
        return $this->hasMany(SolicitudServicioPago::class)
                    ->latest();
    }
}
