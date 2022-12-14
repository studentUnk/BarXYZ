<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PedidoDetalleController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\ReporteController;

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


Route::get('/', function () {
    #return view('welcome');
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
Route::get('/administracion', function () {
    return view('administracion.editar_empleado');
});
*/

#Route::get('administracion/crear_empleado',[UserController::class,'create']); # Acceder a un unico recurso

Route::resource('administracion',UserController::class)->middleware('auth'); # Acceder a todas las url de empleado controller
Route::resource('pedido',PedidoController::class)->middleware('auth');
Route::resource('pedido_detalle',PedidoDetalleController::class)->middleware('auth');
Route::resource('inventario',InventarioController::class)->middleware('auth');
Route::resource('producto',ProductoController::class)->middleware('auth');
Route::resource('reporte',ReporteController::class)->middleware('auth');

/*Route::get('/pedido', function () {
    return view('pedido.consultar_pedido');
});*/
/*

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/',function() {
    return view('inicio');
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [UserController::class, 'index'])->name('home');
});

*/

Route::get('reporteInventarioDisponibleCSV', [\App\Http\Controllers\ReporteController::class,'reporteInventarioDisponibleCSV'])->name('reporteInventarioDisponibleCSV');
Route::get('reporteInventarioDisponibleXLS', [\App\Http\Controllers\ReporteController::class,'reporteInventarioDisponibleXLS'])->name('reporteInventarioDisponibleXLS');