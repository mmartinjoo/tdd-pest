<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Category::factory()
            ->count(10)
            ->has(
                Product::factory()
                    ->count(50)
                    ->has(ProductPrice::factory()->count(rand(1, 3)), 'prices')
            )
            ->create();
    }
}
