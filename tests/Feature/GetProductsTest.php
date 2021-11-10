<?php

namespace Tests\Feature;

use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\getJson;

it('should return every products', function () {
    Product::factory()->count(3)->create();

    $products = getJson(route('products.index'))
        ->assertStatus(Response::HTTP_OK)
        ->json('data');

    expect($products)->toHaveCount(3);
});
