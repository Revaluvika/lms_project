<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Halaman login berdasarkan role
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Halaman Register
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Email atau password salah.']);
        } else {
            return redirect()->route('dashboard.index');
        }
    }

    /**
     * Proses Register
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('login.show')
            ->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    /**
     * Logout
     * HARUS menggunakan POST agar tidak error 419
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
