<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TramitaNetConfiguracion;
use Illuminate\Http\Request;

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

        return view(
            'admin.tramitanet.configuracion.edit',
            compact(
                'servicioAbierto',
                'mensajeAbierto',
                'mensajeCerrado',
                'horarioAtencion',
                'zonaHoraria'
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
        ]);

        $this->guardarConfiguracion(
            clave: 'servicio_abierto',
            valor: $request->boolean('servicio_abierto') ? '1' : '0'
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

        return back()->with(
            'success',
            'Configuración de TramitaNet actualizada correctamente.'
        );
    }

    private function guardarConfiguracion(
        string $clave,
        string $valor
    ): void {
        TramitaNetConfiguracion::where('clave', $clave)
            ->update([
                'valor' => $valor,
                'updated_by' => auth()->id(),
            ]);
    }
}
