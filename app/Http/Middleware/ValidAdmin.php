<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidAdmin
{
   public function handle(Request $request, Closure $next)
{
    if (Auth::guard('admin')->check()) {
        return $next($request);
    }

    if (Auth::check() && Auth::user()->role_id == 1) {
        return $next($request);
    }

    return redirect('/login')->with('error', 'Admin access required');
}
}
