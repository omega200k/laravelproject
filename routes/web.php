<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesHistoryController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::redirect('/', '/products')->name('home');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    Route::middleware('can:admin')->group(function () {
        Route::resource('customers', CustomerController::class);
        Route::resource('staff', StaffController::class);
        Route::get('/sales', [SalesHistoryController::class, 'index'])->name('sales.index');
    });

    Route::resource('products', ProductController::class);
    Route::get('/sales/record', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
});
