<?php
// app/Http/Controllers/BookingController.php

namespace App\Http\Controllers;

use App\Models\Studio;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function index()
    {
        $studios = Studio::where('is_aktif', true)->get();
        return view('booking', compact('studios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'studio_id' => 'required|exists:studios,id',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'durasi' => 'required|integer|min:1|max:8',
            'jumlah_orang' => 'required|integer|min:1|max:20',
            'catatan' => 'nullable|string|max:500',
        ]);

        $studio = Studio::findOrFail($request->studio_id);
        
        if (!$studio->is_aktif) {
            throw ValidationException::withMessages([
                'studio_id' => 'Studio tidak tersedia saat ini.',
            ]);
        }

        // Hitung jam selesai
        $jamMulai = $validated['jam_mulai'];
        $durasi = $validated['durasi'];
        $jamSelesai = date('H:i', strtotime("{$jamMulai} + {$durasi} hours"));

        // Cek bentrok jadwal
        $conflict = Booking::where('studio_id', $validated['studio_id'])
            ->where('tanggal', $validated['tanggal'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($jamMulai, $jamSelesai) {
                $query->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                    ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai])
                    ->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                        $q->where('jam_mulai', '<=', $jamMulai)
                          ->where('jam_selesai', '>=', $jamSelesai);
                    });
            })
            ->exists();

        if ($conflict) {
            throw ValidationException::withMessages([
                'jam_mulai' => 'Studio sudah dibooking pada waktu tersebut. Silakan pilih waktu lain.',
            ]);
        }

        $totalHarga = $studio->harga_per_jam * $durasi;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'studio_id' => $validated['studio_id'],
            'tanggal' => $validated['tanggal'],
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'durasi' => $durasi,
            'total_harga' => $totalHarga,
            'catatan' => $validated['catatan'],
            'status' => 'pending',
        ]);

        return redirect()->route('booking.index')
            ->with('success', 'Booking berhasil! Silakan tunggu konfirmasi dari admin.');
    }
}