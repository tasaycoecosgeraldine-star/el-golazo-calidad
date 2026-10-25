<?php

use App\Http\Controllers\PanelAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AperturaCierreController;
use App\Http\Controllers\AperturaCierrePController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MPerfilController;
use App\Http\Controllers\ConfiguracionEmpresaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ListadoRegistroController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\ReporteRangoController;
use App\Http\Controllers\ReporteRango1Controller;
use App\Http\Controllers\ReporteMensualController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\EgresoController;
use App\Http\Controllers\ReporteCajaController;
use App\Http\Controllers\UMedidaController;

// CLIENTE
use App\Http\Controllers\RegistroClienteController;
use App\Http\Controllers\ListadoRegistroCliController;
use App\Http\Controllers\MPerfilClienteController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');

// });
Route::get('/', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

// Route::get('/login', function () {
//         return view('auth.login');
// })->name('login')->middleware('guest');

// Login
Route::post('/login', [LoginController::class, 'login']);
Route::put('/login', [LoginController::class, 'logout']);


// Create new user
Route::get('/register', [LoginController::class, 'signup'])->name('register');
Route::post('/create-user', [LoginController::class, 'customSignup'])->name('user.registration');

// Password reset


// Route::middleware(['middleware'=>'PreventBackHistory'])->group(function () {

Auth::routes();
// });

// Route::post('change-password',[LoginController::class,'changePassword'])->name('adminChangePassword');

//vista
// Route::get('almacen/categoria','CategoriaController');
Route::resource('panel_control',PanelAdminController::class);

Route::resource('almacen/categoria', CategoriaController::class);
Route::resource('almacen/producto', ProductoController::class);
Route::resource('acceso/usuario', UsuarioController::class);
Route::resource('configuracion/ajustes', ConfiguracionEmpresaController::class);
Route::resource('configuracion/mi_perfil', MPerfilController::class);
Route::resource('registro/cliente', ClienteController::class);
Route::resource('registro/registro', RegistroController::class);
Route::resource('registro/listado', ListadoRegistroController::class);
Route::resource('ventas/venta', VentaController::class);
Route::resource('compras/compra', CompraController::class);
Route::resource('compras/proveedor', ProveedorController::class);
Route::resource('configuracion/localidad', LocalidadController::class);
Route::resource('reporte/caja', ReporteCajaController::class);
Route::resource('reporte/rango', ReporteRangoController::class);
Route::resource('reporte/rango1', ReporteRango1Controller::class);
Route::resource('reporte/pago', PagoController::class);
Route::resource('reporte/mensual', ReporteMensualController::class);
Route::resource('caja/apertura_cierre', AperturaCierreController::class);
Route::resource('caja/apertura_cierre_p', AperturaCierrePController::class);
Route::resource('caja/ingreso', IngresoController::class);
Route::resource('caja/egreso', EgresoController::class);
Route::resource('configuracion/unidad_medida', UMedidaController::class);


// Full Calendar
Route::get('/registro/listar/{id}', 'App\Http\Controllers\RegistroController@listar');
Route::post('/registro/guardar/', 'App\Http\Controllers\RegistroController@guardar');
Route::post('/registro/editar/', 'App\Http\Controllers\RegistroController@editar');
Route::post('/registro/editar2/', 'App\Http\Controllers\RegistroController@editar2');

// Full Calendar CLIENTE
Route::get('/registroCliente/listar/{id}', 'App\Http\Controllers\RegistroClienteController@listar');
Route::post('/registroCliente/guardar/', 'App\Http\Controllers\RegistroClienteController@guardar');
Route::post('/registroCliente/editar/', 'App\Http\Controllers\RegistroClienteController@editar');
Route::post('/registroCliente/editar2/', 'App\Http\Controllers\RegistroClienteController@editar2');

// Reportes PDF
Route::get('/register-pdf/{id}', [App\Http\Controllers\RegistroController::class, 'exportPdf'])->name('one-register.pdf');
Route::get('/sale-pdf/{id}', [App\Http\Controllers\VentaController::class, 'exportPdf'])->name('one-sale.pdf');
Route::get('/list-register-pdf/{id}/{id2}/{id3}', [App\Http\Controllers\ListadoRegistroController::class, 'listpdf'])->name('list-register.pdf');
Route::get('/list-producto-pdf/{id}/{id2}', [App\Http\Controllers\ProductoController::class, 'listpdf'])->name('list-producto.pdf');
Route::get('/list-cliente-pdf/{id}', [App\Http\Controllers\ClienteController::class, 'listpdf'])->name('list-cliente.pdf');
Route::get('/list-venta-pdf/{id}', [App\Http\Controllers\VentaController::class, 'listpdf'])->name('list-venta.pdf');
Route::get('/rango/{id}/{id2}/{id3}/{id4}', [App\Http\Controllers\ReporteRangoController::class, 'reportPdf'])->name('rango.pdf');
Route::get('/rango1/{id}/{id2}/{id3}/{id4}', [App\Http\Controllers\ReporteRango1Controller::class, 'reportPdf'])->name('rango1.pdf');
Route::get('/mensual/{id}/{id2}/{id3}', [App\Http\Controllers\ReporteMensualController::class, 'reportPdf'])->name('mensual.pdf');
Route::get('/arqueo_caja/{id}', [App\Http\Controllers\AperturaCierreController::class, 'reportPdf'])->name('arqueo_caja.pdf');

Route::get('/list_compra/{id}/{id2}', [App\Http\Controllers\CompraController::class, 'list_compra'])->name('list_compra.pdf');

// Reportes en Excel
Route::get('/rango_excel/{id}/{id2}/{id3}/{id4}', [App\Http\Controllers\ReporteRangoController::class, 'reportExcel'])->name('rango_excel.excel');
Route::get('/rango_excel1/{id}/{id2}/{id3}/{id4}', [App\Http\Controllers\ReporteRango1Controller::class, 'reportExcel'])->name('rango_excel1.excel');
Route::get('/producto_excel/{id}/{id2}', [App\Http\Controllers\ProductoController::class, 'reportExcel'])->name('producto_excel.excel');
Route::get('/mensual_excel/{id}/{id2}/{id3}', [App\Http\Controllers\ReporteMensualController::class, 'reportExcel'])->name('mensual_excel.excel');
Route::get('/list_compra_e/{id}/{id2}', [App\Http\Controllers\CompraController::class, 'list_compraE'])->name('list_compra.excel');
Route::get('/list_compraDetalladoE/{id}/{id2}', [App\Http\Controllers\CompraController::class, 'list_compraDetalladoE'])->name('list_compraDetalladoE.excel');


// Rutas Extras

Route::post('store_pago', [ReporteRangoController::class, 'store_pago'])->name('store_pago');
Route::delete('eliminarPago/{id}', [ReporteRangoController::class, 'eliminarPago'])->name('eliminarPago');

// CLIENTE
Route::resource('registroCliente/registro', RegistroClienteController::class);
Route::resource('registroCliente/mis_reservas', ListadoRegistroCliController::class);
Route::resource('configuracion/mi_perfil_c', MPerfilClienteController::class);


// Reportes PDF CLIENTE
Route::get('/registerc-pdf/{id}', [App\Http\Controllers\RegistroClienteController::class, 'exportPdf'])->name('one_registerc.pdf');
