<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\ContratoController;
use App\Http\Controllers\Admin\PagoController;
use App\Http\Controllers\Admin\IncidenciaController;
use App\Http\Controllers\Admin\TipoServicioController;
use App\Http\Controllers\Admin\PagoServicioController;
use App\Http\Controllers\Admin\CodigoNetplusController;
use App\Http\Controllers\Admin\FichaWifiController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';



// Panel Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {        
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('clientes/buscar', [ClienteController::class, 'buscar'])->name('clientes.buscar');
    Route::resource('clientes', ClienteController::class);
    Route::get('contratos/buscar',   [ContratoController::class,   'buscar'])->name('contratos.buscar');
    Route::resource('contratos', ContratoController::class);
    Route::get('pagos/buscar',       [PagoController::class,       'buscar'])->name('pagos.buscar');
    Route::post('pagos/{pago}/enviar-correo', [PagoController::class, 'enviarCorreo'])->name('pagos.enviar-correo');
    Route::resource('pagos', PagoController::class);
    Route::get('incidencias/buscar', [IncidenciaController::class, 'buscar'])->name('incidencias.buscar');
    Route::resource('incidencias', IncidenciaController::class);
    Route::resource('tipo-servicios', TipoServicioController::class)->except(['show']);
    Route::get('pagos-servicios/buscar-cliente', [PagoServicioController::class, 'buscarCliente'])->name('pagos-servicios.buscar-cliente');
    Route::get('pagos-servicios/ultima-referencia', [PagoServicioController::class, 'ultimaReferencia'])->name('pagos-servicios.ultima-referencia');
    Route::resource('pagos-servicios', PagoServicioController::class)->parameters(['pagos-servicios' => 'pagoServicio']);
    Route::post('pagos-servicios/{pagoServicio}/enviar-correo', [PagoServicioController::class, 'enviarCorreo'])->name('pagos-servicios.enviar-correo');

    // Fichas WiFi
    Route::get('fichas-wifi',              [FichaWifiController::class, 'create'])->name('fichas-wifi.create');
    Route::post('fichas-wifi/vender',      [FichaWifiController::class, 'vender'])->name('fichas-wifi.vender');
    Route::get('fichas-wifi/ticket/{codigoNetplus}', [FichaWifiController::class, 'ticket'])->name('fichas-wifi.ticket');
    Route::get('fichas-wifi/buscar',       [FichaWifiController::class, 'buscar'])->name('fichas-wifi.buscar');

    // Códigos NetPlus (solo admin)
    Route::get('codigos-netplus',                      [CodigoNetplusController::class, 'index'])->name('codigos-netplus.index');
    Route::post('codigos-netplus/cargar',              [CodigoNetplusController::class, 'cargar'])->name('codigos-netplus.cargar');
    Route::get('codigos-netplus/recientes',            [CodigoNetplusController::class, 'listarRecientes'])->name('codigos-netplus.recientes');
    Route::patch('codigos-netplus/{codigoNetplus}/cancelar', [CodigoNetplusController::class, 'cancelar'])->name('codigos-netplus.cancelar');
    Route::get('codigos-netplus/reporte', [CodigoNetplusController::class, 'reporte'])->name('codigos-netplus.reporte');
    
});

// Panel Cajero
Route::middleware(['auth', 'role:cajero'])->prefix('cajero')->name('cajero.')->group(function () {
    Route::get('/dashboard', function () {
        return view('cajero.dashboard');
    })->name('dashboard');
});