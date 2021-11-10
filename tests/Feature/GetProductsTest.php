<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductPrice;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\getJson;

it('should return every products', function () {
    Product::factory()->count(3)->create();

    $products = getJson(route('products.index'))
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($products)->toHaveCount(3);
});

it('should return a product with the current price', function () {
    $product = Product::factory()
        ->has(ProductPrice::factory([
            'from_date' => now()->subDay(),
            'to_date' => now()->addDay(),
            'price' => 10,
        ]), 'prices')
        ->create();

    $productResponse = getJson(route('products.show', compact('product')))
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($productResponse)->currentPrice->toBe(10);
});

it('should return the right current price at any given time', function () {
    $product = Product::factory()
        ->has(ProductPrice::factory([
            'from_date' => now()->subDay(),
            'to_date' => now()->addDay(),
            'price' => 10,
        ]), 'prices')
        ->has(ProductPrice::factory([
            'from_date' => now()->addMonth(),
            'to_date' => now()->addMonths(2),
            'price' => 15,
        ]), 'prices')
        ->create();

    $this->travelTo(now()->addMonth(), function () use ($product) {
        $productResponse = getJson(route('products.show', compact('product')))
            ->assertStatus(Response::HTTP_OK)
            ->json('data');

        expect($productResponse)->currentPrice->toBe(15);
    });
});
