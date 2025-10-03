<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
  public function login(array $credentials)
  {
    if (!Auth::attempt($credentials)) {
      return null;
    }

    $user = Auth::user();

    return [
      'user' => $user,
      'token' => $user->createToken('api-token')->plainTextToken
    ];
  }

  public function logout($user)
  {
    $user->tokens()->delete();
    return true;
  }

  public function show($user)
  {
    return $user;
  }
}
