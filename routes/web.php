<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FactoryCarController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Auth\AdminLoginController;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [AdminLoginController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

    Route::middleware('auth.admin')->group(function () {

        // Dashboard
        Route::get('/', fn() => view('admin.dashboard'))->name('dashboard');

        // Resource routes for main entities
        Route::resource('products', ProductController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('purchases', PurchaseController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('factory-cars', FactoryCarController::class);
        Route::resource('cars', CarController::class);
        Route::resource('admins', AdminController::class);

        // Singleton-style routes
        Route::get('settings', SettingController::class)->name('settings');
        Route::get('reports', ReportController::class)->name('reports');
    });
});


require __DIR__ . '/auth.php';