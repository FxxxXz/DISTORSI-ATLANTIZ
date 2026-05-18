<?php
// app/Http/Controllers/Admin/StudioController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::latest()->paginate(10);
        return view('admin.studios.index', compact('studios'));
    }

    public function create()
    {
        return view('admin.studios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:regular,premium,recording',
            'deskripsi' => 'required|string',
            'fasilitas' => 'required|array',
            'harga_per_jam' => 'required|numeric|min:0',
            'harga_per_sesi' => 'nullable|numeric|min:0',
            'durasi_sesi' => 'nullable|integer|min:1',
            'kapasitas' => 'required|integer|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);
        $validated['fasilitas'] = json_encode($validated['fasilitas']);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('studios', 'public');
        }

        Studio::create($validated);

        return redirect()->route('admin.studios.index')->with('success', 'Studio berhasil ditambahkan.');
    }

    public function edit(Studio $studio)
    {
        return view('admin.studios.edit', compact('studio'));
    }

    public function update(Request $request, Studio $studio)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:regular,premium,recording',
            'deskripsi' => 'required|string',
            'fasilitas' => 'required|array',
            'harga_per_jam' => 'required|numeric|min:0',
            'harga_per_sesi' => 'nullable|numeric|min:0',
            'durasi_sesi' => 'nullable|integer|min:1',
            'kapasitas' => 'required|integer|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_aktif' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);
        $validated['fasilitas'] = json_encode($validated['fasilitas']);
        $validated['is_aktif'] = $request->boolean('is_aktif', false);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('studios', 'public');
        }

        $studio->update($validated);

        return redirect()->route('admin.studios.index')->with('success', 'Studio berhasil diupdate.');
    }

    public function destroy(Studio $studio)
    {
        $studio->delete();
        return redirect()->route('admin.studios.index')->with('success', 'Studio berhasil dihapus.');
    }
}