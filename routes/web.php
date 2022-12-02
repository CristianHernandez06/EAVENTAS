<?php

use App\Http\Controllers\ExportController;
use App\Http\Livewire\AsignarController;
use App\Http\Livewire\CashoutController;
use App\Http\Livewire\CategoriesController;
use App\Http\Livewire\CoinsController;
use App\Http\Livewire\PermisosController;
use App\Http\Livewire\PosController;
use App\Http\Livewire\ProductsController;
use App\Http\Livewire\ReportsController;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\UsersController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () { //estamos aplicando un middleware que se encarga de que el usuario este autenticado.
    Route::get('categories', CategoriesController::class);
    Route::get('products', ProductsController::class);
    Route::get('coins', CoinsController::class);
    Route::get('pos', PosController::class);

    //Route::group(['middleware' => ['role:Admin']], function () { //que solo el usuario admin puede ver roles, permisos y asignar
        Route::get('roles', RolesController::class);
        Route::get('permisos', PermisosController::class);
        Route::get('asignar', AsignarController::class);
    //});

    Route::get('users', UsersController::class);
    Route::get('cashout', CashoutController::class);
    Route::get('reports', ReportsController::class);

//::::::::::::::::rutas para exportar los reportes:::::::::::::

//reporte pdf en rango de fechas
    Route::get('report/pdf/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reportPDF']);
//reporte pdf fecha actual
    Route::get('report/pdf/{user}/{type}', [ExportController::class, 'reportPDF']);

//reportes excel

//reporte excel en rango de fechas
    Route::get('report/excel/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reporteExcel']);
//reporte excel fecha actual
    Route::get('report/excel/{user}/{type}', [ExportController::class, 'reporteExcel']);
});
