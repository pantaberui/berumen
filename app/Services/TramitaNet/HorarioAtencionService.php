<?php

namespace App\Services\TramitaNet;

use App\Models\TramitaNetConfiguracion;
use Carbon\Carbon;

class HorarioAtencionService
{
    public static function estado(): array
    {
        $automatico = TramitaNetConfiguracion::obtener(
            'horario_automatico',
            false
        );

        /*
         * Si el horario automático está desactivado,
         * respetamos completamente el interruptor manual.
         */
        if (!$automatico) {
            $abierto = TramitaNetConfiguracion::obtener(
                'servicio_abierto',
                true
            );

            return [
                'abierto' => $abierto,
                'automatico' => false,
                'mensaje' => self::mensaje($abierto),
                'siguiente_apertura' => null,
            ];
        }

        $zonaHoraria = TramitaNetConfiguracion::obtener(
            'zona_horaria_sistema',
            'America/Mazatlan'
        );

        $horario = TramitaNetConfiguracion::obtener(
            'horario_programado',
            []
        );

        $ahora = Carbon::now($zonaHoraria);

        $dia = self::nombreDia($ahora);

        $turnos = $horario[$dia] ?? [];

        foreach ($turnos as $turno) {
            $inicio = $ahora->copy()->setTimeFromTimeString(
                $turno['inicio']
            );

            $fin = $ahora->copy()->setTimeFromTimeString(
                $turno['fin']
            );

            if ($ahora->betweenIncluded($inicio, $fin)) {
                return [
                    'abierto' => true,
                    'automatico' => true,
                    'mensaje' => self::mensaje(true),
                    'siguiente_apertura' => null,
                ];
            }
        }

        return [
            'abierto' => false,
            'automatico' => true,
            'mensaje' => self::mensaje(false),
            'siguiente_apertura' => self::siguienteApertura(
                $ahora,
                $horario
            ),
        ];
    }

    private static function mensaje(bool $abierto): string
    {
        return TramitaNetConfiguracion::obtener(
            $abierto
                ? 'mensaje_servicio_abierto'
                : 'mensaje_servicio_cerrado',
            $abierto
                ? 'Estamos en horario de atención.'
                : 'Fuera del horario de atención.'
        );
    }

    private static function siguienteApertura(
        Carbon $ahora,
        array $horario
    ): ?Carbon {
        /*
         * Revisamos hoy y los siguientes 7 días.
         */
        for ($dias = 0; $dias <= 7; $dias++) {
            $fecha = $ahora->copy()->addDays($dias);

            $dia = self::nombreDia($fecha);

            foreach ($horario[$dia] ?? [] as $turno) {
                $inicio = $fecha->copy()->setTimeFromTimeString(
                    $turno['inicio']
                );

                if ($inicio->gt($ahora)) {
                    return $inicio;
                }
            }
        }

        return null;
    }

    private static function nombreDia(Carbon $fecha): string
    {
        return match ($fecha->dayOfWeekIso) {
            1 => 'lunes',
            2 => 'martes',
            3 => 'miercoles',
            4 => 'jueves',
            5 => 'viernes',
            6 => 'sabado',
            7 => 'domingo',
        };
    }
}
