<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Models\User;

class TransactionController extends Controller
{
  protected $transactionService;

  public function __construct(TransactionService $transactionService)
  {
    $this->transactionService = $transactionService;
  }

  public function store(Request $request, User $client)
  {
    $data = $request->validate([
      'type' => 'required|in:credit,debit',
      'amount' => 'required|numeric|min:0.01'
    ]);

    if (!$client->hasRole('client')) {
      return response()->json(['message' => 'Usuário não é cliente'], 404);
    }

    try {
      $transaction = $this->transactionService->createTransaction($client, $data);
      return response()->json($transaction, 201);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 422);
    }
  }

  public function history(User $client)
  {
    if (!$client->hasRole('client')) {
      return response()->json(['message' => 'Usuário não é cliente'], 404);
    }

    $result = $this->transactionService->getHistory($client);

    return response()->json([
      'user' => $client->only(['id', 'name', 'email']),
      'balance' => $result['balance'],
      'transactions' => $result['transactions']
    ]);
  }
}
