<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
  protected $model;

  public function __construct(User $user)
  {
    $this->model = $user;
  }

  public function create(array $data): User
  {
    return $this->model->create($data);
  }

  public function findById($id): ?User
  {
    return $this->model->find($id);
  }

  public function allClients()
  {
    $clients = $this->model
      ->whereHas('roles', fn($q) => $q->where('name', 'client'))
      ->with(['roles' => fn($q) => $q->select('roles.id', 'roles.name')])
      ->get(['id', 'name', 'email']);
    return $clients;
  }
}
