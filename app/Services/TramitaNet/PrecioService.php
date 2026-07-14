<?php

namespace App\Services\TramitaNet;

use App\Models\CatalogoServicio;
use App\Models\CatalogoServicioModalidad;
use App\Models\CostoActaEntidad;
use App\Services\TramitaNetService;
use InvalidArgumentException;

class PrecioService
{
    public static function calcular(
        CatalogoServicio $servicio,
        CatalogoServicioModalidad $modalidad,
        array $campos
    ): float {
        $tipoPrecio = $modalidad->tipo_precio
            ?: $servicio->tipo_precio
            ?: 'fijo';

        return match ($tipoPrecio) {
            'fijo' => self::precioFijo($servicio, $modalidad),

            'por_entidad' => self::precioPorEntidad($campos),

            default => throw new InvalidArgumentException(
                "El tipo de precio '{$tipoPrecio}' no está configurado."
            ),
        };
    }

    private static function precioFijo(
        CatalogoServicio $servicio,
        CatalogoServicioModalidad $modalidad
    ): float {
        return (float) (
            $modalidad->precio
            ?? $servicio->precio
            ?? 0
        );
    }

    private static function precioPorEntidad(array $campos): float
    {
        $curp = $campos['curp'] ?? null;

        if (!$curp) {
            throw new InvalidArgumentException(
                'No fue posible calcular el costo porque no se recibió la CURP.'
            );
        }

        $entidad = TramitaNetService::obtenerEntidadDesdeCurp($curp);

        $codigoEntidad = $entidad['codigo'] ?? null;

        if (!$codigoEntidad) {
            throw new InvalidArgumentException(
                'No fue posible identificar la entidad federativa desde la CURP.'
            );
        }

        $costo = CostoActaEntidad::query()
            ->where('codigo_curp', $codigoEntidad)
            ->where('activo', true)
            ->first();

        if (!$costo) {
            throw new InvalidArgumentException(
                'No existe un costo activo configurado para la entidad de la CURP.'
            );
        }

        return (float) $costo->costo;
    }
}