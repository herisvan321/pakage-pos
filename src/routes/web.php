<?php

use Illuminate\Support\Facades\Route;
use Herisvanhendra\Pos\Http\Controllers\AuthController;
use Herisvanhendra\Pos\Http\Controllers\DashboardController;
use Herisvanhendra\Pos\Http\Controllers\CategoryController;
use Herisvanhendra\Pos\Http\Controllers\ProductController;
use Herisvanhendra\Pos\Http\Controllers\SaleController;
use Herisvanhendra\Pos\Http\Controllers\ReportController;

// Guest Routes (Login)
Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/pos/login', [AuthController::class, 'showLoginForm'])->name('pos.login');
    Route::post('/pos/login', [AuthController::class, 'login'])->name('pos.login.post');
});

// Protected Routes
Route::middleware(['web', 'auth'])->prefix('pos')->name('pos.')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Products
    Route::resource('products', ProductController::class);
    
    // Sales
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/daily', [ReportController::class, 'daily'])->name('reports.daily');
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
});

