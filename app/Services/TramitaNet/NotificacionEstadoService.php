<?php

namespace App\Services\TramitaNet;

use App\Models\SolicitudServicio;

class NotificacionEstadoService
{
    public static function obtener(
        SolicitudServicio $solicitud,
        ?string $evento = null
    ): array {

        /*
         |----------------------------------------------------------
         | Eventos especiales
         |----------------------------------------------------------
         */

        if ($evento === 'pago_rechazado') {
            return [
                'asunto' => 'Pago rechazado',
                'titulo' => 'Tu comprobante de pago fue rechazado',
                'mensaje' =>
                    'Revisa el motivo indicado y carga un nuevo comprobante desde tu expediente.',
                'mostrarObservacion' => true,
            ];
        }

        /*
         |----------------------------------------------------------
         | Estados normales
         |----------------------------------------------------------
         */

        return match ($solicitud->estatus) {

            'esperando_pago' => [
                'asunto' => 'Esperando pago',
                'titulo' => 'Tu solicitud está en espera de pago',
                'mensaje' =>
                    'Ya puedes consultar la referencia y realizar tu pago.',
                'mostrarObservacion' => true,
            ],

            'pago_en_revision' => [
                'asunto' => 'Pago en revisión',
                'titulo' => 'Estamos revisando tu comprobante',
                'mensaje' =>
                    'Nuestro personal validará la información en breve.',
                'mostrarObservacion' => false,
            ],

            'pago_confirmado' => [
                'asunto' => 'Pago confirmado',
                'titulo' => 'Tu pago fue confirmado',
                'mensaje' =>
                    'El pago fue validado correctamente. Comenzaremos la gestión de tu trámite.',
                'mostrarObservacion' => false,
            ],

            'en_gestion' => [
                'asunto' => 'En gestión',
                'titulo' => 'Tu trámite está siendo gestionado',
                'mensaje' =>
                    'Nuestro personal ya se encuentra realizando las gestiones correspondientes.',
                'mostrarObservacion' => false,
            ],

            'informacion_requerida' => [
                'asunto' => 'Información requerida',
                'titulo' => 'Necesitamos información adicional',
                'mensaje' =>
                    'Consulta tu expediente para conocer la información solicitada.',
                'mostrarObservacion' => true,
            ],

            'entregado' => [
                'asunto' => 'Trámite concluido',
                'titulo' => '¡Tu trámite ha concluido!',
                'mensaje' =>
                    'Ya puedes ingresar a tu expediente para descargar tu documento.',
                'mostrarObservacion' => false,
            ],

            'cancelado' => [
                'asunto' => 'Solicitud cancelada',
                'titulo' => 'Tu solicitud fue cancelada',
                'mensaje' =>
                    'Consulta tu expediente para conocer el motivo.',
                'mostrarObservacion' => true,
            ],

            default => [
                'asunto' => 'Actualización',
                'titulo' => 'El estado de tu solicitud cambió',
                'mensaje' =>
                    'Consulta tu expediente para conocer el avance.',
                'mostrarObservacion' => false,
            ],
        };
    }
}