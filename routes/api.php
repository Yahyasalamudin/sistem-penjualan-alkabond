<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StoreController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransactionController;

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    // Route::resource('/product', ProductController::class);

    // Route::resource('/store', StoreController::class);
    Route::get('/stores', [StoreController::class, 'index'])->name('store.index');
    Route::post('/stores', [StoreController::class, 'store'])->name('store.store');

    Route::get('/transaction', [TransactionController::class, 'index']);
    Route::post('/transaction', [TransactionController::class, 'store']);
    Route::get('/transaction/{invoice_code}', [TransactionController::class, 'show']);
    Route::post('/transaction/{invoice_code}', [TransactionController::class, 'payment']);

    // Route::get('/profile', function (Request $request) {
    //     return auth()->user();
    // });

    //Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
