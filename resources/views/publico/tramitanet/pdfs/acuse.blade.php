<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 32px 38px 48px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #0f172a;
            line-height: 1.45;
        }

        .encabezado {
            width: 100%;
            border-bottom: 3px solid #1d4ed8;
            padding-bottom: 14px;
            margin-bottom: 24px;
            
        }

        .marca {
            font-size: 24px;
            font-weight: bold;
            color: #1d4ed8;
        }

        .submarca {
            margin-top: 3px;
            font-size: 11px;
            color: #475569;
        }

        .titulo {
            text-align: center;
            margin-bottom: 24px;
        }

        .titulo h1 {
            margin: 0;
            font-size: 22px;
            color: #0f172a;
        }

        .titulo p {
            margin: 6px 0 0;
            color: #64748b;
        }

        .confirmacion {
            border: 1px solid #bbf7d0;
            background: #f0fdf4;
            padding: 14px;
            margin-bottom: 20px;
        }

        .confirmacion strong {
            color: #166534;
        }

        .tabla-datos {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .tabla-datos td {
            border: 1px solid #e2e8f0;
            padding: 10px;
            vertical-align: top;
        }

        .tabla-datos .etiqueta {
            width: 34%;
            font-weight: bold;
            background: #f8fafc;
            color: #475569;
        }

        .dato-destacado {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
        }

        .aviso {
            border: 1px solid #bfdbfe;
            background: #eff6ff;
            padding: 14px;
            margin-top: 20px;
            color: #1e3a8a;
        }

        .pie {
            position: fixed;
            bottom: -24px;
            left: 0;
            right: 0;
            border-top: 1px solid #cbd5e1;
            padding-top: 8px;
            text-align: center;
            font-size: 9px;
            color: #64748b;
        }
    </style>
</head>

<body>

    <table style="width:100%; margin-bottom:20px;">
        <tr>
            <td style="width:75%; vertical-align:top; border:none;">
                <img
                    src="{{ public_path('images/logo-horizontal.png') }}"
                    style="height:100px;"
                >
            </td>

            <td style="width:25%; text-align:right; border:none;">

                <img
                    src="data:image/png;base64,{{ $qr }}"
                    style="width:75px;">

                <div style="font-size:9px; color:#555; margin-top:4px;">
                    Escanee para consultar
                    el estado de su solicitud
                </div>

            </td>
        </tr>
    </table>


    <div class="titulo">
        <h1>Acuse de solicitud</h1>

        <p>
            Comprobante de recepción de trámite
        </p>
    </div>

    

    <div class="confirmacion">
        <strong>Solicitud registrada correctamente.</strong><br>
        Conserva este documento y tus datos de seguimiento.
    </div>

    <table class="tabla-datos">
        <tr>
            <td class="etiqueta">
                Folio
            </td>

            <td class="dato-destacado">
                {{ $solicitud->folio }}
            </td>
        </tr>

        <tr>
            <td class="etiqueta">
                Código de seguimiento
            </td>

            <td class="dato-destacado">
                {{ $solicitud->codigo_consulta }}
            </td>
        </tr>

        <tr>
            <td class="etiqueta">
                Fecha y hora de registro
            </td>

            <td>
                {{ $solicitud->created_at->format('d/m/Y H:i') }} hrs
            </td>
        </tr>

        <tr>
            <td class="etiqueta">
                Institución
            </td>

            <td>
                {{ $solicitud->servicio->institucion->nombre ?? 'Servicio' }}
            </td>
        </tr>

        <tr>
            <td class="etiqueta">
                Trámite
            </td>

            <td>
                {{ $solicitud->servicio->titulo_publico
                    ?? $solicitud->servicio->nombre }}
            </td>
        </tr>

        <tr>
            <td class="etiqueta">
                Modalidad
            </td>

            <td>
                {{ $solicitud->modalidad->nombre ?? 'No especificada' }}
            </td>
        </tr>

        <tr>
            <td class="etiqueta">
                Estado actual
            </td>

            <td>
                {{ strtoupper(str_replace('_', ' ', $solicitud->estatus)) }}
            </td>
        </tr>

        @if($solicitud->referencia_pago)
            <tr>
                <td class="etiqueta">
                    Referencia de pago
                </td>

                <td>
                    {{ $solicitud->referencia_pago }}
                </td>
            </tr>
        @endif
    </table>

    <div class="aviso">
        <strong>Importante:</strong><br>
        Este documento acredita únicamente la recepción de la solicitud.
        No representa la conclusión ni la entrega del trámite solicitado.
    </div>

    <div class="pie">
        Consulta el estado actualizado de tu trámite en TramitaNet utilizando
        tu folio y código de seguimiento.
    </div>

</body>
</html>