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
use App\Http\Controllers\Admin\CostoActaEntidadController;
use App\Http\Controllers\SitemapController;


Route::get('/', [TramitaNetController::class, 'index'])
    ->name('tramitanet.index');

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
        Route::delete('quitar-producto/{rentaProducto}',    [ControlTiemposController::class, 'quitarProducto'])->name('quitar-producto');
        Route::patch('actualizar-producto/{rentaProducto}', [ControlTiemposController::class, 'actualizarProducto'])->name('actualizar-producto');
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

   Route::resource(
        'costos-actas',
        CostoActaEntidadController::class
    )
        ->parameters([
            'costos-actas' => 'costoActaEntidad',
        ])
        ->only([
            'index',
            'edit',
            'update',
        ]);



    Route::resource(
        'tramitanet/servicios',
        \App\Http\Controllers\Admin\TramitaNetServicioAdminController::class
    )
        ->except(['show', 'destroy'])
        ->names('tramitanet.servicios');


    Route::post(
        'tramitanet/servicios/{servicio}/modalidades',
        [\App\Http\Controllers\Admin\TramitaNetServicioModalidadAdminController::class, 'store']
    )->name('tramitanet.servicios.modalidades.store');


    Route::put(
        'tramitanet/servicios/{servicio}/modalidades/{modalidad}',
        [\App\Http\Controllers\Admin\TramitaNetServicioModalidadAdminController::class, 'update']
    )->name('tramitanet.servicios.modalidades.update');

    Route::post(
        'tramitanet/servicios/{servicio}/modalidades/{modalidad}/campos',
        [
            \App\Http\Controllers\Admin\TramitaNetServicioModalidadCampoAdminController::class,
            'store'
        ]
    )->name('tramitanet.servicios.modalidades.campos.store');


    Route::put(
        'tramitanet/servicios/{servicio}/modalidades/{modalidad}/campos/{campoModalidad}',
        [
            \App\Http\Controllers\Admin\TramitaNetServicioModalidadCampoAdminController::class,
            'update'
        ]
    )->name('tramitanet.servicios.modalidades.campos.update');

    Route::resource(
        'tramitanet/campos',
        \App\Http\Controllers\Admin\TramitaNetCampoAdminController::class
    )
        ->parameters([
            'campos' => 'campo',
        ])
        ->except([
            'show',
            'destroy',
        ])
        ->names('tramitanet.campos');

    Route::resource(
        'tramitanet/instituciones',
        \App\Http\Controllers\Admin\TramitaNetInstitucionAdminController::class
    )
        ->parameters([
            'instituciones' => 'institucion',
        ])
        ->except([
            'show',
            'destroy',
        ])
        ->names('tramitanet.instituciones');


}); // <-- AQUÍ cerramos Panel Admin




// Panel Cajero
Route::middleware(['auth', 'role:cajero'])->prefix('cajero')->name('cajero.')->group(function () {
    Route::get('/dashboard', function () {
        return view('cajero.dashboard');
    })->name('dashboard');

});



/*
|--------------------------------------------------------------------------
| TramitaNet público
|--------------------------------------------------------------------------
*/

Route::get('/servicio/{slug}', [TramitaNetServicioController::class, 'servicio'])
    ->name('tramitanet.servicio');

Route::get('/consulta', [TramitaNetController::class, 'consulta'])
    ->name('tramitanet.consulta');

Route::post('/consulta', [TramitaNetController::class, 'consultar'])
    ->name('tramitanet.consulta.buscar');

Route::post('/servicio/{slug}/resumen', [TramitaNetSolicitudController::class, 'resumen'])
    ->name('tramitanet.servicio.resumen');

Route::post('/servicio/{slug}/solicitar', [TramitaNetSolicitudController::class, 'store'])
    ->name('tramitanet.servicio.store');

Route::get('/folio/{folio}', [TramitaNetSolicitudController::class, 'expediente'])
    ->name('tramitanet.expediente');

Route::get('/institucion/{slug}', [TramitaNetServicioController::class, 'institucion'])
    ->name('tramitanet.institucion');

Route::get('/servicio/{slug}/{modalidad}', [TramitaNetServicioController::class, 'modalidad'])
    ->name('tramitanet.servicio.modalidad');

Route::get(
    '/folio/{folio}/documentos/{documento}/descargar',
    [TramitaNetSolicitudController::class, 'descargarDocumentoGenerado']
)->name('tramitanet.documentos-generados.descargar');

Route::post(
    '/folio/{folio}/comprobante-pago',
    [TramitaNetSolicitudController::class, 'subirComprobantePago']
)->name('tramitanet.pago.subir');

Route::get('/captcha', [TramitaNetCaptchaController::class, 'imagen'])
    ->name('tramitanet.captcha');

Route::get(
    '/expediente/{folio}/acuse',
    [TramitaNetAcuseController::class, 'descargar']
)->name('tramitanet.acuse');

Route::get('/preguntas-frecuentes', [TramitaNetController::class, 'faq'])
    ->name('tramitanet.faq');

Route::view(
    '/aviso-de-privacidad',
    'publico.tramitanet.privacidad'
)->name('tramitanet.privacidad');

Route::view(
    '/terminos-y-condiciones',
    'publico.tramitanet.terminos'
)->name('tramitanet.terminos');


Route::view(
    '/aviso-de-privacidad',
    'publico.tramitanet.aviso-privacidad'
)->name('tramitanet.aviso-privacidad');


/*
|--------------------------------------------------------------------------
| Compatibilidad con URLs antiguas
|--------------------------------------------------------------------------
*/

Route::redirect('/tramitanet', '/', 301);

Route::get('/tramitanet/servicio/{slug}', function (string $slug) {
    return redirect()->route('tramitanet.servicio', ['slug' => $slug], 301);
});

Route::get('/tramitanet/consulta', function () {
    return redirect()->route('tramitanet.consulta', status: 301);
});

Route::get('/tramitanet/folio/{folio}', function (string $folio) {
    return redirect()->route('tramitanet.expediente', ['folio' => $folio], 301);
});

Route::get('/tramitanet/institucion/{slug}', function (string $slug) {
    return redirect()->route('tramitanet.institucion', ['slug' => $slug], 301);
});

Route::get('/tramitanet/servicio/{slug}/{modalidad}', function (
    string $slug,
    string $modalidad
) {
    return redirect()->route('tramitanet.servicio.modalidad', [
        'slug' => $slug,
        'modalidad' => $modalidad,
    ], 301);
});

Route::get('/tramitanet/preguntas-frecuentes', function () {
    return redirect()->route('tramitanet.faq', status: 301);
});

Route::get('/tramitanet/aviso-de-privacidad', function () {
    return redirect()->route('tramitanet.privacidad', status: 301);
});

Route::get('/tramitanet/terminos-y-condiciones', function () {
    return redirect()->route('tramitanet.terminos', status: 301);
});

Route::get('/sitemap.xml', SitemapController::class)
    ->name('sitemap');
