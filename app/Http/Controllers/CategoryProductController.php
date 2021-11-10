<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;

class CategoryProductController extends Controller
{
    public function index(Category $category)
    {
        return [
            'data' => ProductResource::collection($category->products),
        ];
    }
}
