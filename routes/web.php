<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\ContratoController;
use App\Http\Controllers\Admin\PagoController;
use App\Http\Controllers\Admin\IncidenciaController;


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
});

// Panel Cajero
Route::middleware(['auth', 'role:cajero'])->prefix('cajero')->name('cajero.')->group(function () {
    Route::get('/dashboard', function () {
        return view('cajero.dashboard');
    })->name('dashboard');
});