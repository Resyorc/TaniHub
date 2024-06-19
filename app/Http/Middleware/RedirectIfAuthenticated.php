<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                // ke dashboard
                return redirect()->route('admin.dashboard');
            } //else {
            //     // ke home
            //     return redirect()->route('dashboard');
            // }
        }

        return $next($request);
    }
}
