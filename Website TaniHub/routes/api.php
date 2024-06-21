<?php

use App\Http\Controllers\API\RelayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SensorController;
use App\Http\Controllers\API\SensorDataController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('sensor', [SensorController::class, 'index']);
Route::get('sensor/{id}', [SensorController::class, 'show']);
Route::post('sensor', [SensorController::class, 'store']);
Route::put('sensor/{id}', [SensorController::class, 'update']);
Route::delete('sensor/{id}', [SensorController::class, 'destroy']);

Route::get('/sensor-data', [SensorDataController::class, 'index']);
Route::post('/process-sensor-data', [SensorDataController::class, 'processSensorData']);

Route::get('/relay/status', [RelayController::class, 'getStatus']);
Route::post('/relay/status/{status}', [RelayController::class, 'setStatus']);

Route::post('sensor-data', [SensorDataController::class, 'store'])->name('sensor-data.store');
Route::apiResource('sensors', SensorController::class);
