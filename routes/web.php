<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
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
    Route::put('/city/{id}/update', [CityController::class, 'update'])->name('city.update');
    Route::delete('/city/{id}/delete', [CityController::class, 'destroy'])->name('city.destroy');

    // CRUD Data Type Product
    Route::get('/types', [TypeController::class, 'index'])->name('type.index');
    Route::post('/types', [TypeController::class, 'store'])->name('type.store');
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
    Route::get('/transactions/{status}', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/transactions/{status}/detail-transaction/{id}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::put('/transactions/{delivery_status}/{id}', [TransactionController::class, 'update_delivery'])->name('transaction.update');

    // User
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/users/create', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/show/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // Sales
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SalesController::class, 'create'])->name('sales.create');
    Route::post('/sales/create', [SalesController::class, 'store'])->name('sales.store');
    Route::get('/sales/show/{id}', [SalesController::class, 'show'])->name('sales.show');
    Route::get('/sales/edit/{id}', [SalesController::class, 'edit'])->name('sales.edit');
    Route::put('/sales/update/{id}', [SalesController::class, 'update'])->name('sales.update');
    Route::delete('/sales/delete/{id}', [SalesController::class, 'destroy'])->name('sales.destroy');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
