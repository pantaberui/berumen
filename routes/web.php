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
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\VentaController;
use App\Http\Controllers\Admin\CompraController;
use App\Http\Controllers\Admin\ControlTiemposController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\TipoTramiteController;
use App\Http\Controllers\Admin\TramiteController;




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

    // Productos
    Route::get('productos/buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');
    Route::resource('productos', ProductoController::class)->except(['show']);

    // Ventas
    Route::get('ventas/buscar-cliente',  [VentaController::class, 'buscarCliente'])->name('ventas.buscar-cliente');
    Route::get('ventas/buscar-producto', [VentaController::class, 'buscarProducto'])->name('ventas.buscar-producto');
    Route::post('ventas/{venta}/enviar-correo', [VentaController::class, 'enviarCorreo'])->name('ventas.enviar-correo');
    Route::resource('ventas', VentaController::class);

    // Compras
    Route::resource('compras', CompraController::class);

    Route::prefix('control-tiempos')->name('control-tiempos.')->group(function () {
        Route::get('/',                              [ControlTiemposController::class, 'index'])->name('index');
        Route::post('iniciar',                       [ControlTiemposController::class, 'iniciarRenta'])->name('iniciar');
        Route::post('pausar/{renta}',                [ControlTiemposController::class, 'pausarRenta'])->name('pausar');
        Route::post('reanudar/{renta}',              [ControlTiemposController::class, 'reanudarRenta'])->name('reanudar');
        Route::post('cambiar-equipo/{renta}',        [ControlTiemposController::class, 'cambiarEquipo'])->name('cambiar-equipo');
        Route::post('agregar-producto/{renta}',      [ControlTiemposController::class, 'agregarProducto'])->name('agregar-producto');
        Route::get('calcular-cobro/{renta}',         [ControlTiemposController::class, 'calcularCobro'])->name('calcular-cobro');
        Route::post('cobrar/{renta}',                [ControlTiemposController::class, 'cobrar'])->name('cobrar');
        Route::get('estado/{renta}',                 [ControlTiemposController::class, 'estadoActual'])->name('estado');
        Route::get('reporte',                        [ControlTiemposController::class, 'reporte'])->name('reporte');
        Route::post('asignar-tiempo/{renta}', [ControlTiemposController::class, 'asignarTiempo'])->name('asignar-tiempo');         
    });

    Route::resource('usuarios', UsuarioController::class)->except(['show']);

    // Tipo Trámites
    Route::resource('tipo-tramites', TipoTramiteController::class)->except(['show']);

    // Trámites
    Route::get('tramites/buscar-cliente', [TramiteController::class, 'buscarCliente'])->name('tramites.buscar-cliente');
    Route::post('tramites/{tramite}/enviar-correo', [TramiteController::class, 'enviarCorreo'])->name('tramites.enviar-correo');
    Route::resource('tramites', TramiteController::class);
    
});

// Panel Cajero
Route::middleware(['auth', 'role:cajero'])->prefix('cajero')->name('cajero.')->group(function () {
    Route::get('/dashboard', function () {
        return view('cajero.dashboard');
    })->name('dashboard');
});