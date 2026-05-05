<?php

namespace App\Helpers;

class NumeroALetras
{
    private static $unidades = [
        '', 'UN', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE',
        'DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISÉIS',
        'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE', 'VEINTE', 'VEINTIÚN', 'VEINTIDÓS',
        'VEINTITRÉS', 'VEINTICUATRO', 'VEINTICINCO', 'VEINTISÉIS', 'VEINTISIETE',
        'VEINTIOCHO', 'VEINTINUEVE'
    ];

    private static $decenas = [
        '', 'DIEZ', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA',
        'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'
    ];

    private static $centenas = [
        '', 'CIEN', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS',
        'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS'
    ];

    public static function convertir(float $numero): string
    {
        $entero  = (int) $numero;
        $centavos = round(($numero - $entero) * 100);

        $letras = self::convertirEntero($entero);

        return "({$letras} " . " PESOS " . str_pad($centavos, 2, '0', STR_PAD_LEFT) . "/100 M.N.)";
    }

    private static function convertirEntero(int $numero): string
    {
        if ($numero === 0) return 'CERO';
        if ($numero < 0)  return 'MENOS ' . self::convertirEntero(abs($numero));

        $resultado = '';

        if ($numero >= 1000000) {
            $millones = (int) ($numero / 1000000);
            $resultado .= ($millones === 1 ? 'UN MILLÓN' : self::convertirEntero($millones) . ' MILLONES');
            $numero %= 1000000;
            if ($numero > 0) $resultado .= ' ';
        }

        if ($numero >= 1000) {
            $miles = (int) ($numero / 1000);
            $resultado .= ($miles === 1 ? 'MIL' : self::convertirEntero($miles) . ' MIL');
            $numero %= 1000;
            if ($numero > 0) $resultado .= ' ';
        }

        if ($numero >= 100) {
            $c = (int) ($numero / 100);
            $resultado .= ($numero === 100 ? 'CIEN' : self::$centenas[$c]);
            $numero %= 100;
            if ($numero > 0) $resultado .= ' ';
        }

        if ($numero >= 30) {
            $d = (int) ($numero / 10);
            $resultado .= self::$decenas[$d];
            $numero %= 10;
            if ($numero > 0) $resultado .= ' Y ';
        }

        if ($numero > 0) {
            $resultado .= self::$unidades[$numero];
        }

        return trim($resultado);
    }
}