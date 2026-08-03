<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        return view('auth.admin-login');
    }

    /**
     * Handle an incoming admin login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $key = 'admin-login:'.strtolower($request->name).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'name' => __('auth.throttle', [
                    'seconds' => RateLimiter::availableIn($key),
                    'minutes' => ceil(RateLimiter::availableIn($key) / 60),
                ]),
            ]);
        }

        $credentials = [
            'name' => $request->name,
            'password' => $request->password,
        ];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($key);

            throw ValidationException::withMessages([
                'name' => __('auth.failed'),
            ]);
        }

        if (! Auth::user()->isAdmin()) {
            Auth::logout();

            RateLimiter::hit($key);

            throw ValidationException::withMessages([
                'name' => 'Akun ini bukan admin. Silakan login sebagai user di halaman login biasa.',
            ]);
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}
