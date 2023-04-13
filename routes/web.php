<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UnitController;
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

Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::post('/process-login', [AuthController::class, 'actionLogin'])->name('actionLogin');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/cities', CityController::class);
    Route::resource('/type', TypeController::class);
    Route::resource('/store', StoreController::class);
    Route::resource('/product', ProductController::class);
    Route::resource('/transaction', TransactionController::class);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});