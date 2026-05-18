<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Studio;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display the booking page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $studios = Studio::all();
        return view('booking', compact('studios'));
    }

    /**
     * Store a new booking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'studio_id' => 'required|exists:studios,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'durasi' => 'required|integer|min:1|max:8',
            'jumlah_orang' => 'required|integer|min:1|max:20',
            'catatan' => 'nullable|string',
        ]);

        // Hitung jam selesai
        $jamMulai = $request->jam_mulai;
        $durasi = $request->durasi;
        $jamSelesai = date('H:i', strtotime($jamMulai . ' + ' . $durasi . ' hours'));

        // Ambil data studio
        $studio = Studio::findOrFail($request->studio_id);
        $totalHarga = $studio->harga_per_jam * $durasi;

        // Simpan booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'nama_lengkap' => $request->nama_lengkap,
            'studio_id' => $request->studio_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
            'durasi' => $durasi,
            'total_harga' => $totalHarga,
            'catatan' => $request->catatan,
            'status' => 'pending',
        ]);

        // Return JSON untuk AJAX
        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil! Silakan tunggu konfirmasi dari admin.',
            'booking_id' => $booking->id
        ]);
    }
}