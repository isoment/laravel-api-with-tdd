<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A user can create a product.
     *
     * @test
     */
    public function user_can_create_product()
    {
        // User must be authenticated

        // Make a product
        $product = Product::factory()->make();

        // When a post request is made a product is created
        $response = $this->json('POST', '/api/products', [
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => $product->price
        ]);

        // Assert that the json response has the given structure
        // and that it contains the json and has a 201 http response
        $response->assertJsonStructure([
            'id', 'name', 'slug', 'description', 'price', 'created_at'
        ])->assertJson([
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => $product->price
        ])->assertStatus(201);

        // Assert the database has the product
        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => $product->price
        ]);
    }
}
