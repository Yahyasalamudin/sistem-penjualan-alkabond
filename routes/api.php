<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransactionController;

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    // Route::resource('/product', ProductController::class);

    // Route::get('/logi', function () {
    //     dd(auth()->user());
    // });

    // Route::resource('/store', StoreController::class);

    Route::resource('/transaction', TransactionController::class);


    // Route::get('/profile', function (Request $request) {
    //     return auth()->user();
    // });

    //Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
