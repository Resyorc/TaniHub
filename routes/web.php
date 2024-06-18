<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

// Rute untuk registrasi dan login
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('auth.register');
Route::post('/register', [RegisterController::class, 'register'])->name('auth.register-proses');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('auth.login');
Route::post('/login', [LoginController::class, 'login'])->name('auth.login-proses');

// Auth routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Rute untuk relay
Route::get('/relay', function () {
    return view('relay');
})->name('relay');

// Rute untuk perangkat (devices)
Route::get('/device', [DeviceController::class, 'index'])->name('device.index');
Route::get('devices/create', [DeviceController::class, 'create'])->name('devices.create');
Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');
Route::get('/devices/{device}', [DeviceController::class, 'show'])->name('devices.show');
Route::get('/devices/{device}/edit', [DeviceController::class, 'edit'])->name('devices.edit');
Route::put('/devices/{device}', [DeviceController::class, 'update'])->name('devices.update');
Route::delete('/devices/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [BerandaController::class, 'index'])->name('dashboard');

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        // Rute admin lainnya
    });
});


