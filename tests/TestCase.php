<?php

namespace Tests;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     *  Create a product
     */
    public function createProduct(array $attributes = [])
    {
        $product = Product::factory()->create($attributes);

        return new ProductResource($product);
    }
}
