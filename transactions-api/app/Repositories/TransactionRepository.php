<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{
  protected $model;

  public function __construct(Transaction $transaction)
  {
    $this->model = $transaction;
  }

  public function create(User $user, array $data)
  {
    return $user->transactions()->create($data);
  }

  public function sumBalance(User $user)
  {
    return (float) $user->transactions()
      ->selectRaw("COALESCE(SUM(CASE WHEN type='credit' THEN amount ELSE -amount END),0) as balance")
      ->value('balance');
  }

  public function history(User $user)
  {
    return $user->transactions()->latest()->get();
  }
}
