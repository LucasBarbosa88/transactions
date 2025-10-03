<?php
namespace Database\Seeders; 

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
  public function run()
  {
    $adminRole = Role::firstOrCreate(['name' => 'admin']);
    $clientRole = Role::firstOrCreate(['name' => 'client']);

    $admin = User::firstOrCreate(
      ['email' => 'admin@example.com'],
      [
        'name' => 'Admin',
        'password' => Hash::make('password123')
      ]
    );
    $admin->roles()->sync([$adminRole->id]);
  }
}
