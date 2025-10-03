<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
  use RefreshDatabase;

  public function test_admin_can_login_and_receive_token()
  {
    $adminRole = Role::factory()->create(['name' => 'admin']);
    $admin = User::factory()->create([
      'email' => 'admin@example.com',
      'password' => bcrypt('password123')
    ]);
    $admin->roles()->attach($adminRole);

    $response = $this->postJson('/api/login', [
      'email' => 'admin@example.com',
      'password' => 'password123'
    ]);

    $response->assertStatus(200)
      ->assertJsonStructure(['token']);
  }
}
