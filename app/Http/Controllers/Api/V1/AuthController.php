<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'is_admin' => 'required|boolean',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'is_admin' => $validatedData['is_admin']
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        // Verificar si el usuario es administrador antes de generar el token
        if ($user->is_admin) {
            $token = $user->createToken('Admin Access Token', ['create', 'update', 'delete'])->plainTextToken;
            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Access granted, no token required'], 200);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Tokens revoked']);
    }


}
