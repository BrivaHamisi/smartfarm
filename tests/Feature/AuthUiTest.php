<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthUiTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders(): void
    {
        $this->get('/login')->assertOk()->assertSee('Welcome')->assertSee('Smart Farm');
    }

    public function test_register_page_renders(): void
    {
        $this->get('/register')->assertOk()->assertSee('Create Account')->assertSee('Smart Farm');
    }

    public function test_authenticated_users_are_redirected_away_from_login(): void
    {
        $owner = User::factory()->owner()->create();

        $this->actingAs($owner)->get('/login')->assertRedirect('/dashboard');
    }

    public function test_registration_creates_an_owner_and_logs_activity(): void
    {
        $this->post('/register', [
            'name' => 'Demo Farmer',
            'email' => 'demo@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::query()->where('email', 'demo@example.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue($user->isOwner());
        $this->assertDatabaseHas('activity_logs', [
            'action' => ActivityLog::ACTION_REGISTERED,
            'user_id' => $user->id,
            'farm_id' => $user->id,
        ]);
    }

    public function test_login_validates_credentials(): void
    {
        $this->post('/login', ['email' => 'nope@example.com', 'password' => 'wrong'])
            ->assertSessionHasErrors('email');
    }
}
