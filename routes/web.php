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
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\MikrotikVoucherController;
use App\Http\Controllers\Admin\EstatusClientesController;
use App\Http\Controllers\Publico\TramitaNetController;
use App\Http\Controllers\Publico\TramitaNetServicioController;
use App\Http\Controllers\Publico\TramitaNetSolicitudController;
use App\Http\Controllers\Admin\TramitaNetSolicitudAdminController;
use App\Http\Controllers\Publico\TramitaNetCaptchaController;
use App\Http\Controllers\Admin\TramitaNetConfiguracionController;
use App\Http\Controllers\Publico\TramitaNetAcuseController;
use App\Http\Controllers\Admin\CatalogoCuentaBancariaController;


Route::get('/', function () {
    return redirect()->route('login');
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
    Route::get('pagos/ultimo-periodo/{contrato}', [PagoController::class, 'ultimoPeriodo'])->name('pagos.ultimo-periodo');
    Route::resource('pagos', PagoController::class);
    Route::get('incidencias/buscar', [IncidenciaController::class, 'buscar'])->name('incidencias.buscar');
    Route::post('incidencias/{incidencia}/agregar-dias', [IncidenciaController::class, 'agregarDias'])->name('incidencias.agregar-dias');

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

    // Inventarios
    Route::get('productos/inventario', [ProductoController::class, 'inventario'])->name('productos.inventario');

    // Productos
    Route::get('productos/buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');
    Route::resource('productos', ProductoController::class)->except(['show']);

    // Ventas
    Route::get('ventas/buscar-cliente',  [VentaController::class, 'buscarCliente'])->name('ventas.buscar-cliente');
    Route::get('ventas/buscar-producto', [VentaController::class, 'buscarProducto'])->name('ventas.buscar-producto');
    Route::post('ventas/{venta}/enviar-correo', [VentaController::class, 'enviarCorreo'])->name('ventas.enviar-correo');
    Route::resource('ventas', VentaController::class);

    // ultimo precio en compras
    Route::get('compras/ultimo-precio', [CompraController::class, 'ultimoPrecio'])->name('compras.ultimo-precio');

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
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/exportar', [DashboardController::class, 'exportarExcel'])->name('dashboard.exportar');

    //Respaldos
    Route::get('backup/descargar', [BackupController::class, 'descargar'])->name('backup.descargar');

    Route::get('/netplus/generar-mikrotik', [MikrotikVoucherController::class, 'create'])
        ->name('netplus.mikrotik.create');

    Route::post('/netplus/generar-mikrotik', [MikrotikVoucherController::class, 'generate'])
        ->name('netplus.mikrotik.generate');

    Route::get('estatus-clientes', [EstatusClientesController::class, 'index'])->name('estatus-clientes.index');

    Route::get('tramitanet/solicitudes', [TramitaNetSolicitudAdminController::class, 'index'])
    ->name('tramitanet.solicitudes.index');

    Route::get('tramitanet/solicitudes/{solicitud}', [TramitaNetSolicitudAdminController::class, 'show'])
        ->name('tramitanet.solicitudes.show');
    
    Route::patch('tramitanet/solicitudes/{solicitud}/estatus', [TramitaNetSolicitudAdminController::class, 'actualizarEstatus'])
        ->name('tramitanet.solicitudes.actualizar-estatus');
    
    Route::post('tramitanet/solicitudes/{solicitud}/notas', [TramitaNetSolicitudAdminController::class, 'guardarNota'])
        ->name('tramitanet.solicitudes.notas.store');

    Route::get('tramitanet/solicitudes/{solicitud}/documentos/{dato}/descargar', [TramitaNetSolicitudAdminController::class, 'descargarDocumento'])
        ->name('tramitanet.solicitudes.documentos.descargar');
    
    Route::get('tramitanet/solicitudes/{solicitud}/datos/{dato}/ver-password', [TramitaNetSolicitudAdminController::class, 'verPassword'])
        ->name('tramitanet.solicitudes.datos.ver-password');
    
    Route::post('tramitanet/solicitudes/{solicitud}/documentos-generados', [TramitaNetSolicitudAdminController::class, 'subirDocumentoGenerado'])
        ->name('tramitanet.solicitudes.documentos-generados.store');

    Route::patch('tramitanet/pagos/{pago}/validar', [TramitaNetSolicitudAdminController::class, 'validarPago'])
        ->name('tramitanet.pagos.validar');

    Route::patch('tramitanet/pagos/{pago}/rechazar', [TramitaNetSolicitudAdminController::class, 'rechazarPago'])
        ->name('tramitanet.pagos.rechazar');

    Route::get('tramitanet/pagos/{pago}/ver', [TramitaNetSolicitudAdminController::class, 'verPago'])
        ->name('tramitanet.pagos.ver');

    Route::get('tramitanet/pagos/{pago}/descargar', [TramitaNetSolicitudAdminController::class, 'descargarPago'])
        ->name('tramitanet.pagos.descargar');
    
    Route::post('/tramitanet/servicio/{slug}/resumen', [TramitaNetSolicitudController::class, 'resumen'])
        ->name('tramitanet.servicio.resumen');

    Route::post('/tramitanet/servicio/{slug}/guardar', [TramitaNetSolicitudController::class, 'store'])
        ->name('tramitanet.servicio.store');  

    Route::get(
        '/tramitanet/configuracion',
        [TramitaNetConfiguracionController::class, 'edit']
    )->name('tramitanet.configuracion.edit');

    Route::patch(
        '/tramitanet/configuracion',
        [TramitaNetConfiguracionController::class, 'update']
    )->name('tramitanet.configuracion.update');

    Route::resource(
        'catalogo-cuentas-bancarias',
        CatalogoCuentaBancariaController::class
    )
        ->parameters([
            'catalogo-cuentas-bancarias' => 'catalogoCuentaBancaria',
        ])
        ->except('show');
    

});

