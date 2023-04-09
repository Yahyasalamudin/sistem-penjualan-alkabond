<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SalesController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\UnitController;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

// Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::resource('/unit', UnitController::class);

    Route::resource('/type', TypeController::class);

    Route::resource('/product', ProductController::class);

    // Sales
    Route::get('/sales', [SalesController::class, 'index']);
    Route::post('/sales', [SalesController::class, 'store']);
    Route::get('/sales/{sales}', [SalesController::class, 'show']);
    Route::put('/sales/{sales}', [SalesController::class, 'update']);
    Route::delete('/sales/{sales}', [SalesController::class, 'destroy']);

    Route::resource('/store', StoreController::class);

    Route::resource('/transaction', TransactionController::class);

    Route::resource('/city', CityController::class);

    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });

    //Logout
    Route::post('/logout', [AuthController::class, 'logout']);
// });
