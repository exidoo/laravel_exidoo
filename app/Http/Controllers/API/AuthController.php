<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function getLoginPage()
    {
        return view('auth.login');
    }

    public function getRegisterPage()
    {
        return view('auth.register');
    }

    // Register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('auth.login.page')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return redirect()->route('auth.login.page')->with('error', 'Username atau password salah.');
            }
        } catch (JWTException $e) {
            return redirect()->route('auth.login.page')->with('error', 'Terjadi kesalahan saat mencoba login.');
        }

        // Simpan token ke dalam session
        session(['jwt_token' => $token]);

        return redirect()->route('hospitals.index')->with('success', 'Login berhasil!');
    }


    // Logout
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
