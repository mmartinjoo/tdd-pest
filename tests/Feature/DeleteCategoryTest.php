<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\deleteJson;

it('should delete a category', function () {
    $category = Category::factory()->create();

    deleteJson(route('categories.destroy', ['category' => $category->id]))
        ->assertStatus(Response::HTTP_NO_CONTENT);

    $this->assertDatabaseCount('categories', 0);
});

it('should set deleted category products category id to NULL', function () {
    $category = Category::factory()
        ->has(Product::factory()->count(3))
        ->create();

    deleteJson(route('categories.destroy', ['category' => $category->id]))
        ->assertStatus(Response::HTTP_NO_CONTENT);

    expect(Category::count())->toBe(0);
    expect(Product::count())->toBe(3);

    Product::all()
        ->each(fn (Product $product) => expect($product->category_id)->toBeNull());
});
