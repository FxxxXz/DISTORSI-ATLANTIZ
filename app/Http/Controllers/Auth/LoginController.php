<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

public function store(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Akun tidak ditemukan.']);
    }

    if ($user->is_active == 0) {
        return back()->withErrors(['email' => 'Akun dinonaktifkan.']);
    }

    // Coba login dengan remember
    if (Auth::attempt($credentials, $request->boolean('remember', false))) {
        $request->session()->regenerate();
        
        // PASTIKAN USER TERSIMPAN
        // dd(auth()->user()); // Uncomment untuk debug

        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}