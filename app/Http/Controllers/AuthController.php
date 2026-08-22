<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan Role
            if ($user->isAdmin() || $user->role === 'tutor') {
                return redirect()->intended(route('admin.dashboard'));
            }

            if ($user->role === 'affiliate') {
                return redirect()->intended(route('affiliate.dashboard'));
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function showRegisterForm(Request $request)
    {
        $ref = $request->query('ref');
        return view('auth.register', compact('ref'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'school_origin' => 'required|string|max:255',
            'password'      => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'school_origin' => $request->school_origin,
            'password'      => Hash::make($request->password),
            'role'          => 'user',
            'referral_code' => strtoupper(Str::random(6)),
            'referred_by'   => $request->referred_by ?? null,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Selamat Datang di Tryoutin!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
