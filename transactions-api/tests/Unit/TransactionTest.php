<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
  use RefreshDatabase;

  private function authenticateAdmin()
  {
    $adminRole = Role::factory()->create(['name' => 'admin']);
    $admin = User::factory()->create(['password' => bcrypt('password123')]);
    $admin->roles()->attach($adminRole);

    $login = $this->postJson('/api/login', [
      'email' => $admin->email,
      'password' => 'password123'
    ]);

    return $login->json('token');
  }

  public function test_admin_can_add_credit_to_client()
  {
    $token = $this->authenticateAdmin();

    $clientRole = Role::factory()->create(['name' => 'client']);
    $client = User::factory()->create();
    $client->roles()->attach($clientRole);

    $response = $this->postJson("/api/clients/{$client->id}/transactions", [
      'type' => 'credit',
      'amount' => 100.50
    ], [
      'Authorization' => "Bearer $token"
    ]);

    $response->assertStatus(201)
      ->assertJson(['type' => 'credit', 'amount' => "100.50"]);
  }

  public function test_debit_cannot_exceed_balance()
  {
    $token = $this->authenticateAdmin();

    $clientRole = Role::factory()->create(['name' => 'client']);
    $client = User::factory()->create();
    $client->roles()->attach($clientRole);

    $response = $this->postJson("/api/clients/{$client->id}/transactions", [
      'type' => 'debit',
      'amount' => 500
    ], [
      'Authorization' => "Bearer $token"
    ]);

    $response->assertStatus(422)
      ->assertJson(['error' => 'Saldo insuficiente']);
  }
}
