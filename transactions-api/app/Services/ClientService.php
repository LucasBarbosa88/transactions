<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Hash;

class ClientService
{
  protected $userRepo;
  protected $roleRepo;

  public function __construct(UserRepository $userRepo, RoleRepository $roleRepo)
  {
    $this->userRepo = $userRepo;
    $this->roleRepo = $roleRepo;
  }

  public function createClient(array $data)
  {
    $user = $this->userRepo->create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password'] ?? 'secret123')
    ]);

    $clientRole = $this->roleRepo->findByName('client');
    if ($clientRole) {
      $user->roles()->attach($clientRole->id);
    }

    return $user->load('roles'); 
  }

  public function listClients()
  {
    return $this->userRepo->allClients()->load('roles');
  }
}
