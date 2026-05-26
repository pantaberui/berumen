<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    public function descargar()
    {
        $db       = config('database.connections.mysql.database');
        $user     = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host     = config('database.connections.mysql.host');
        $port     = config('database.connections.mysql.port');
        $fecha    = now()->format('Y-m-d_H-i-s');
        $archivo  = storage_path("app/backups/backup_{$db}_{$fecha}.sql");

        // Crear carpeta si no existe
        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        // Ruta completa de mysqldump en Windows/Laragon
        $mysqldump = 'C:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin\\mysqldump.exe';

        // Si no existe esa ruta buscar en PATH
        if (!file_exists($mysqldump)) {
            $mysqldump = 'mysqldump';
        }

        $cmd = "\"{$mysqldump}\" --host={$host} --port={$port} --user={$user} --password=\"{$password}\" {$db} > \"{$archivo}\" 2>&1";

        exec($cmd, $output, $code);

        if ($code !== 0 || !file_exists($archivo) || filesize($archivo) === 0) {
            // Mostrar error detallado
            $error = implode("\n", $output);
            return back()->with('error', "Error al generar el respaldo. Código: {$code}. Detalle: {$error}");
        }

        return response()->download($archivo, "backup_{$db}_{$fecha}.sql")->deleteFileAfterSend(true);
    }
}
