<?php

namespace App\Services\TramitaNet;

use App\Models\SolicitudServicio;

class ProximaAccionService
{
    public static function obtener(SolicitudServicio $solicitud): array
    {
        return match ($solicitud->estatus) {
            'solicitado' => [
                'icono' => '📥',
                'titulo' => 'Revisar solicitud',
                'descripcion' => 'Verifica que la información y documentos recibidos estén completos para continuar.',
            ],

            'esperando_pago' => [
                'icono' => '💰',
                'titulo' => 'Esperar pago',
                'descripcion' => 'Espera la confirmación del pago o verifica manualmente la transferencia o depósito.',
            ],

            'pago_en_revision' => [
                'icono' => '🧾',
                'titulo' => 'Revisar comprobante',
                'descripcion' => 'Verifica que el comprobante de pago corresponda al importe y referencia de la solicitud.',
            ],

            'pago_confirmado' => [
                'icono' => '⚙️',
                'titulo' => 'Iniciar gestión',
                'descripcion' => 'Realiza el trámite correspondiente con la información recibida.',
            ],

            'en_gestion' => [
                'icono' => '📄',
                'titulo' => 'Preparar entrega',
                'descripcion' => 'Cuando tengas el documento final, súbelo al expediente y cambia el estado a entregado.',
            ],

            'entregado' => [
                'icono' => '✅',
                'titulo' => 'Trámite concluido',
                'descripcion' => 'No hay acciones pendientes para esta solicitud.',
            ],

            default => [
                'icono' => 'ℹ️',
                'titulo' => 'Revisar expediente',
                'descripcion' => 'Consulta la información del expediente para determinar el siguiente paso.',
            ],
        };
    }
}
