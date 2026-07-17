<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\SolicitudServicio;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Route;

class TramitaNetAcuseController extends Controller
{
    public function descargar(string $folio)
    {
        $solicitud = SolicitudServicio::with([
            'servicio.institucion',
            'modalidad',
        ])
            ->where('folio', $folio)
            ->firstOrFail();

        if (!$solicitud->servicio->es_documento_oficial) {
            abort(404);
        }

        $qr = base64_encode(
            QrCode::format('svg')
                ->size(180)
                ->margin(1)
                ->generate(route('tramitanet.consulta'))
        );

        $pdf = Pdf::loadView(
            'publico.tramitanet.pdfs.acuse',
            compact('solicitud', 'qr')
        );

        return $pdf->download("acuse-{$solicitud->folio}.pdf");
    }
}
