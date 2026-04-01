<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function oneLoginPage()
    {
        try {
            return view('login');
        } catch (\Exception $e) {
            Log::error('Login page load error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Login page temporarily unavailable.');
        }
    }

    public function oneLogin(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'role' => 'required|in:1,2',
            ]);

            $credentials = $request->only('email', 'password');
            $roleId = $request->role;

            if ($roleId == 2) {
                if (Auth::check()) {
                    return back()->with('error', 'Please logout from user account first.');
                }
                if (Auth::guard('admin')->attempt($credentials)) {
                    return redirect('/admin/dashboard')->with('success', 'Admin login successful!');
                }
            } else {
                if (Auth::guard('admin')->check()) {
                    return back()->with('error', 'Please logout from admin account first.');
                }

                $user = User::where('email', $credentials['email'])
                    ->where('role_id', $roleId)
                    ->first();

                if ($user && Hash::check($credentials['password'], $user->password)) {
                    Auth::login($user);
                    return redirect('/user/dashboard')->with('success', 'Login successful!');
                }
            }

            return back()->with('error', 'Invalid credentials or role selection.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return back()->with('error', 'Login failed. Please try again.');
        }
    }

    public function registerPage()
    {
        try {
            return view('user.register');
        } catch (\Exception $e) {
            Log::error('Register page error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Registration page temporarily unavailable.');
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'role' => 'required|in:1,2',
            ]);

            if ($request->role == 2) {
                Admin::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                return redirect('/login')->with('success', 'Admin registered successfully');
            } else {
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => $request->role,
                ]);
                return redirect('/login')->with('success', 'User registered successfully');
            }

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return back()->with('error', 'Registration failed. Please try again.')->withInput();
        }
    }

    public function loginPage()
    {
        try {
            return view('user.login');
        } catch (\Exception $e) {
            Log::error('User login page error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Login page temporarily unavailable.');
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'role' => 'required|in:1,2',
            ]);

            $credentials = $request->only('email', 'password');
            $roleId = $request->role;

            $user = User::where('email', $credentials['email'])
                ->where('role_id', $roleId)
                ->first();

            if ($user && Hash::check($credentials['password'], $user->password)) {
                Auth::login($user);
                if ($roleId == 2) {
                    return redirect('/admin/dashboard')->with('success', 'Admin login successful!');
                } else {
                    return redirect('/user/dashboard')->with('success', 'Login successful!');
                }
            }

            return back()->with('error', 'Invalid credentials or role selection.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('User login error: ' . $e->getMessage());
            return back()->with('error', 'Login failed. Please try again.');
        }
    }

    public function dashboard()
    {
        try {
            if (!Auth::check()) {
                return redirect('/login')->with('error', 'Please login first');
            }

            if (Auth::user()->role_id != 2) {
                return redirect('/login')->with('error', 'Access denied for user dashboard');
            }

            $tasks = Task::where('user_id', Auth::id())->with('assignedBy')->get();
            return view('user.dashboard', compact('tasks'));

        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load dashboard. Please try again.');
        }
    }

    public function updateStatus(Request $request, Task $task)
    {
        try {
            $request->validate([
                'status' => 'required|in:Pending,finish'
            ]);

            if ($task->user_id != Auth::id() || $task->assigned_by) {
                abort(403, 'Unauthorized action.');
            }

            $task->update([
                'status' => $request->status
            ]);

            return back()->with('success', 'Task updated successfully');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Task status update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update task status.');
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            Cache::forget('login_status');
            return redirect('/login')->with('success','Logged out successfully');
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Logout completed with some issues.');
        }
    }
}
