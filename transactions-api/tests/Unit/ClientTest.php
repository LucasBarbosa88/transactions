<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
  use RefreshDatabase;

  private function authenticateAdmin()
  {
    $adminRole = Role::factory()->create(['name' => 'admin']);
    $admin = User::factory()->create([
      'password' => bcrypt('password123')
    ]);
    $admin->roles()->attach($adminRole);

    $login = $this->postJson('/api/login', [
      'email' => $admin->email,
      'password' => 'password123'
    ]);

    return $login->json('token');
  }

  public function test_admin_can_register_client()
  {
    $token = $this->authenticateAdmin();

    $response = $this->postJson('/api/client', [
      'name' => 'Cliente Teste',
      'email' => 'cliente@example.com',
      'password' => 'secret123'
    ], [
      'Authorization' => "Bearer $token"
    ]);

    $response->assertStatus(201)
      ->assertJsonStructure(['id', 'name', 'email']);
  }

  public function test_register_client_without_email_fails()
  {
    $token = $this->authenticateAdmin();

    $response = $this->postJson('/api/client', [
      'name' => 'Cliente Teste',
      'email' => '',
      'password' => 'secret123'
    ], [
      'Authorization' => "Bearer $token"
    ]);

    $response->assertStatus(422)
      ->assertJsonValidationErrors(['email']);
  }

  public function test_register_client_without_password_fails()
  {
    $token = $this->authenticateAdmin();

    $response = $this->postJson('/api/client', [
      'name' => 'Cliente Teste',
      'email' => 'cliente@example.com',
      'password' => ''
    ], [
      'Authorization' => "Bearer $token"
    ]);

    $response->assertStatus(422)
      ->assertJsonValidationErrors(['password']);
  }

  public function test_register_client_with_invalid_email_fails()
  {
    $token = $this->authenticateAdmin();

    $response = $this->postJson('/api/client', [
      'name' => 'Cliente Teste',
      'email' => 'cliente.com',
      'password' => 'secret123'
    ], [
      'Authorization' => "Bearer $token"
    ]);

    $response->assertStatus(422)
      ->assertJsonValidationErrors(['email']);
  }
}
