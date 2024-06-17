<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            Log::info('User not authenticated');
            return redirect('/login');
        }

        $user = $request->user();
        // admin user bisa akses dashboard ges
        if ($user->hasRole('admin') || $user->hasRole('user')) {
            Log::info('User has admin or user role', ['user_id' => $user->id]);
            return $next($request);
        }

        Log::info('User does not have admin or user role', ['user_id' => $user->id]);
        return redirect('/login');
    }
}
