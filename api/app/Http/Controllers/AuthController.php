<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function login(AuthLoginRequest $request) {
    // FLOW: 1
    $email = $request->input('email');
    $password = $request->input('password');

    // FLOW: 2
    $user = User::where('email', $email)->first();

    // FLOW: 3
    if (!$user || !Hash::check($password, $user->password)) {
      return response()->json([
        'type' => 'error',
        'message' => 'メールアドレスまたはパスワードが違います。'
      ], 400);
    }

    // FLOW: 4
    $token = $user->createToken('token')->plainTextToken;

    // FLOW: 5
    return response()->json([
      'token' => $token
    ]);
  }

  public function register(AuthRegisterRequest $request) {
    // FLOW: 1
    $name = $request->input('name');
    $email = $request->input('email');
    $password = $request->input('password');

    // FLOW: 2
    $hashedPassword = Hash::make($password);

    // FLOW: 3
    $user = User::create([
      'name' => $name,
      'email' => $email,
      'password' => $hashedPassword
    ]);

    // FLOW: 4
    $token = $user->createToken('token')->plainTextToken;

    // FLOW: 5
    return response()->json([
      'token' => $token
    ]);
  }
}
