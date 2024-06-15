<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Illuminate\Support\Facades\Http;

// Route::get('/', function () {
//     return view('app');
// });

Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register-proses'])->name('auth.register-proses');
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login-proses'])->name('auth.login-proses');
Route::get('/', [BerandaController::class, 'index'])->name('beranda.index');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/device', [DeviceController::class, 'index'])->name('device.index');
Route::get('devices/create', [DeviceController::class, 'create'])->name('devices.create');
Route::resource('devices', DeviceController::class);
Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');
Route::get('/devices/{device}', [DeviceController::class, 'show'])->name('devices.show');
Route::get('/devices/{device}/edit', [DeviceController::class, 'edit'])->name('devices.edit');
Route::put('/devices/{device}', [DeviceController::class, 'update'])->name('devices.update');
Route::delete('/devices/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy');

