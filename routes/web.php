<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

Route::get('/', [HomeController::class,'index'])->name('home');

Route::get('/login', [LoginController::class,'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class,'store'])->name('login.store');
Route::post('/logout', [LoginController::class,'destroy'])->name('logout');

Route::get('/products', [ProductController::class,'index'])->name('products.index');
Route::post('/products', [ProductController::class,'store'])->name('products.store');
Route::delete('/products/{id}', [ProductController::class,'destroy'])->name('products.destroy');
