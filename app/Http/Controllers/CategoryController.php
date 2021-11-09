<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index()
    {
        return [
            'data' => CategoryResource::collection(Category::all()),
        ];
    }

    public function store(StoreCategoryRequest $request)
    {
        return response([
            'data' => new CategoryResource(Category::create($request->validated()))
        ], Response::HTTP_CREATED);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->fill($request->validated());
        $category->save();

        return response([
            'data' => new CategoryResource($category->fresh())
        ], Response::HTTP_OK);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response([], Response::HTTP_NO_CONTENT);
    }
}
