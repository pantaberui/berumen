<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TramitaNetConfiguracion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TramitaNetConfiguracionController extends Controller
{
    public function edit()
    {
        $servicioAbierto = TramitaNetConfiguracion::obtener(
            'servicio_abierto',
            true
        );

        $mensajeAbierto = TramitaNetConfiguracion::obtener(
            'mensaje_servicio_abierto',
            'Estamos en horario de atención.'
        );

        $mensajeCerrado = TramitaNetConfiguracion::obtener(
            'mensaje_servicio_cerrado',
            'Fuera del horario de atención.'
        );

        $horarioAtencion = TramitaNetConfiguracion::obtener(
            'horario_atencion',
            ''
        );

        $zonaHoraria = TramitaNetConfiguracion::obtener(
            'zona_horaria',
            ''
        );

        $horarioAutomatico = TramitaNetConfiguracion::obtener(
            'horario_automatico',
            false
        );

        $zonaHorariaSistema = TramitaNetConfiguracion::obtener(
            'zona_horaria_sistema',
            'America/Mazatlan'
        );

        $horarioProgramado = TramitaNetConfiguracion::obtener(
            'horario_programado',
            $this->horarioProgramadoPredeterminado()
        );

        return view(
            'admin.tramitanet.configuracion.edit',
            compact(
                'servicioAbierto',
                'mensajeAbierto',
                'mensajeCerrado',
                'horarioAtencion',
                'zonaHoraria',
                'horarioAutomatico',
                'zonaHorariaSistema',
                'horarioProgramado'
            )
        );
    }

    public function update(Request $request)
    {

        $request->validate([
            'servicio_abierto' => [
                'nullable',
                'boolean',
            ],

            'mensaje_servicio_abierto' => [
                'required',
                'string',
                'max:500',
            ],

            'mensaje_servicio_cerrado' => [
                'required',
                'string',
                'max:500',
            ],
            'horario_atencion' => [
                'required',
                'string',
                'max:1000',
            ],

            'zona_horaria' => [
                'required',
                'string',
                'max:255',
            ],
            'horario_automatico' => [
                'nullable',
                'boolean',
            ],

            'zona_horaria_sistema' => [
                'required',
                'string',
                'max:100',
            ],

            'horarios' => [
                'nullable',
                'array',
            ],

            'horarios.*' => [
                'nullable',
                'array',
            ],

            'horarios.*.*.inicio' => [
                'nullable',
                'date_format:H:i',
            ],

            'horarios.*.*.fin' => [
                'nullable',
                'date_format:H:i',
            ],
        ]);

        $horarioProgramado = $this->normalizarHorario(
            $request->input('horarios', [])
        );

        if (
            $request->boolean('horario_automatico') &&
            collect($horarioProgramado)->flatten(1)->isEmpty()
        ) {
            throw ValidationException::withMessages([
                'horarios' =>
                    'Debes configurar al menos un turno cuando el horario automático está activado.',
            ]);
        }

        $this->guardarConfiguracion(
            clave: 'servicio_abierto',
            valor: $request->boolean('servicio_abierto') ? '1' : '0',
            tipo: 'booleano'
        );

        $this->guardarConfiguracion(
            clave: 'mensaje_servicio_abierto',
            valor: trim($request->mensaje_servicio_abierto)
        );

        $this->guardarConfiguracion(
            clave: 'mensaje_servicio_cerrado',
            valor: trim($request->mensaje_servicio_cerrado)
        );

        $this->guardarConfiguracion(
            clave: 'horario_atencion',
            valor: trim($request->horario_atencion)
        );

        $this->guardarConfiguracion(
            clave: 'zona_horaria',
            valor: trim($request->zona_horaria)
        );

        $this->guardarConfiguracion(
            clave: 'horario_automatico',
            valor: $request->boolean('horario_automatico') ? '1' : '0',
            tipo: 'booleano'
        );

        $this->guardarConfiguracion(
            clave: 'zona_horaria_sistema',
            valor: trim($request->zona_horaria_sistema)
        );

        $this->guardarConfiguracion(
            clave: 'horario_programado',
            valor: json_encode(
                $horarioProgramado,
                JSON_UNESCAPED_UNICODE
            ),
            tipo: 'json'
        );

        return back()->with(
            'success',
            'Configuración de TramitaNet actualizada correctamente.'
        );


    }

    private function guardarConfiguracion(
        string $clave,
        string $valor,
        string $tipo = 'texto'
    ): void {
        TramitaNetConfiguracion::updateOrCreate(
            [
                'clave' => $clave,
            ],
            [
                'valor' => $valor,
                'tipo' => $tipo,
                'grupo' => 'tramitanet',
                'descripcion' => null,
                'editable' => true,
                'updated_by' => auth()->id(),
            ]
        );
    }

    private function horarioProgramadoPredeterminado(): array
    {
        return [
            'lunes' => [
                [
                    'inicio' => '07:00',
                    'fin' => '14:00',
                ],
                [
                    'inicio' => '15:00',
                    'fin' => '19:00',
                ],
            ],

            'martes' => [
                [
                    'inicio' => '07:00',
                    'fin' => '14:00',
                ],
                [
                    'inicio' => '15:00',
                    'fin' => '19:00',
                ],
            ],

            'miercoles' => [
                [
                    'inicio' => '07:00',
                    'fin' => '14:00',
                ],
                [
                    'inicio' => '15:00',
                    'fin' => '19:00',
                ],
            ],

            'jueves' => [
                [
                    'inicio' => '07:00',
                    'fin' => '14:00',
                ],
                [
                    'inicio' => '15:00',
                    'fin' => '19:00',
                ],
            ],

            'viernes' => [
                [
                    'inicio' => '07:00',
                    'fin' => '14:00',
                ],
                [
                    'inicio' => '15:00',
                    'fin' => '19:00',
                ],
            ],

            'sabado' => [
                [
                    'inicio' => '09:00',
                    'fin' => '13:00',
                ],
                [
                    'inicio' => '15:00',
                    'fin' => '19:00',
                ],
            ],

            'domingo' => [
                [
                    'inicio' => '09:00',
                    'fin' => '13:00',
                ],
            ],
        ];
    }

    private function normalizarHorario(array $horarios): array
    {
        $diasPermitidos = [
            'lunes',
            'martes',
            'miercoles',
            'jueves',
            'viernes',
            'sabado',
            'domingo',
        ];

        $resultado = [];

        foreach ($diasPermitidos as $dia) {
            $resultado[$dia] = [];

            $turnos = $horarios[$dia] ?? [];

            foreach ($turnos as $indice => $turno) {
                $inicio = trim((string) ($turno['inicio'] ?? ''));
                $fin = trim((string) ($turno['fin'] ?? ''));

                // Turno completamente vacío: simplemente se ignora.
                if ($inicio === '' && $fin === '') {
                    continue;
                }

                // Si capturó solo una de las dos horas.
                if ($inicio === '' || $fin === '') {
                    throw ValidationException::withMessages([
                        "horarios.$dia.$indice" =>
                            'Cada turno debe tener hora de inicio y hora de fin.',
                    ]);
                }

                // Por ahora los turnos deben terminar el mismo día.
                if ($fin <= $inicio) {
                    throw ValidationException::withMessages([
                        "horarios.$dia.$indice" =>
                            'La hora de fin debe ser posterior a la hora de inicio.',
                    ]);
                }

                $resultado[$dia][] = [
                    'inicio' => $inicio,
                    'fin' => $fin,
                ];
            }

            // Evita que dos turnos del mismo día se encimen.
            if (count($resultado[$dia]) >= 2) {
                $turno1 = $resultado[$dia][0];
                $turno2 = $resultado[$dia][1];

                if ($turno2['inicio'] < $turno1['fin']) {
                    throw ValidationException::withMessages([
                        "horarios.$dia" =>
                            'Los turnos del mismo día no pueden superponerse.',
                    ]);
                }
            }
        }

        return $resultado;
    }
}
