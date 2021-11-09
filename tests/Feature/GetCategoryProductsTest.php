<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use function Pest\Laravel\getJson;

it('should return all products for a category', function () {
    $category = Category::factory()
        ->has(Product::factory()->count(3))
        ->create();

    Category::factory()
        ->has(Product::factory()->count(10))
        ->create();

    $products = getJson(route('products.index', ['category' => $category->id]))->json('data');
    expect($products)->toHaveCount(3);
});
