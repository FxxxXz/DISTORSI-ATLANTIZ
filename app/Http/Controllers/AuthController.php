<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return auth()->user()->isAdmin() 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('home');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Cek user aktif
        $user = User::where('email', $credentials['email'])->first();
        
        if ($user && !$user->is_active) {
            throw ValidationException::withMessages([
                'email' => 'Akun Anda dinonaktifkan. Hubungi admin.',
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            return redirect()->intended(
                auth()->user()->isAdmin() 
                    ? route('admin.dashboard') 
                    : route('home')
            );
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|min:3|max:255',
            'username' => 'required|string|min:5|max:255|unique:users|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registrasi berhasil!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')->with('success', 'Berhasil logout.');
    }
}