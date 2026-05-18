<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
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
        $request->validate([
        'namaLengkap' => ['required', 'string', 'max:255', 'min:3'],
        'username' => ['required', 'string', 'max:255', 'min:5', 'unique:users,username'],
        'email' => ['required', 'string', 'email:dns', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:6', 'confirmed'],
    ]);

        $user = User::create([
        'nama_lengkap' => $request->namaLengkap,
        'username' => strtolower($request->username),
        'email' => strtolower($request->email),
        'password' => Hash::make($request->password),
        'role' => 'user',
        'is_active' => true,
    ]);

        Auth::login($user);

        return response()->json([
        'success' => true,
        'message' => 'Registrasi berhasil!',
        'redirect' => route('home')  // ← UBAH INI: dari 'dashboard' jadi 'home'
    ]);
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')->with('success', 'Berhasil logout.');
    }
}