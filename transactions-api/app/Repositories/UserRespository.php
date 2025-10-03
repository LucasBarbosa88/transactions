<?php

namespace App\Repositories;

use App\Models\User;

class UserRespository
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
    return $this->model->whereHas('roles', fn($q) => $q->where('name', 'client'))->get();
  }
}
