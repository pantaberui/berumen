<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\TramitaNetConfiguracion;
use Illuminate\Support\Facades\View;

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
                $servicioAbierto = TramitaNetConfiguracion::obtener(
                    'servicio_abierto',
                    true
                );

                $mensajeAtencion = $servicioAbierto
                    ? TramitaNetConfiguracion::obtener(
                        'mensaje_servicio_abierto',
                        'Estamos en horario de atención.'
                    )
                    : TramitaNetConfiguracion::obtener(
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

                $view->with([
                    'servicioAbierto' => $servicioAbierto,
                    'mensajeAtencion' => $mensajeAtencion,
                    'horarioAtencion' => $horarioAtencion,
                    'zonaHoraria' => $zonaHoraria,
                ]);


            }
        );
    }
}
