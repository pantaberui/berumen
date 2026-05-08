<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\ContratoController;
use App\Http\Controllers\Admin\PagoController;
use App\Http\Controllers\Admin\IncidenciaController;
use App\Http\Controllers\Admin\TipoServicioController;
use App\Http\Controllers\Admin\PagoServicioController;


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
});

// Panel Cajero
Route::middleware(['auth', 'role:cajero'])->prefix('cajero')->name('cajero.')->group(function () {
    Route::get('/dashboard', function () {
        return view('cajero.dashboard');
    })->name('dashboard');
});