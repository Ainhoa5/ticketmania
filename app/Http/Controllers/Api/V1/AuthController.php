<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

/**
 * Clase AuthController
 *
 * Controlador para la autenticación de usuarios.
 *
 * @package App\Http\Controllers\API\V1
 */
class AuthController extends Controller
{
    /**
     * Registra un nuevo usuario.
     *
     * @param Request $request La solicitud HTTP.
     * @return \Illuminate\Http\JsonResponse Respuesta en formato JSON.
     *
     * @OA\Post(
     *     path="/api/v1/register",
     *     summary="Registra un nuevo usuario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "is_admin"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password"),
     *             @OA\Property(property="is_admin", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario registrado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de validación incorrectos"
     *     )
     * )
     */
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

        return response()->json(['message' => 'Usuario registrado exitosamente', 'user' => $user]);
    }

    /**
     * Inicia sesión para un usuario.
     *
     * @param Request $request La solicitud HTTP.
     * @return \Illuminate\Http\JsonResponse Respuesta en formato JSON.
     *
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="Inicia sesión para un usuario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        $user = Auth::user();

        // Eliminar tokens existentes
        $user->tokens()->delete();

        if ($user->is_admin) {
            $token = $user->createToken('Admin Access Token', ['create', 'update', 'delete'])->plainTextToken;
        } else {
            // Permitir a los usuarios regulares leer y comprar boletos
            $token = $user->createToken('User Access Token', ['read', 'purchase'])->plainTextToken;
        }

        return response()->json(['token' => $token]);
    }

    /**
     * Cierra sesión para un usuario.
     *
     * @param Request $request La solicitud HTTP.
     * @return \Illuminate\Http\JsonResponse Respuesta en formato JSON.
     *
     * @OA\Post(
     *     path="/api/v1/logout",
     *     summary="Cierra sesión para un usuario",
     *     @OA\Response(
     *         response=200,
     *         description="Tokens revocados"
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Tokens revocados']);
    }
}
