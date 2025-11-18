<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin($role)
    {
        return view('auth.login', ['role' => $role]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            switch ($user->role) {
                case 'kepala_sekolah':
                    return redirect()->route('dashboard.kepsek');
                case 'guru':
                    return redirect()->route('dashboard.guru');
                case 'siswa':
                    return redirect()->route('dashboard.siswa');
                case 'orang_tua':
                    return redirect()->route('dashboard.orangtua');
                case 'dinas':
                    return redirect()->route('dashboard.dinas');
                default:
                    return redirect()->route('home');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
