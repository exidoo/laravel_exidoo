<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthControllerWeb extends Controller
{
    public function getLoginPage()
    {
        return view('auth.login');
    }

    public function getRegisterPage()
    {
        return view('auth.register'); // Pastikan view 'auth.register' ada
    }

    // Fungsi untuk login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string', // Sesuai dengan username
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        // Coba autentikasi user berdasarkan username dan password
        if (Auth::attempt($credentials)) {
            // Jika berhasil login, arahkan ke halaman utama
            return redirect()->intended('/');
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'login_error' => 'Username atau password salah',
        ]);
    }

    // Fungsi untuk logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = new User();
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect('/login');
    }
}
