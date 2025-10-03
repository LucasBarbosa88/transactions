<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClientService;
use App\Services\TransactionService;
use App\Models\User;

class ClientController extends Controller
{
  protected $clientService;
  protected $transactionService;

  public function __construct(ClientService $clientService, TransactionService $transactionService)
  {
    $this->clientService = $clientService;
    $this->transactionService = $transactionService;
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|min:6'
    ]);

    $user = $this->clientService->createClient($data);

    return response()->json($user, 201);
  }

  public function index()
  {
    $clients = $this->clientService->listClients();
    return response()->json($clients);
  }

  public function show(User $client)
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
