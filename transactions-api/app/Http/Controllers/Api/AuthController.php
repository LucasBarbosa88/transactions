<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
  protected $authService;

  public function __construct(AuthService $authService)
  {
    $this->authService = $authService;
  }

  public function login(Request $request)
  {
    $data = $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    $result = $this->authService->login($data);

    if (!$result) {
      return response()->json(['message' => 'Credenciais inválidas'], 401);
    }

    if (!$result['user']->hasRole('admin')) {
      return response()->json(['message' => 'Acesso negado'], 403);
    }

    return response()->json([
      'token' => $result['token']
    ]);
  }

  public function show(Request $request)
  {
    return response()->json($this->authService->show($request->user()));
  }

  public function logout(Request $request)
  {
    $this->authService->logout($request->user());
    return response()->json(['message' => 'Logout efetuado com sucesso']);
  }
}
