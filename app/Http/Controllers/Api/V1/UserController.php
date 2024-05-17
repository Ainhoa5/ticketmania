<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

/**
 * Clase UserController
 *
 * Controlador para la gestión de usuarios.
 *
 * @package App\Http\Controllers\API\V1
 */
class UserController extends Controller
{
    /**
     * Obtiene los datos del usuario autenticado.
     *
     * @param Request $request La solicitud HTTP.
     * @return \Illuminate\Http\JsonResponse Respuesta en formato JSON.
     *
     * @OA\Get(
     *     path="/api/v1/user",
     *     summary="Obtiene los datos del usuario autenticado",
     *     @OA\Response(
     *         response=200,
     *         description="Datos del usuario obtenidos exitosamente"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function getUser(Request $request)
    {
        $user = Auth::user();
        return response()->json(['user' => $user]);
    }
}
