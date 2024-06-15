<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SensorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('sensor', [SensorController::class, 'index']);
Route::get('sensor/{id}', [SensorController::class, 'show']);
Route::post('sensor', [SensorController::class, 'store']);
Route::put('sensor/{id}', [SensorController::class, 'update']);
Route::delete('sensor/{id}', [SensorController::class, 'destroy']);