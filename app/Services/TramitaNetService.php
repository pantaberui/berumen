<?php

namespace App\Services;

use App\Models\SolicitudServicio;
use Carbon\Carbon;

class TramitaNetService
{
    public static function validarFormatoCurp(?string $curp): bool
    {
        if (!$curp) {
            return false;
        }

        $curp = strtoupper(trim($curp));

        return preg_match(
            '/^[A-Z][AEIOU][A-Z]{2}\d{2}(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])[HM](AS|BC|BS|CC|CL|CM|CS|CH|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[A-Z0-9]\d$/',
            $curp
        ) === 1;
    }

    public static function obtenerEntidadDesdeCurp(?string $curp): ?array
    {
        if (!$curp || strlen($curp) < 13) {
            return null;
        }

        $codigo = strtoupper(substr($curp, 11, 2));

        $entidades = self::entidadesCurp();

        if (!isset($entidades[$codigo])) {
            return null;
        }

        return [
            'codigo' => $codigo,
            'nombre' => $entidades[$codigo],
        ];
    }

    public static function entidadesCurp(): array
    {
        return [
            'AS' => 'Aguascalientes',
            'BC' => 'Baja California',
            'BS' => 'Baja California Sur',
            'CC' => 'Campeche',
            'CS' => 'Chiapas',
            'CH' => 'Chihuahua',
            'DF' => 'Ciudad de México',
            'CL' => 'Coahuila',
            'CM' => 'Colima',
            'DG' => 'Durango',
            'GT' => 'Guanajuato',
            'GR' => 'Guerrero',
            'HG' => 'Hidalgo',
            'JC' => 'Jalisco',
            'MC' => 'México',
            'MN' => 'Michoacán',
            'MS' => 'Morelos',
            'NT' => 'Nayarit',
            'NL' => 'Nuevo León',
            'OC' => 'Oaxaca',
            'PL' => 'Puebla',
            'QT' => 'Querétaro',
            'QR' => 'Quintana Roo',
            'SP' => 'San Luis Potosí',
            'SL' => 'Sinaloa',
            'SR' => 'Sonora',
            'TC' => 'Tabasco',
            'TS' => 'Tamaulipas',
            'TL' => 'Tlaxcala',
            'VZ' => 'Veracruz',
            'YN' => 'Yucatán',
            'ZS' => 'Zacatecas',
            'NE' => 'Nacido en el extranjero',
        ];
    }

    public static function generarFolio(): string
    {
        $fecha = Carbon::now()->format('Ymd');

        $consecutivo = SolicitudServicio::whereDate('created_at', Carbon::today())->count() + 1;

        return $fecha . str_pad($consecutivo, 4, '0', STR_PAD_LEFT);
    }

    public static function generarReferenciaPago(string $folio): string
    {
        $fecha = now();
        $diaAnio = str_pad((string) $fecha->dayOfYear, 3, '0', STR_PAD_LEFT);
        $consecutivo = substr($folio, -3);
        $base = $diaAnio . $consecutivo;
        $digito = array_sum(str_split($base)) % 10;
        return $base . $digito;
    }
}