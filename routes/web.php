<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;

Route::middleware(['auth.user','prevent.back'])->group(function () {
    Route::get('/', function () {
        return Inertia::location('/dashboard');
    });
    Route::get('/dashboard', function () {
        return Inertia::render('Cms/Dashboard/Index');
    });
    Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/car', [CarController::class, 'index'])->name('car.index');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    // Add other protected routes here
});

Route::middleware(['guest'])
    ->group(function () {
        Route::get('/login', [LoginController::class,'show'])->name('login');
        Route::post('/login', [LoginController::class,'store'])->name('login.store');
        Route::get('/reset-password', [LoginController::class,'showResetPassword'])->name('login.resetPassword');
        Route::get('/forget-password', [LoginController::class,'showForgetPassword'])->name('login.forgetPassword');
    });


