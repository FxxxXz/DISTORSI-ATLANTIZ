<?php
// app/Http/Controllers/Admin/StudioController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:100',
            'harga_per_jam' => 'required|numeric|min:0',
            'harga_per_sesi' => 'nullable|numeric|min:0',
            'durasi_sesi' => 'nullable|integer|min:1',
            'kapasitas' => 'required|integer|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_populer' => 'boolean',
            'is_best_value' => 'boolean',
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['nama']);
        $validated['fasilitas'] = json_encode($validated['fasilitas'] ?? []);
        $validated['is_populer'] = $request->boolean('is_populer', false);
        $validated['is_best_value'] = $request->boolean('is_best_value', false);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('studios', 'public');
        }

        Studio::create($validated);

        return redirect()->route('admin.studios')->with('success', 'Studio berhasil ditambahkan!');
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
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:100',
            'harga_per_jam' => 'required|numeric|min:0',
            'harga_per_sesi' => 'nullable|numeric|min:0',
            'durasi_sesi' => 'nullable|integer|min:1',
            'kapasitas' => 'required|integer|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_aktif' => 'boolean',
            'is_populer' => 'boolean',
            'is_best_value' => 'boolean',
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['nama'], $studio->id);
        $validated['fasilitas'] = json_encode($validated['fasilitas'] ?? []);
        $validated['is_aktif'] = $request->boolean('is_aktif', true);
        $validated['is_populer'] = $request->boolean('is_populer', false);
        $validated['is_best_value'] = $request->boolean('is_best_value', false);

        if ($request->hasFile('foto')) {
            if ($studio->foto) {
                Storage::disk('public')->delete($studio->foto);
            }
            $validated['foto'] = $request->file('foto')->store('studios', 'public');
        }

        $studio->update($validated);

        return redirect()->route('admin.studios')->with('success', 'Studio berhasil diupdate.');
    }

    public function destroy(Studio $studio)
    {
        if ($studio->foto) {
            Storage::disk('public')->delete($studio->foto);
        }
        
        $studio->delete();
        return redirect()->route('admin.studios')->with('success', 'Studio berhasil dihapus.');
    }

    private function generateUniqueSlug(string $nama, ?int $excludeId = null): string
    {
        $slug = Str::slug($nama);
        $originalSlug = $slug;
        $count = 1;

        while (Studio::where('slug', $slug)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}