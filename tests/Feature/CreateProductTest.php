<?php

namespace Tests\Feature;

use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\postJson;

it('should create a product', function () {
    $category = Category::factory()->create();

    $product = postJson(route('products.store', ['category' => $category]), [
        'categoryId' => $category->id,
        'name' => 'Microservices with Laravel',
        'description' => 'The ultimate guide to build microservices with Laravel',
        'prices' => [
            ['fromDate' => now()->subDays(2), 'toDate' => now()->addMonth(), 'price' => 15],
            ['fromDate' => '2020-11-01', 'toDate' => '2020-11-30', 'price' => 12],
            ['fromDate' => '2020-10-01', 'toDate' => '2020-10-31', 'price' => 9],
        ],
    ])->assertStatus(Response::HTTP_CREATED)->json('data');

    expect($product)
        ->currentPrice->toBe(15)
        ->name->toBe('Microservices with Laravel')
        ->description->toBe('The ultimate guide to build microservices with Laravel')
        ->category->toBeArray()
        ->prices->toHaveCount(3);
});