// Panel Cajero
Route::middleware(['auth', 'role:cajero'])->prefix('cajero')->name('cajero.')->group(function () {
    Route::get('/dashboard', function () {
        return view('cajero.dashboard');
    })->name('dashboard');
});


Route::get('/tramitanet', [TramitaNetController::class, 'index'])
    ->name('tramitanet.index');

Route::get('/tramitanet/servicio/{slug}', [TramitaNetServicioController::class, 'servicio'])
    ->name('tramitanet.servicio');

Route::get('/tramitanet/consulta', [TramitaNetController::class, 'consulta'])
    ->name('tramitanet.consulta');

Route::post('/tramitanet/consulta', [TramitaNetController::class, 'consultar'])
    ->name('tramitanet.consulta.buscar');

Route::post('/tramitanet/servicio/{slug}/resumen', [TramitaNetSolicitudController::class, 'resumen'])
    ->name('tramitanet.servicio.resumen');

Route::post('/tramitanet/servicio/{slug}/solicitar', [TramitaNetSolicitudController::class, 'store'])
    ->name('tramitanet.servicio.store');


Route::get('/tramitanet/folio/{folio}', [TramitaNetSolicitudController::class, 'expediente'])
    ->name('tramitanet.expediente');

Route::get('/tramitanet/institucion/{slug}', [TramitaNetServicioController::class, 'institucion'])
    ->name('tramitanet.institucion');

Route::get('/tramitanet/servicio/{slug}/{modalidad}', [TramitaNetServicioController::class, 'modalidad'])
    ->name('tramitanet.servicio.modalidad');

Route::get('/tramitanet/folio/{folio}/documentos/{documento}/descargar', [TramitaNetSolicitudController::class, 'descargarDocumentoGenerado'])
    ->name('tramitanet.documentos-generados.descargar');

Route::post('/tramitanet/folio/{folio}/comprobante-pago', [TramitaNetSolicitudController::class, 'subirComprobantePago'])
    ->name('tramitanet.pago.subir');

Route::get(
    '/tramitanet/captcha',
    [TramitaNetCaptchaController::class, 'imagen']
)->name('tramitanet.captcha');

Route::get(
    '/tramitanet/expediente/{folio}/acuse',
    [TramitaNetAcuseController::class, 'descargar']
)->name('tramitanet.acuse');