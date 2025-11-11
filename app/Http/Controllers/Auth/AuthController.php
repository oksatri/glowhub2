<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // Cari user berdasarkan email atau username
        $user = User::where('email', $login)
            ->orWhere('username', $login)
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $request->filled('remember'));
            // Pastikan session di-refresh agar role terbaca oleh middleware
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withInput($request->only('login'))->withErrors(['login' => 'Credentials do not match our records.']);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role', 'user'), // Default role is 'user'
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function forgotPassword()
    {
        return view('auth.forgot');
    }

    public function doForgot(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'No user found with that email address.']);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => now()]
        );

        // NOTE: There is no mailer configured in this scaffold. For now we show the token in session
        // so developers can copy it to a password-reset flow or test locally.
        return back()->with('status', 'Password reset token generated. Token (dev): ' . $token);
    }
}
