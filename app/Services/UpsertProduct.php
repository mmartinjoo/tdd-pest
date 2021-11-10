<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Support\Facades\DB;

class UpsertProduct
{
    public function handle(
        Category $category,
        string $name,
        array $prices,
        ?string $description,
        ?int $id = null
    ): Product {
        return DB::transaction(function () use ($category, $name, $description, $prices, $id) {
            $product = Product::updateOrCreate(
                [
                    'id' => $id,
                ],
                [
                    'category_id' => $category->id,
                    'description' => $description,
                    'name' => $name,
                ]
            );

            $productPrices = collect($prices)
                ->map(fn (array $priceData) => new ProductPrice([
                    'from_date' => $priceData['fromDate'],
                    'to_date' => $priceData['toDate'],
                    'price' => $priceData['price'],
                ]));

            $product->prices()->delete();
            $product->prices()->saveMany($productPrices);
            return $product;
        });
    }
}
