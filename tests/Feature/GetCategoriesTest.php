<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use function Pest\Laravel\get;
use function Pest\Laravel\getJson;

it('should return 200', function () {
    get(route('categories.index'))->assertStatus(200);
});

it('should return all categories', function () {
    Category::factory()->count(6)->create();

    $categories = getJson(route('categories.index'))['data'];
    expect($categories)->toHaveCount(6);
});

it('should return categories with product count', function () {
    $books = Category::factory([
        'name' => 'Books',
        'description' => 'Category for books'
    ])->has(Product::factory()->count(8))->create();

    $categories = getJson(route('categories.index'))['data'];
    $booksResponse = array_pop($categories);

    expect($booksResponse)->toMatchArray([
        'id' => $books->id,
        'name' => 'Books',
        'description' => 'Category for books',
        'productCount' => 8,
    ]);
});
