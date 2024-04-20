<?php
use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Sin middleware de autenticación
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // api/v1
    Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function() {
        Route::apiResource('events', 'EventController');
        Route::apiResource('concerts', 'ConcertController');
        Route::apiResource('tickets', 'TicketController');
        Route::apiResource('payments', 'PaymentController');
    });
});

