<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProduksiController;
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
Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('auth');
Route::resource('produksi', \App\Http\Controllers\ProduksiController::class)->middleware('auth');
Route::resource('data_produksi', \App\Http\Controllers\DataProduksiController::class)->middleware('auth');
Route::resource('target', \App\Http\Controllers\TargetController::class)->middleware('auth');
Route::resource('proses', \App\Http\Controllers\ProsesController::class)->middleware('auth');
Route::resource('kelompok', \App\Http\Controllers\KelompokController::class)->middleware('auth');
Route::resource('tbketerangan', \App\Http\Controllers\TbKeteranganController::class)->middleware('auth');


Route::get('/get-kelompok-data', [ProduksiController::class, 'getKelompokData'])->name('get-kelompok-data'); 
Route::get('/get-target-quantity', [ProduksiController::class, 'getTargetQuantity'])->name('get-target-quantity'); 
Route::get('/filter-chart-data', [HomeController::class, 'filterChartData'])->middleware('auth');
Route::get('/get-proses-data', [HomeController::class, 'getProsesData']);
Auth::routes();
