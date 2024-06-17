<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            $user = Auth::user();
            Log::info('User logged in', ['user_id' => $user->id, 'roles' => $user->roles]);

            if ($user->hasRole('admin')) {
                Log::info('User adminnn');

                return redirect()->route('admin.dashboard');
            } else {
                Log::info('nt adminnn');
                return redirect()->route('dashboard');
            }
        }

        Log::warning('Login attempt failed', ['email' => $request->email]);
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        Log::info('User logged out', ['user_id' => $user ? $user->id : 'guest']);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
