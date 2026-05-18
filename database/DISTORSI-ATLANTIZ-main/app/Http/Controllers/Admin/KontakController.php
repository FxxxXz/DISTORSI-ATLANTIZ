<?php
// app/Http/Controllers/Admin/KontakController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        $kontaks = Kontak::with('reader')->latest()->paginate(15);
        return view('admin.kontaks.index', compact('kontaks'));
    }

    public function show($id)
    {
        $kontak = Kontak::findOrFail($id);
        
        // Tandai sudah dibaca (hanya sekali)
        if (!$kontak->dibaca_pada) {
            $kontak->update([
                'dibaca_pada' => now(),
                'dibaca_oleh' => auth()->id(),
                'status' => 'read',
            ]);
        }

        return view('admin.kontaks.show', compact('kontak'));
    }

    public function destroy($id)
    {
        Kontak::findOrFail($id)->delete();
        return redirect()->route('admin.kontaks')->with('success', 'Pesan dihapus!');
    }
}