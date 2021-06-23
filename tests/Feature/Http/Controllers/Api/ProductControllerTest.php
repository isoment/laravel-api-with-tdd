<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function user_can_create_product()
    {
        // User must be authenticated

        // When a post request is made a product is created
        $response = $this->json('POST', '/api/products', [

        ]);

        // Product should then exist
        $response->assertStatus(201);
    }
}
