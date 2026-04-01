<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\PasswordResetToken;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        try {
            $adminRole = \App\Models\Role::where('name', 'Admin')->first();

            if (!$adminRole) {
                throw new \Exception('Admin role not found in database.');
            }

            $roles = collect([$adminRole]);

            return view('auth.register', compact('roles'));
        } catch (\Exception $e) {
            Log::error('Register form error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Registration form temporarily unavailable.');
        }
    }
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[A-Za-z\s]+$/'
                ],
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
                'role_id' => 'required|exists:roles,id',
            ], [
                'name.regex' => 'The name field must contain only letters and spaces. Special characters and numbers are not allowed.',
                'email.unique' => 'This email is already registered.',
                'password.confirmed' => 'Passwords do not match.',
            ]);

            $selectedRole = \App\Models\Role::find($request->role_id);
            if (!$selectedRole || $selectedRole->name !== 'Admin') {
                return back()->withErrors(['error' => 'Only Admin role can register through this form.'])->withInput();
            }

            $token = Str::random(64);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'verification_token' => $token,
                'email_status' => 'Unverified',
                'status' => 'active',
            ]);

            Mail::send('emails.verifyEmail', ['token' => $token, 'user' => $user], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Verify Your Email Address');
            });

            return redirect('/login')->with('success', 'Registration successful! Please verify your email.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Registration Error: ' . $e->getMessage());
            return back()->with('error', 'Registration failed. Please try again.');
        }
    }

    public function verifyEmail($token)
    {
        try {
            $user = User::where('verification_token', $token)->firstOrFail();

            $user->email_verified_at = now();
            $user->verification_token = null;
            $user->email_status = 'Verified';
            $user->save();

            Log::info('User email verified: ' . $user->email);

            return redirect('/')->with('success', 'Your email has been verified! You can now log in.');
        } catch (ModelNotFoundException $e) {
            Log::error('User email verification token invalid: ' . $token);
            return redirect('/')->with('error', 'Invalid or expired verification link.');
        } catch (\Exception $e) {
            Log::error('User email verification error: ' . $e->getMessage());
            return redirect('/')->with('error', 'Email verification failed. Please try again or contact support.');
        }
    }


    public function showLoginForm()
    {
        try {

            return view('login');
        } catch (\Exception $e) {
            Log::error('Login form error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Login page temporarily unavailable.');
        }
    }


    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()->with('error', 'Invalid credentials');
            }

            if (!$user->email_verified_at) {
                return back()->with('error', 'Please verify your email before logging in.');
            }

            if ($user->status !== 'active') {
                return back()->with('error', 'Your account is inactive. Please contact admin.');
            }

            if (!Hash::check($request->password, $user->password)) {
                return back()->with('error', 'Invalid credentials');
            }

            $currentStatus = Session::get('login_status');

            if ($user->role_id == 1) {
                if ($currentStatus === 'user') {
                    Auth::logout();
                    Session::forget('login_status');

                    Session::put('login_status', 'admin');
                    Auth::login($user);
                    return redirect('/admin/dashboard')->with('success', 'Admin login successful');
                }

                Session::put('login_status', 'admin');
                Auth::login($user);
                return redirect('/admin/dashboard')->with('success', 'Admin login successful');
            } else {

                if ($currentStatus === 'admin') {
                    return back()->with('error', 'Please log out the admin first before you can log in.');
                }

                Session::put('login_status', 'user');
                Auth::login($user);

                switch ($user->role_id) {
                    case 2:
                        return redirect('/user/dashboard');
                    case 3:
                        return redirect('/receptionist/dashboard');
                    case 4:
                        return redirect('/clerk/dashboard');
                    case 5:
                        return redirect('/doctor/dashboard');
                    case 6:
                        return redirect('/nurse/dashboard');
                    default:
                        return redirect('/dashboard')->with('warning', 'Role access being configured.');
                }
            }
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Login system error: ' . $e->getMessage());
            return back()->with('error', 'Login system error. Please try again.');
        }
    }

    public function logout(Request $request)
    {
        try {
            if (Auth::guard('admin')->check()) {
                Auth::guard('admin')->logout();
            }

            if (Auth::check()) {
                Auth::logout();
            }

            Session::forget('login_status');
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('success', 'Logged out successfully');
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return redirect('/login')->with('info', 'Logged out with minor issues.');
        }
    }

    public function showForgotPasswordForm()
    {
        try {
            return view('auth.forgot-password');
        } catch (\Exception $e) {
            Log::error('Forgot password form error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Forgot password page temporarily unavailable.');
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|confirmed',
            ]);

            $user = User::where('email', $request->email)->first();
            $admin = Admin::where('email', $request->email)->first();

            if (!$user && !$admin) {
                return back()->withErrors(['email' => 'No account found with this email.']);
            }

            if ($request->password !== $request->password_confirmation) {
                return back()->withErrors(['password' => 'Passwords do not match.']);
            }



            $token = Str::random(64);

            PasswordResetToken::where('email', $request->email)->delete();

            PasswordResetToken::create([
                'email' => $request->email,
                'token' => $token,
                'new_password' => Hash::make($request->password),
                'created_at' => now(),
            ]);

            $account = $user ?: $admin;

            Log::info('Attempting to send password reset email to: ' . $account->email);

            try {
                $uniqueId = Str::random(10);
                Mail::send('emails.resetPassword', [
                    'token' => $token,
                    'user' => $account,
                    'unique_id' => $uniqueId
                ], function ($message) use ($account, $uniqueId) {
                    $message->to($account->email);
                    $message->subject('Reset Your Password - ' . $uniqueId);
                    Log::info('Password reset email sent to: ' . $account->email . ' with unique ID: ' . $uniqueId);
                });

                Log::info('Password reset email sent successfully to: ' . $account->email);
                return back()->with('success', 'Password reset email sent! Please check your email.');
            } catch (\Exception $e) {
                Log::error('Failed to send password reset email: ' . $e->getMessage());
                return back()->with('error', 'Failed to send reset email. Please try again.');
            }
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Forgot password error: ' . $e->getMessage());
            return back()->with('error', 'Failed to send password reset email. Please try again.');
        }
    }

    public function confirmReset($token)
    {
        try {
            $resetToken = PasswordResetToken::where('token', $token)->first();

            if (!$resetToken || $resetToken->created_at < now()->subMinutes(60)) {
                if ($resetToken) {
                    $resetToken->delete();
                }
                return redirect('/login')->with('error', 'Invalid or expired reset link.');
            }

            $user = User::where('email', $resetToken->email)->first();
            $admin = Admin::where('email', $resetToken->email)->first();

            if (!$user && !$admin) {
                $resetToken->delete();
                return redirect('/login')->with('error', 'Account not found.');
            }

            if (!$resetToken->new_password) {
                $resetToken->delete();
                return redirect('/login')->with('error', 'Invalid reset link.');
            }

            $account = $user ?: $admin;
            $account->password = $resetToken->new_password;
            $account->save();

            $resetToken->delete();

            Log::info('Password reset successful for: ' . $account->email);

            return redirect('/login')->with('success', 'Your password has been updated successfully.');
        } catch (\Exception $e) {
            Log::error('Password reset confirmation error: ' . $e->getMessage());
            return redirect('/login')->with('error', '');
        }
    }

    public function providerLogin(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()->with('error', 'Invalid credentials');
            }

            if (!$user->email_verified_at) {
                return back()->with('error', 'Please verify your email before logging in.');
            }

            if ($user->status !== 'active') {
                return back()->with('error', 'Your account is inactive. Please contact admin.');
            }

            if (!Hash::check($request->password, $user->password)) {
                return back()->with('error', 'Invalid credentials');
            }

            if (!in_array($user->role_id, [3, 5, 6])) {
                return back()->with('error', 'Access denied. Only providers can login through this form.');
            }

            // Set session status like in the main login method
            Session::put('login_status', 'user');
            Auth::login($user);

            switch ($user->role_id) {
                case 5:
                    return redirect('/doctor/dashboard');
                case 3:
                    return redirect('/receptionist/dashboard');
                case 6:
                    return redirect('/nurse/dashboard');
                default:
                     Log::warning('Provider login with unexpected role', [
                        'role' => $user->role_id,
                        'user_id' => $user->id
                    ]);
                    return redirect('/dashboard')->with('warning', 'Role access being configured.');
            }
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Provider login system error: ' . $e->getMessage());
            return back()->with('error', 'Login system error. Please try again.');
        }
    }
}
