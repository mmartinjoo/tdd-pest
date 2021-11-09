<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryProductController;
use Illuminate\Support\Facades\Route;

Route::resource('v1/categories', CategoryController::class);
Route::get('v1/categories/{category}/products', [CategoryProductController::class, 'index'])->name('category/products.index');
