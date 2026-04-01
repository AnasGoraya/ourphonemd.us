<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class SessionGuard
{
    public function handle(Request $request, Closure $next)
    {
        // Key for tracking login status in cache
        $loginStatusKey = 'login_status';

        if ($request->is('*/login') && $request->isMethod('post')) {
            // Check if someone is already logged in
            $currentStatus = Cache::get($loginStatusKey);

            if ($request->is('admin/login*')) {
                if ($currentStatus === 'user') {
                    Auth::guard('admin')->logout();
                    return redirect()->back()->with('error', 'A user is currently logged in. Please logout first.');
                }
                Cache::put($loginStatusKey, 'admin', 720); // Store for 12 hours
            }

            if ($request->is('user/login*')) {
                if ($currentStatus === 'admin') {
                    Auth::guard('web')->logout();
                    return redirect()->back()->with('error', 'An admin is currently logged in. Please logout first.');
                }
                Cache::put($loginStatusKey, 'user', 720); // Store for 12 hours
            }
        }

        // Handle logout - clear the status
        if ($request->is('*/logout')) {
            Cache::forget($loginStatusKey);
        }

        return $next($request);
    }
}
