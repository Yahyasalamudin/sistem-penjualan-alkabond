<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityBranchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    return 'DONE';
});

Route::fallback(function () {
    return view('errors.404');
});

Route::get('/', function () {
    return redirect('login');
});

// Error Handle
Route::get('/Unauthorized', function () {
    return view('errors.401');
})->name('unauthorized');

// Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/process-login', [AuthController::class, 'actionLogin'])->name('actionLogin');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/filter-kota', [DashboardController::class, 'filterKota'])->name('filterKota');
    Route::post('/filter-cabang-kota', [DashboardController::class, 'filterCabangKota'])->name('filterCabangKota');

    // CRUD Data City
    Route::get('/cities', [CityController::class, 'index'])->name('city.index');
    Route::post('/cities', [CityController::class, 'store'])->name('city.store');
    Route::put('/city/{id}/update', [CityController::class, 'update'])->name('city.update');
    Route::delete('/city/{id}/delete', [CityController::class, 'destroy'])->name('city.destroy');

    // CRUD Data Branch
    Route::get('/city-branches', [CityBranchController::class, 'index'])->name('city-branch.index');
    Route::post('/city-branches', [CityBranchController::class, 'store'])->name('city-branch.store');
    Route::put('/city-branch/{id}/update', [CityBranchController::class, 'update'])->name('city-branch.update');
    Route::delete('/city-branch/{id}/delete', [CityBranchController::class, 'destroy'])->name('city-branch.destroy');
    Route::get('/city-branches/{id}/get', [CityBranchController::class, 'get_city_branches'])->name('city-branch.get-city-branches');

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
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}/delete', [ProductController::class, 'destroy'])->name('product.destroy');

    // Transaction
    Route::get('/transactions/{status}', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/transactions/{status}/create', [TransactionController::class, 'create'])->name('transaction.create');
    Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transaction.store');
    Route::get('/transactions/archive/all', [TransactionController::class, 'archive'])->name('transaction.archive');
    Route::put('/transactions/archive/{id}', [TransactionController::class, 'restore'])->name('transaction.restore');
    Route::delete('/transactions/archive/{id}', [TransactionController::class, 'kill'])->name('transaction.kill');
    Route::get('/transactions/{status}/detail-transaction/{id}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::put('/transactions/{delivery_status}/{id}', [TransactionController::class, 'update_delivery'])->name('transaction.update');
    Route::delete('/transactions/{id}/delete', [TransactionController::class, 'destroy'])->name('transaction.destroy');
    Route::post('/transaction/pay/{id}', [TransactionController::class, 'payment'])->name('transaction.pay');
    Route::put('/transaction/pay/edit/{id}', [TransactionController::class, 'edit_payment'])->name('transaction.pay.edit');

    // User
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/users/create', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/show/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    //Admin
    Route::get('/admins', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admins/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admins/create', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/show/{id}', [AdminController::class, 'show'])->name('admin.show');
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // Sales
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SalesController::class, 'create'])->name('sales.create');
    Route::post('/sales/create', [SalesController::class, 'store'])->name('sales.store');
    Route::get('/sales/show/{id}', [SalesController::class, 'show'])->name('sales.show');
    Route::get('/sales/edit/{id}', [SalesController::class, 'edit'])->name('sales.edit');
    Route::put('/sales/update/{id}', [SalesController::class, 'update'])->name('sales.update');
    Route::delete('/sales/delete/{id}', [SalesController::class, 'destroy'])->name('sales.destroy');

    // Import
    Route::post('/import/product', [ImportController::class, 'import_product'])->name('import.product');
    Route::post('/import/store', [ImportController::class, 'import_store'])->name('import.store');
    Route::post('/import/sales', [ImportController::class, 'import_sales'])->name('import.sales');

    // Laporan
    Route::get('/laporan/surat-jalan={invoice}', [ReportController::class, 'suratJalan'])->name('suratjalan');
    Route::get('/laporan/struk={invoice}', [ReportController::class, 'struk'])->name('struk');
    Route::get('/laporan/transaksi', [ReportController::class, 'transaction_report'])->name('report.transaction');
    Route::post('/laporan/transaksi', [ReportController::class, 'printTransactionReport'])->name('print.transactionReport');
    Route::get('/laporan/barang-terjual', [ReportController::class, 'bestSellerProductReport'])->name('report.bestSellerProductReport');
    Route::get('/laporan/pendapatan', [ReportController::class, 'incomeReport'])->name('incomeReport');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
