<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ZipArchive;

class MikrotikVoucherController extends Controller
{
    public function create()
    {
        return view('admin.netplus.mikrotik-create');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1|max:1000',
            'tiempo' => 'required|in:00:30:00,01:00:00,03:00:00,1d,1w,4w',
        ]);

        $cantidad = (int) $request->cantidad;
        $tiempo = $request->tiempo;

        $csv = "Voucher Code,Time,Bandwidth-Limit\r\n";
        $rsc = "/ip hotspot user\r\n";

        for ($i = 0; $i < $cantidad; $i++) {
            $codigo = strtolower(Str::random(6)) . random_int(10, 99);

            $csv .= "{$codigo},{$tiempo},0\r\n";
            $rsc .= "add name={$codigo} limit-uptime={$tiempo} disabled=no\r\n";
        }

        $zipName = 'mikrotik_codigos_' . now()->format('Ymd_His') . '.zip';
        $zipPath = storage_path("app/{$zipName}");

        $zip = new ZipArchive;
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFromString('air-vouchercodes.csv', $csv);
        $zip->addFromString('air-importme.rsc', $rsc);
        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
