<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductPrice;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\deleteJson;

it('should delete a product', function () {
    $product = Product::factory()->create();

    deleteJson(route('products.destroy', compact('product')))
        ->assertStatus(Response::HTTP_NO_CONTENT);

    $this->assertDatabaseMissing('products', [
        'id' => $product->id,
    ]);
});

it('should delete a product with prices', function () {
    $product = Product::factory()
        ->has(ProductPrice::factory()->count(2), 'prices')
        ->create();

    deleteJson(route('products.destroy', compact('product')))
        ->assertStatus(Response::HTTP_NO_CONTENT);

    $this->assertDatabaseMissing('product_prices', [
        'product_id' => $product->id,
    ]);
});
