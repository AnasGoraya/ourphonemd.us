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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminController extends Controller
{
    public function registerPage()
    {
        try {
            return view('admin.register');
        } catch (\Exception $e) {
            Log::error('Admin register page error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Admin registration page unavailable.');
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:admins,email',
                'password' => 'required|min:6'
            ]);

            $token = Str::random(64);

            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'verification_token' => $token,
            ]);

            Log::info('Attempting to send verification email to admin: ' . $admin->email);

            try {
                Mail::send('emails.verifyEmail', [
                    'token' => $token,
                    'user' => $admin
                ], function ($message) use ($admin) {
                    $message->to($admin->email);
                    $message->subject('Verify Your Email Address');
                    Log::info('Email sent to admin: ' . $admin->email);
                });

                Log::info('Verification email sent successfully to admin: ' . $admin->email);

                return redirect('/login')->with('success', 'Admin registered successfully! Please check your email for verification.');
            } catch (\Exception $e) {
                Log::error('Failed to send verification email to admin: ' . $e->getMessage());
                return redirect('/login')->with('success', 'Admin registered successfully! But verification email failed. Please contact support.');
            }
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Admin registration error: ' . $e->getMessage());
            return back()->with('error', 'Admin registration failed. Please try again.');
        }
    }

    public function loginPage()
    {
        try {
            return view('admin.login');
        } catch (\Exception $e) {
            Log::error('Admin login page error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Admin login page unavailable.');
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (Auth::guard('web')->check() || Auth::guard('admin')->check()) {
                return redirect()->back()->with('error', 'Please logout from existing session first');
            }

            $admin = Admin::where('email', $request->email)->first();

            if (!$admin) {
                return back()->with('error', 'Invalid credentials');
            }

            if (!$admin->email_verified_at) {
                return back()->with('error', 'Please verify your email before logging in.');
            }

            if (!Hash::check($request->password, $admin->password)) {
                return back()->with('error', 'Invalid credentials');
            }

            if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
                return redirect('/admin/dashboard')->with('success', 'Admin login successful!');
            }

            return back()->with('error', 'Invalid credentials');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Admin login error: ' . $e->getMessage());
            return back()->with('error', 'Login failed. Please try again.');
        }
    }

    public function dashboard()
    {
        try {
            $users = \App\Models\User::whereIn('role_id', [3, 5, 6])->get();
            $tasks = \App\Models\Task::all();

            $userStats = \App\Models\User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereIn('role_id', [3, 5, 6])
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month');

            $taskStats = [
                'done' => \App\Models\Task::where('status', 'Done')->count(),
                'pending' => \App\Models\Task::where('status', 'Pending')->count(),
                'finish' => \App\Models\Task::where('status', 'Finish')->count(),
            ];

            return view('admin.dashboard', compact('users', 'tasks', 'userStats', 'taskStats'));
        } catch (\Exception $e) {
            Log::error('Admin dashboard error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load admin dashboard.');
        }
    }
    public function createUser(Request $request)
    {
        try {
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-zA-Z\s]+$/',
                ],
                'email' => 'required|email',
                'password' => 'required|min:6',
                'role_id' => 'required|in:3,5,6'
            ], [
                'name.regex' => 'Special characters and numbers are not allowed in the name field.',
            ]);

            $email = strtolower(trim($request->email));
            $emailExistsInUsers = User::whereRaw('LOWER(email) = ?', [$email])->exists();
            $emailExistsInAdmins = Admin::whereRaw('LOWER(email) = ?', [$email])->exists();

            if ($emailExistsInUsers || $emailExistsInAdmins) {
                return back()->with('error', 'Email already exists.')->withInput();
            }

            $token = Str::random(64);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'status' => 'active',
                'verification_token' => $token,
                'email_status' => 'Unverified',
            ]);

            try {
                Mail::send('emails.verifyEmail', [
                    'token' => $token,
                    'user' => $user
                ], function ($message) use ($user) {
                    $message->to($user->email);
                    $message->subject('Verify Your Email Address');
                });

                Log::info('Verification email sent successfully to: ' . $user->email);
            } catch (\Exception $e) {
                Log::error('Failed to send verification email: ' . $e->getMessage());
                return back()->with('error', 'User created but verification email failed. Please contact support.');
            }

            return back()->with('success', 'User created successfully and verification email sent!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('User creation error: ' . $e->getMessage());
            return back()->with('error', 'Failed to create user. Please try again.');
        }
    }

    public function assignTask(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'user_id' => 'required|exists:users,id'
            ]);

            Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => $request->user_id,
                'status' => 'Pending',
                'assigned_by' => Auth::guard('admin')->id(),
            ]);

            return back()->with('success', 'Task assigned successfully');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Task assignment error: ' . $e->getMessage());
            return back()->with('error', 'Failed to assign task. Please try again.');
        }
    }

    public function updateStatus(Request $request, Task $task)
    {
        try {
            $request->validate([
                'status' => 'required|in:Pending,Done,finish'
            ]);

            $task->update([
                'status' => $request->status
            ]);

            return back()->with('success', 'Task status updated successfully');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {
            Log::error('Task not found for status update: ' . $e->getMessage());
            return back()->with('error', 'Task not found.');
        } catch (\Exception $e) {
            Log::error('Task status update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update task status.');
        }
    }

    public function userManagement()
    {
        try {
            $users = User::whereIn('role_id', [3, 5, 6])->with('role')->get();
            return view('admin.users', compact('users'));
        } catch (\Exception $e) {
            Log::error('User management page error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load user management.');
        }
    }

    public function taskManagement()
    {
        try {
            $tasks = Task::with(['user', 'assignedBy'])->get();
            $users = User::whereIn('role_id', [3, 5, 6])->get();

            return view('admin.tasks', compact('tasks', 'users'));
        } catch (\Exception $e) {
            Log::error('Task management page error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load task management.');
        }
    }

    public function toggleUserStatus($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->status = $user->status === 'active' ? 'inactive' : 'active';
            $user->save();

            return back()->with('success', 'User status updated successfully!');
        } catch (ModelNotFoundException $e) {
            Log::error('User not found for status toggle: ' . $id);
            return back()->with('error', 'User not found.');
        } catch (\Exception $e) {
            Log::error('User status toggle error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update user status.');
        }
    }
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);

            if (Auth::guard('admin')->id() == $id) {
                return back()->with('error', 'You cannot delete yourself!');
            }

            $user->delete();

            return back()->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            Log::error('User delete error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete user.');
        }
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/',
            ],
            'email' => 'required|email',
            'role_id' => 'required|in:3,5,6',
        ], [
            'name.regex' => 'Special characters and numbers are not allowed in the name field.',
        ]);

        $email = strtolower(trim($request->email));
        $emailExistsInUsers = User::whereRaw('LOWER(email) = ?', [$email])->where('id', '!=', $id)->exists();
        $emailExistsInAdmins = Admin::whereRaw('LOWER(email) = ?', [$email])->exists();

        if ($emailExistsInUsers || $emailExistsInAdmins) {
            return back()->with('error', 'Email already exists.')->withInput();
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function logout1()
    {
        try {
            Auth::guard('admin')->logout();
            Cache::forget('login_status');
            return redirect('/login')->with('success', 'Logged out successfully');
        } catch (\Exception $e) {
            Log::error('Admin logout error: ' . $e->getMessage());
            return redirect('/login')->with('info', 'Logged out with minor issues.');
        }
    }

    public function verifyEmail($token)
    {
        try {
            $admin = Admin::where('verification_token', $token)->firstOrFail();

            $admin->email_verified_at = now();
            $admin->verification_token = null;
            $admin->save();

            Log::info('Admin email verified: ' . $admin->email);

            return redirect('/')->with('success', 'Your email has been verified! You can now log in.');
        } catch (ModelNotFoundException $e) {
            Log::error('Admin email verification token invalid: ' . $token);
            return redirect('/')->with('error', 'Invalid or expired verification link.');
        } catch (\Exception $e) {
            Log::error('Admin email verification error: ' . $e->getMessage());
            return redirect('/')->with('error', 'Email verification failed. Please try again or contact support.');
        }
    }

}
