<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Category::factory()
            ->count(10)
            ->has(Product::factory()->count(50))
            ->create();
    }
}
