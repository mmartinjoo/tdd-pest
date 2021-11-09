<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::resource('v1/categories', CategoryController::class);
