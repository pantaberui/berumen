<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\TramitaNetConfiguracion;
use Illuminate\Support\Facades\View;
use App\Services\TramitaNet\HorarioAtencionService;
use App\Models\SolicitudServicio;
use App\Models\SolicitudVista;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        require_once app_path('Helpers/NumeroALetras.php');

        View::composer(
            'publico.tramitanet.*',
            function ($view) {
                $estadoHorario = HorarioAtencionService::estado();

                $servicioAbierto = $estadoHorario['abierto'];
                $mensajeAtencion = $estadoHorario['mensaje'];
                $siguienteApertura = $estadoHorario['siguiente_apertura'];
                $horarioAutomatico = $estadoHorario['automatico'];

                $horarioAtencion = TramitaNetConfiguracion::obtener(
                    'horario_atencion',
                    ''
                );

                $zonaHoraria = TramitaNetConfiguracion::obtener(
                    'zona_horaria',
                    ''
                );

                $view->with([
                    'servicioAbierto' => $servicioAbierto,
                    'mensajeAtencion' => $mensajeAtencion,
                    'horarioAtencion' => $horarioAtencion,
                    'zonaHoraria' => $zonaHoraria,
                    'siguienteApertura' => $siguienteApertura,
                    'horarioAutomatico' => $horarioAutomatico,
                ]);
            }
        );

        View::composer('*', function ($view) {
            if (auth()->check() && auth()->user()->hasRole('admin')) {
                $solicitudesNuevas = SolicitudServicio::query()
                    ->whereNotIn('id', function ($query) {
                        $query->select('solicitud_servicio_id')
                            ->from('solicitudes_vistas')
                            ->where('user_id', auth()->id());
                    })
                    ->count();

                $view->with('solicitudesNuevas', $solicitudesNuevas);
            }
        });
    }
}