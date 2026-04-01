<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return redirect('/login')->with('error', 'Please login to access dashboard.');
            }

            switch ($user->role_id) {
                case 1:
                    return view('dashboard.admin');
                case 2:
                    return view('dashboard.user');
                case 3:
                    return view('dashboard.receptionist');
                case 4:
                    return view('dashboard.clerk');
                default:
                    Log::warning('Unauthorized role access attempt: ' . $user->role_id);
                    abort(403, 'Unauthorized access for your role.');
            }

        } catch (\Exception $e) {
            Log::error('Dashboard access error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Unable to load dashboard. Please try again.');
        }
    }
}
