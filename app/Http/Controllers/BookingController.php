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
        'telepon' => 'required|string|regex:/^[0-9]+$/|min:10|max:15',
        'studio_id' => 'required|exists:studios,id',
        'tanggal' => 'required|date',
        'jam_mulai' => 'required',
        'durasi' => 'required|integer|min:1|max:8',
        'jumlah_orang' => 'required|integer|min:1|max:20',
        'catatan' => 'nullable|string',
    ], [
        // Custom messages dalam bahasa Indonesia
        'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        'telepon.required' => 'Nomor telepon wajib diisi.',
        'telepon.regex' => 'Nomor telepon hanya boleh berisi angka.',
        'telepon.min' => 'Nomor telepon minimal 10 digit.',
        'telepon.max' => 'Nomor telepon maksimal 15 digit.',
        'studio_id.required' => 'Silakan pilih studio.',
        'tanggal.required' => 'Tanggal booking wajib diisi.',
        'jam_mulai.required' => 'Jam mulai wajib dipilih.',
        'durasi.required' => 'Durasi wajib dipilih.',
        'durasi.min' => 'Durasi minimal 1 jam.',
        'durasi.max' => 'Durasi maksimal 8 jam.',
        'jumlah_orang.required' => 'Jumlah orang wajib diisi.',
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