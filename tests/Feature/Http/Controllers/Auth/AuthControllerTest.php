<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class AuthControllerTest extends TestCase 
{
    use RefreshDatabase;

    /**
     * 
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');
    }

    /**
     *  @test
     */
    public function can_authenticate()
    {
        $user = User::factory()->create();

        $response = $this->json('POST', '/auth/token', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);

        Log::info($response->getContent());
    }
}