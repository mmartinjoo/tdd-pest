<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Services\CreateProduct;
use Symfony\Component\HttpFoundation\Response;

class CategoryProductController extends Controller
{
    public function __construct(private readonly CreateProduct $createProduct)
    {
    }

    public function index(Category $category)
    {
        return [
            'data' => ProductResource::collection($category->products),
        ];
    }

    public function store(StoreProductRequest $request, Category $category)
    {
        $product = $this->createProduct->handle(
            $category,
            $request->getName(),
            $request->getPrices(),
            $request->getDescription()
        );

        $product->load('category');

        return response([
            'data' => new ProductResource($product)
        ], Response::HTTP_CREATED);
    }
}
