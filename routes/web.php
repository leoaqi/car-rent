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
    Route::put('/brand/{id}', [BrandController::class, 'update'])->name('brand.update');
    Route::get('/brand/{id}/edit', [BrandController::class, 'edit'])->name('brand.edit');
    Route::post('/brand/add', [BrandController::class, 'store'])->name('brand.store');
    Route::get('/brand/add', [BrandController::class, 'add'])->name('brand.add');
    Route::delete('/brand/{id}', [BrandController::class, 'destroy'])->name('brand.destroy');
    
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/add', [CategoryController::class, 'add'])->name('category.add');
    Route::post('/category/add', [CategoryController::class, 'store'])->name('category.store');
    Route::delete('/category/{id}', [CategoryController::class, 'delete'])->name('category.delete');
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');

    Route::get('/car', [CarController::class, 'index'])->name('car.index');
    Route::get('/car/add', [CarController::class, 'add'])->name('car.add');
    Route::post('/car/add', [CarController::class, 'store'])->name('car.store');
    Route::delete('/car/{id}', [CarController::class, 'delete'])->name('car.delete');

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


