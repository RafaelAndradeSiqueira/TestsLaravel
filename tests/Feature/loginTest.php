<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class loginTest extends TestCase
{
    public function test_if_user_can_access_route(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_if_user_can_access_route_and_see_content(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);

        $response->assertSee('Login');
        $response->assertSee('username');
        $response->assertSee('password');
    }

    public function test_with_validate_erros(): void
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_if_password_or_email_are_incorrect(): void
    {
        $response = $this->post('/login', [
            'email' => 'email@example.com',
            'password' => '123455678',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email', 'password']);
        $response->assertRedirect('/login');
    }
}
