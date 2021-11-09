<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryProductController;
use Illuminate\Support\Facades\Route;

$actions = ['store', 'index', 'show', 'update', 'destroy'];

Route::resource('v1/categories', CategoryController::class)->only($actions);
Route::resource('v1/categories/{category}/products', CategoryProductController::class)->only($actions);
