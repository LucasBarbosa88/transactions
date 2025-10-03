<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository
{
  protected $model;

  public function __construct(Role $role)
  {
    $this->model = $role;
  }

  public function findByName(string $name): ?Role
  {
    return $this->model->where('name', $name)->first();
  }
}
