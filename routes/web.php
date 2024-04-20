<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/setup', function () {
    $credentials = [
        'email' => 'admin@admin.com',
        'password' => 'password'
    ];

    // Asegúrate de que el usuario no existe antes de intentar crear uno nuevo.
    $user = User::where('email', $credentials['email'])->first();

    if (!$user) {
        $user = User::create([
            'name' => 'Admin',
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']), // Usa Hash para la contraseña
        ]);
    }

    // Intenta autenticar al usuario con las credenciales proporcionadas.
    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Crear tokens con capacidades específicas.
        $adminToken = $user->createToken('admin-token', ['*'])->plainTextToken;
        $updateToken = $user->createToken('update-token', ['create', 'update'])->plainTextToken;
        $basicToken = $user->createToken('basic-token', ['read'])->plainTextToken;

        return response()->json([
            'admin' => $adminToken,
            'update' => $updateToken,
            'basic' => $basicToken,
        ]);
    }

    return response()->json(['error' => 'Authentication failed'], 401);
});
