<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\TramitaNetConfiguracion;
use Illuminate\Support\Facades\View;
use App\Services\TramitaNet\HorarioAtencionService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */


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
    }
}
