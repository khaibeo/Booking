<?php

namespace Tests\Feature;

use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the login form is displayed.
     */
    public function test_login_form_is_displayed(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('ĐĂNG NHẬP');
    }

    /**
     * Test that a user can log in with valid credentials.
     */
    public function test_user_can_login_with_valid_credentials(): void
    {
        $store = Store::factory()->create();
        $user = User::factory()->for($store)->state([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ])->create();

        $response = $this->post(route('login.post'), [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test that a user cannot log in with invalid credentials.
     */
    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $store = Store::factory()->create();
        $user = User::factory()->for($store)->state([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ])->create();

        $response = $this->post(route('login.post'), [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
