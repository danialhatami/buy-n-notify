<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(
            [
                'price' => 10_000,
                'name' => 'Product Number one'
            ]
        )
            ->count(10)->create();
    }
}
