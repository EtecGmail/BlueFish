<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_successfully(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'secret',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_succeeds_and_access_protected_route(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);

        $this->get('/produtos')->assertOk();
    }

    public function test_protected_route_redirects_guests(): void
    {
        $this->get('/produtos')->assertRedirect('/login');
    }

    public function test_logout_invalidates_session(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();

        $this->get('/produtos')->assertRedirect('/login');
    }
}
