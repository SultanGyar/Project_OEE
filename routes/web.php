<?php

use App\Http\Controllers\CycletimeProdukController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/advance', \App\Http\Controllers\AdvanceController::class)->middleware('auth');
Route::resource('produksi', \App\Http\Controllers\ProduksiController::class)->middleware('auth');
Route::resource('data_produksi', \App\Http\Controllers\DataProduksiController::class)->middleware('auth');

//membatasi akses operator ke halaman tertentu
Route::group(['middleware' => ['auth', 'role:Admin']], function () {
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('proses', \App\Http\Controllers\ProsesController::class);
    Route::resource('cycletime_produk', \App\Http\Controllers\CycletimeProdukController::class);
    Route::resource('kelompok', \App\Http\Controllers\KelompokController::class);
    Route::resource('anggota_kelompok', \App\Http\Controllers\AnggotaKelompokController::class);
    Route::resource('keterangan', \App\Http\Controllers\KeteranganController::class);
});

Route::get('/produksi/create/{kode}', [ProduksiController::class, 'createDynamic'])->name('produksi.create.dynamic');
Route::get('/get-data-auto', [ProduksiController::class, 'getDataAuto'])->name('get-data-auto'); 
Route::get('/filter-chart-data', [HomeController::class, 'filterChartData'])->middleware('auth');
Route::get('/get-proses-data', [HomeController::class, 'getProsesData']);

Route::post('produksi-import', [ProduksiController::class, 'import'])->name('produksi.import');
Route::post('cycletime-import', [CycletimeProdukController::class, 'import'])->name('cycletime.import');
Route::post('user-import', [UserController::class, 'import'])->name('user.import');

Auth::routes();
