<?php

namespace App\Services\TramitaNet;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CaptchaService
{
    private const SESSION_KEY = 'tramitanet.captcha';

    public static function generar(int $longitud = 5): string
    {
        // Se omiten caracteres fáciles de confundir: 0, O, 1, I, L.
        $caracteres = '23456789ABCDEFGHJKMNPQRSTUVWXYZ';

        $codigo = collect(range(1, $longitud))
            ->map(fn () => $caracteres[random_int(0, strlen($caracteres) - 1)])
            ->implode('');

        Session::put(self::SESSION_KEY, hash('sha256', $codigo));

        return $codigo;
    }

    public static function validar(?string $respuesta): bool
    {
        if (blank($respuesta)) {
            return false;
        }

        $hashGuardado = Session::get(self::SESSION_KEY);

        if (!$hashGuardado) {
            return false;
        }

        $respuestaNormalizada = Str::upper(
            preg_replace('/\s+/', '', trim($respuesta))
        );

        $esValido = hash_equals(
            $hashGuardado,
            hash('sha256', $respuestaNormalizada)
        );

        // El código se utiliza una sola vez.
        Session::forget(self::SESSION_KEY);

        return $esValido;
    }
}