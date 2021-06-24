<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A user can create a product.
     *
     * @test
     */
    public function a_product_can_be_created()
    {
        // Make a product
        $product = Product::factory()->make();

        // When a post request is made a product is created
        $response = $this->json('POST', '/api/products', [
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => $product->price
        ]);

        // We can use this to write to the laravel log file
        // Log::info(1, [$response->getContent()]);

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

    /**
     *  If there is no product found fail with a 404 error
     * 
     *  @test
     */
    public function if_product_is_not_found_fail_with_404()
    {
        $response = $this->json('GET', '/api/products/-1');

        $response->assertStatus(404);
    }

    /**
     *  A product can be shown
     * 
     *  @test
     */
    public function a_product_can_be_shown()
    {
        $product = $this->createProduct();

        $response = $this->json('GET', "/api/products/$product->id");

        $response->assertStatus(200)
            ->assertExactJson([
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'price' => $product->price,
                'created_at' => $product->created_at
            ]);
    }

    /**
     *  404 is returned if a product is not found to update
     * 
     *  @test
     */
    public function if_product_to_be_updated_is_not_found_fail_with_404()
    {
        $response = $this->json('PUT', '/api/products/-1');

        $response->assertStatus(404);
    }

    /**
     *  A product can be updated
     * 
     *  @test
     */
    public function a_product_can_be_updated()
    {
        $product = $this->createProduct();

        $response = $this->json('PUT', "/api/products/$product->id", [
            'name' => $product->name . '_updated',
            'slug' => $product->slug . '_updated',
            'description' => $product->description . '_updated',
            'price' => $product->price + 10
        ]);

        $response->assertStatus(200)
            ->assertExactJson([
                'id' => $product->id,
                'name' => $product->name . '_updated',
                'slug' => $product->slug . '_updated',
                'description' => $product->description . '_updated',
                'price' => $product->price + 10,
                'created_at' => $product->created_at
            ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name . '_updated',
            'slug' => $product->slug . '_updated',
            'description' => $product->description . '_updated',
            'price' => $product->price + 10,
            'created_at' => $product->created_at
        ]);
    }

    /**
     *  404 is returned if a product is not found to update
     * 
     *  @test
     */
    public function if_product_to_be_deleted_is_not_found_fail_with_404()
    {
        $response = $this->json('DELETE', '/api/products/-1');

        $response->assertStatus(404);
    }

    /**
     *  A product can be deleted
     * 
     *  @test
     */
    public function a_product_can_be_deleted()
    {
        $product = $this->createProduct();

        $response = $this->json('DELETE', "/api/products/$product->id");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => $product->price,
        ]);
    }
}
