<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
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

Route::get('/relay/{action}', function ($action) {
    $response = Http::get('http://192.168.0.110/control', [
        'action' => $action,
    ]);

    return $response->body();
});