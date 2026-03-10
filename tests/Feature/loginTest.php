<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_user_can_access_route(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_if_user_can_access_route_and_see_content(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/login');

        $response->assertStatus(200);

        $response->assertSee('Login');
        $response->assertSee('username');
        $response->assertSee('password');
    }

    public function test_with_validate_erros(): void
    {
        $response = $this->from('/login')->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertStatus(302);
        $response->assertRedirectBack('login');
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

    public function test_if_user_cant_page_login_authenticated(): void
    {

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/login');

        $response->assertStatus(302);
        $response->assertRedirect('/');   
    }

    public function test_if_user_can_login(): void
    {
        User::factory()->create([
            'email' => 'teste@gmail.com',
            'password' => bcrypt('password'),
       ]);

        $response = $this->post('/login', [
                'email' => 'teste@gmail.com',
                'password' => 'password',
            ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function test_if_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
