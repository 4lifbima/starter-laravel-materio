<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin()
    {
        return view('content.authentications.auth-login-basic');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        // Check if user exists and is not banned
        if ($user && $user->isBanned()) {
            return back()->withErrors([
                'email' => 'Akun Anda telah diblokir. Silakan hubungi administrator.',
            ])->onlyInput('email');
        }

        // Check if user is inactive
        if ($user && !$user->isActive()) {
            return back()->withErrors([
                'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Update last login info
            Auth::user()->updateLastLogin($request->ip());

            // Log activity
            ActivityLog::log(
                'auth',
                'User logged in',
                Auth::user(),
                Auth::user(),
                ['ip' => $request->ip()]
            );

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ])->onlyInput('email');
    }

    /**
     * Show registration form.
     */
    public function showRegister()
    {
        return view('content.authentications.auth-register-basic');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'terms' => ['accepted'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Assign default role
        $user->assignRole('user');

        // Log activity
        ActivityLog::log(
            'auth',
            'New user registered',
            $user,
            $user,
            ['ip' => $request->ip()]
        );

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    /**
     * Show forgot password form.
     */
    public function showForgotPassword()
    {
        return view('content.authentications.auth-forgot-password-basic');
    }

    /**
     * Handle forgot password request.
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // In a real application, you would send a password reset email here
        // For now, we'll just show a success message

        return back()->with('status', 'Jika email terdaftar, link reset password akan dikirim.');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        // Log activity before logout
        if (Auth::check()) {
            ActivityLog::log(
                'auth',
                'User logged out',
                Auth::user(),
                Auth::user(),
                ['ip' => $request->ip()]
            );
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
