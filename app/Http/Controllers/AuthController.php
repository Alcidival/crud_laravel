<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        //dd($request);
        $validator = $request->validate([
            'name' => 'required|string|min:10',
            'email' => 'required|string|email:rfc,dns|unique:users,email',
            'password' => 'required|string|min:8'
        ]);

        $user = User::create([
            'name' => $validator['name'],
            'email' => $validator['email'],
            'password' => Hash::make($validator['password'])
        ]);

        if ($user) {
            $token = $user->createToken('api_token', ['post:create', 'post:read'])->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ], 201);
        }
        
        return response()->json([
            'status' => 500,
            'message' => 'Erro ao criar usuário'
        ], 500);
    }

    public function login(Request $request)
    {
        //dd($request);
        $validator = $request->validate([
            'email' => 'required|string|email:rfc,dns',
            'password' => 'required|min:8'
        ]);

        $validatorAuth = Auth::attempt(['email' => $validator['email'], 'password' => $validator['password']]);
        
        if ($validatorAuth) {
            $user = User::where('email', $validator['email'])->first();
            $token = $user->createToken('api_token', ['post:create', 'post:read'])->plainTextToken;

            return response()->json([
                'token' => $token
            ], 201);
        }
        
        return response()->json([
            'status' => 500,
            'message' => 'Usuário não encontrado'
        ], 500);
    }

    public function logout(Request $request)
    {
        //dd($request);
        $validatorToken = PersonalAccessToken::findToken($request['token']);
        
        if ($validatorToken) {
            $validatorToken->delete();

            return response()->json([
                'message' => 'Token removido com sucesso'
            ], 201);
        }
        
        return response()->json([
            'status' => 500,
            'message' => 'Token invalido'
        ], 500);
    }
}
