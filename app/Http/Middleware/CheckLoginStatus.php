<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLoginStatus
{
    public function handle(Request $request, Closure $next)
    {

        if ($request->is('admin/login') && Auth::guard('web')->check()) {
            return redirect()->back()->with('error', 'Please logout from user account first.');
        }

        if ($request->is('user/login') && Auth::guard('admin')->check()) {
            return redirect()->back()->with('error', 'Please logout from admin account first.');
        }

        return $next($request);
    }
}
