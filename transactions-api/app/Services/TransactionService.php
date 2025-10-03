<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use App\Models\User;

class TransactionService
{
  protected $transactionRepo;

  public function __construct(TransactionRepository $transactionRepo)
  {
    $this->transactionRepo = $transactionRepo;
  }

  public function createTransaction(User $user, array $data)
  {
    $balance = $this->transactionRepo->sumBalance($user);

    if ($data['type'] === 'debit' && $data['amount'] > $balance) {
      throw new \Exception('Saldo insuficiente'); // <-- lançar exceção
    }

    return $this->transactionRepo->create($user, $data);
  }

  public function getHistory(User $user)
  {
    $transactions = $this->transactionRepo->history($user);
    $balance = $this->transactionRepo->sumBalance($user);

    return [
      'transactions' => $transactions,
      'balance' => $balance
    ];
  }
}
