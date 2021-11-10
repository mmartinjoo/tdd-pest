<?php

namespace Tests\Feature;

use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;


it('should return 422 if name is missing', function ($name) {
    postJson(route('categories.store'), [
        'name' => $name,
        'description' => 'description'
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
})->with([
    '',
    null
]);

it('should return 422 if name is not unique', function () {
    Category::factory(['name' => 'Books'])->create();
    postJson(route('categories.store'), [
        'name' => 'Books',
        'description' => 'description'
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('should create a category', function () {
    $response = postJson(
        route('categories.store'),
        [
            'name' => 'Books',
            'description' => 'Category for books',
        ]
    )
        ->assertStatus(Response::HTTP_CREATED)
        ->json('data');

    $category = getJson(
        route('categories.show', ['category' => $response['id']])
    )->json('data');

    expect($category)
            ->id->toBe($response['id'])
            ->name->toBe('Books')
            ->description->toBe('Category for books')
            ->productCount->toBe(0);
});
