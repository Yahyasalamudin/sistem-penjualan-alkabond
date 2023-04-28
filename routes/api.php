<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\DashboardController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransactionController;

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/product?type={type}', [ProductController::class, 'index']);
    Route::get('/product-type', [ProductController::class, 'getProductTypes']);

    // Route::resource('/store', StoreController::class);
    Route::get('/stores', [StoreController::class, 'index'])->name('store.index');
    Route::post('/stores', [StoreController::class, 'store'])->name('store.store');

    Route::get('/transaction/all', [TransactionController::class, 'index']);
    Route::post('/transaction', [TransactionController::class, 'store']);
    Route::get('/transaction/{id}', [TransactionController::class, 'show']);
    Route::post('/transaction/{id}', [TransactionController::class, 'payment']);
    Route::post('/transaction/{id}/confirm', [TransactionController::class, 'confirmDeliverySuccess']);

    Route::post('/transaction-detail/{id}/return', [TransactionController::class, 'storeReturn']);
    Route::delete('/transaction-detail/{id}/destroy', [TransactionController::class, 'destroyReturn']);

    // Route::get('/profile', function (Request $request) {
    //     return auth()->user();
    // });

    //Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});