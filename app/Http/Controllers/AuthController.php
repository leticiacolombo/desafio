<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request) {
        $data = $request->only('email', 'password');

        $validator = Validator::make($data, [
            'email' => ['required', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:4']
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $token = JWTAuth::attempt($data);

        if (!$token) {
            return response()->json(['error' => 'Usuário ou senha incorretos!'], 401);
        } else {
            return $this->getTokenResponse($token);
        }
    }

    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'Logout feito com sucesso!']);
    }

    protected function getTokenResponse($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => JWTAuth::user()
        ]);
    }
}
