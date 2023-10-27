<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{

    public function getProduct(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function getProducts(): Collection
    {
        return Product::all();
    }
}
