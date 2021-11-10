<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\putJson;

it('should update an existing product', function () {
    $category = Category::factory()->create();
    $newCategory = Category::factory()->create();

    $product = Product::factory([
        'name' => 'First Product',
        'description' => 'First description',
        'category_id' => $category->id,
    ])->create();

    $data = [
        'name' => 'Name changed',
        'description' => 'Description changed',
        'categoryId' => $newCategory->id,
        'prices' => [
            [
                'fromDate' => '2021-10-01',
                'toDate' => '2021-10-30',
                'price' => 10,
            ]
        ]
    ];

    $updatedProduct = putJson(
        route('products.update', compact('product')),
        $data,
    )
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($updatedProduct)
        ->name->toBe('Name changed')
        ->description->toBe('Description changed')
        ->category->id->toBe($newCategory->id);
});

it('should update prices', function () {
    $category = Category::factory()->create();

    $product = Product::factory([
        'name' => 'First Product',
        'description' => 'First description',
        'category_id' => $category->id,
    ])
        ->has(ProductPrice::factory()->count(3), 'prices')
        ->create();

    $data = [
        'name' => 'First product',
        'description' => 'First description',
        'categoryId' => $category->id,
        'prices' => [
            [
                'fromDate' => '2021-10-01',
                'toDate' => '2021-10-30',
                'price' => 10,
            ]
        ]
    ];

    $updatedProduct = putJson(
        route('products.update', compact('product')),
        $data,
    )
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($updatedProduct)
        ->prices->toMatchArray([
            [
                'fromDate' => Carbon::parse('2021-10-01')->toISOString(),
                'toDate' => Carbon::parse('2021-10-30')->toISOString(),
                'price' => 10,
            ]
        ]);
});
