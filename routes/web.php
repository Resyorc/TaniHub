<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

// Rute untuk autentikasi
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'loginProses'])->name('auth.loginProses');
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'registerProses'])->name('auth.registerProses');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Rute untuk relay
Route::get('/relay', function () {
    return view('relay');
})->name('relay');

// Rute untuk perangkat (devices)
Route::get('/device', [DeviceController::class, 'index'])->name('devices.index');
Route::get('devices/create', [DeviceController::class, 'create'])->name('devices.create');
Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');
Route::get('/devices/{device}', [DeviceController::class, 'show'])->name('devices.show');
Route::get('/devices/{device}/edit', [DeviceController::class, 'edit'])->name('devices.edit');
Route::put('/devices/{device}', [DeviceController::class, 'update'])->name('devices.update');
Route::delete('/devices/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy');
// Route::group(['middleware' => ['auth']], function () {
//     Route::get('/', [BerandaController::class, 'index'])->name('dashboard');

//     Route::group(['middleware' => ['auth']], function () {
//         Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
//         // Rute admin lainnya
//     });
// });

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Rute admin lainnya
});


