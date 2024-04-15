<?php

use App\Http\Controllers\Api\V1\ConcertController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// api/v1
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function() {
    Route::apiResource('events', EventController::class);
    Route::apiResource('concerts', ConcertController::class);
    Route::apiResource('tickets', TicketController::class);
    Route::apiResource('payments', PaymentController::class);
});
