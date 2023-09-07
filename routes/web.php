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

Route::get('/get-target-quantity', [ProduksiController::class, 'getTargetQuantity']);

Route::get('/filter-chart-data', [HomeController::class, 'filterChartData'])->middleware('auth');
Route::get('/get-data-for-chart', [HomeController::class, 'getDataForChart']);
Route::get('/get-data-for-performance-chart', [HomeController::class, 'getDataForPerformanceChart']);
Route::get('/get-data-for-quality-chart', [HomeController::class, 'getDataForQualityChart']);
Route::get('/get-data-for-availability-chart', [HomeController::class, 'getDataForAvailabilityChart']);
Auth::routes();

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');
