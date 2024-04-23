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
        Route::apiResource('events', 'EventController')->except(['index', 'show']);;
        Route::apiResource('concerts', 'ConcertController')->except(['index', 'show']);;

        // Apply specific permissions middleware to the tickets store method
        Route::apiResource('tickets', 'TicketController')->except(['index', 'show', 'store']);
        Route::post('tickets', 'TicketController@store')->middleware('can.purchase');

        Route::apiResource('payments', 'PaymentController')->except(['index', 'show']);;
    });
});

// Unprotected read-only routes for v1 API
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function() {
    Route::get('events', 'EventController@index');
    Route::get('events/{event}', 'EventController@show');
    Route::get('concerts', 'ConcertController@index');
    Route::get('concerts/{concert}', 'ConcertController@show');
    Route::get('tickets', 'TicketController@index');
    Route::get('tickets/{ticket}', 'TicketController@show');
    Route::get('payments', 'PaymentController@index');
    Route::get('payments/{payment}', 'PaymentController@show');
});

