<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

it('should update a category', function () {
    $category = Category::factory()
        ->has(Product::factory()->count(3))
        ->create();

    putJson(
        route('categories.update', ['category' => $category->id]),
        [
            'name' => 'Books updated',
            'description' => 'New description',
        ]
    )
        ->assertStatus(Response::HTTP_OK);

    $category = getJson(route('categories.show', ['category' => $category->id]))->json('data');
    expect($category)
        ->name->toBe('Books updated')
        ->description->toBe('New description')
        ->productCount->toBe(3);
});

it('should ignore the old name from unique validation', function () {
    $category = Category::factory(['name' => 'Books'])
        ->has(Product::factory()->count(3))
        ->create();

    putJson(
        route('categories.update', ['category' => $category->id]),
        [
            'name' => 'Books',
            'description' => 'New description',
        ]
    )
        ->assertStatus(Response::HTTP_OK);

    $category = getJson(route('categories.show', ['category' => $category->id]))->json('data');
    expect($category)
        ->name->toBe('Books')
        ->description->toBe('New description')
        ->productCount->toBe(3);
});
