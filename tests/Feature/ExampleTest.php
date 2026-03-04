<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {

        User::factory()->create([
            'name' => 'Rafael Siqueira',
            'email' => 'rafaz10000@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
