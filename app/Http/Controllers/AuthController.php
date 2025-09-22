<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'message' => 'Erro ao criar usuário'
        ], 500);
    }
}
