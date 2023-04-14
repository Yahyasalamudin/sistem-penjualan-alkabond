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

    // CRUD Data City
    Route::get('/cities', [CityController::class, 'index'])->name('city.index');
    Route::post('/cities', [CityController::class, 'store'])->name('city.store');
    Route::get('/city/{id}/edit', [CityController::class, 'edit'])->name('city.edit');
    Route::put('/city/{id}/update', [CityController::class, 'update'])->name('city.update');
    Route::delete('/city/{id}/delete', [CityController::class, 'destroy'])->name('city.destroy');

    // CRUD Data Type Product
    Route::get('/types', [TypeController::class, 'index'])->name('type.index');
    Route::post('/types', [TypeController::class, 'store'])->name('type.store');
    Route::get('/type/{id}/edit', [TypeController::class, 'edit'])->name('type.edit');
    Route::put('/type/{id}/update', [TypeController::class, 'update'])->name('type.update');
    Route::delete('/type/{id}/delete', [TypeController::class, 'destroy'])->name('type.destroy');

    // CRUD Data Store
    Route::get('/stores', [StoreController::class, 'index'])->name('store.index');
    Route::post('/stores', [StoreController::class, 'store'])->name('store.store');
    Route::get('/store/{id}/edit', [StoreController::class, 'edit'])->name('store.edit');
    Route::put('/store/{id}/update', [StoreController::class, 'update'])->name('store.update');
    Route::delete('/store/{id}/delete', [StoreController::class, 'destroy'])->name('store.destroy');

    // CRUD Data Product
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::post('/products', [ProductController::class, 'store'])->name('product.store');
    // Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    // Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}/delete', [ProductController::class, 'destroy'])->name('product.destroy');

    // Transaction
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/transactions/detail-transaction/{invoice_code}', [TransactionController::class, 'show'])->name('transaction.show');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
