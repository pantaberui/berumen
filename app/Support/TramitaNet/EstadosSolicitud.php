<?php

namespace App\Support\TramitaNet;

class EstadosSolicitud
{
    public const SOLICITADO = 'solicitado';
    public const ESPERANDO_PAGO = 'esperando_pago';
    public const PAGO_EN_REVISION = 'pago_en_revision';
    public const PAGO_CONFIRMADO = 'pago_confirmado';
    public const EN_GESTION = 'en_gestion';
    public const ENTREGADO = 'entregado';
    public const INFORMACION_REQUERIDA = 'informacion_requerida';
    public const CANCELADO = 'cancelado';
    public const RECHAZADO = 'rechazado';

    public static function labels(): array
    {
        return [
            self::SOLICITADO => 'Solicitado',
            self::ESPERANDO_PAGO => 'Esperando pago',
            self::PAGO_EN_REVISION => 'Pago en revisión',
            self::PAGO_CONFIRMADO => 'Pago confirmado',
            self::EN_GESTION => 'En gestión',
            self::ENTREGADO => 'Entregado',
        ];
    }

    public static function orden(): array
    {
        return [
            self::SOLICITADO => 1,
            self::ESPERANDO_PAGO => 2,
            self::PAGO_EN_REVISION => 3,
            self::PAGO_CONFIRMADO => 4,
            self::EN_GESTION => 5,
            self::ENTREGADO => 6,
        ];
    }

    public static function timeline(): array
    {
        return [
            [self::SOLICITADO, 'Solicitud recibida'],
            [self::ESPERANDO_PAGO, 'Pago pendiente'],
            [self::PAGO_EN_REVISION, 'Pago en revisión'],
            [self::PAGO_CONFIRMADO, 'Pago confirmado'],
            [self::EN_GESTION, 'En gestión'],
            [self::ENTREGADO, 'Entregado'],
        ];
    }

    public static function puedeCambiarDe(string $actual, string $nuevo): bool
    {
        $transiciones = [

            self::SOLICITADO => [
                self::ESPERANDO_PAGO,
                self::CANCELADO,
            ],

            self::ESPERANDO_PAGO => [
                self::PAGO_EN_REVISION,
                self::CANCELADO,
            ],

            self::PAGO_EN_REVISION => [
                self::PAGO_CONFIRMADO,
                self::ESPERANDO_PAGO, // pago rechazado
                self::CANCELADO,
            ],

            self::PAGO_CONFIRMADO => [
                self::EN_GESTION,
                self::CANCELADO,
            ],

            self::EN_GESTION => [
                self::ENTREGADO,
                self::INFORMACION_REQUERIDA,
                self::CANCELADO,
            ],

            self::INFORMACION_REQUERIDA => [
                self::EN_GESTION,
                self::CANCELADO,
            ],

            self::ENTREGADO => [],

            self::CANCELADO => [],
        ];

        return in_array($nuevo, $transiciones[$actual] ?? []);
    }

    public static function permiteSubirComprobante(string $estatus): bool
    {
        return $estatus === self::ESPERANDO_PAGO;
    }

    public static function permiteDescargarResultado(string $estatus): bool
    {
        return in_array($estatus, [
            self::ENTREGADO,
        ]);
    }

    public static function color(string $estado): string
    {
        return match ($estado) {

            self::SOLICITADO =>
                'bg-blue-100 text-blue-800',

            self::ESPERANDO_PAGO =>
                'bg-yellow-100 text-yellow-800',

            self::PAGO_EN_REVISION =>
                'bg-orange-100 text-orange-800',

            self::PAGO_CONFIRMADO =>
                'bg-green-100 text-green-800',

            self::EN_GESTION =>
                'bg-indigo-100 text-indigo-800',

            self::ENTREGADO =>
                'bg-emerald-100 text-emerald-800',

            self::INFORMACION_REQUERIDA =>
                'bg-red-100 text-red-800',

            self::CANCELADO =>
                'bg-gray-200 text-gray-700',

            self::RECHAZADO =>
                'bg-red-200 text-red-900',

            default =>
                'bg-gray-100 text-gray-800',
        };
    }

    public static function icono(string $estado): string
    {
        return match ($estado) {

            self::SOLICITADO => '📥',

            self::ESPERANDO_PAGO => '💰',

            self::PAGO_EN_REVISION => '🧾',

            self::PAGO_CONFIRMADO => '✔️',

            self::EN_GESTION => '⚙️',

            self::ENTREGADO => '🎉',

            self::INFORMACION_REQUERIDA => '📄',

            self::CANCELADO => '⛔',

            self::RECHAZADO => '❌',

            default => 'ℹ️',
        };
    }

}