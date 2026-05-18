<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:1000',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = true;

        User::create($validated);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($id), 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'role' => 'required|in:admin,user',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'password' => 'nullable|string|min:8',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->boolean('is_active', $user->is_active);

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'User berhasil diupdate!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        if ($user->isAdmin() && User::admin()->count() <= 1) {
            return back()->with('error', 'Tidak bisa menghapus admin terakhir!');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User dihapus!');
    }
}