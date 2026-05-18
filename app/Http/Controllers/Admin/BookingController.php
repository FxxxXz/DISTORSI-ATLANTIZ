<?php
// app/Http/Controllers/Admin/BookingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'studio']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $bookings = $query->latest()->paginate(20);
        
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);
        return back()->with('success', 'Booking berhasil dikonfirmasi.');
    }

    public function cancel(Request $request, Booking $booking)
    {
        $booking->update([
            'status' => 'cancelled',
            'alasan_pembatalan' => $request->alasan,
            'dibatalkan_pada' => now(),
        ]);
        return back()->with('success', 'Booking dibatalkan.');
    }

    public function complete(Booking $booking)
    {
        $booking->update(['status' => 'completed']);
        return back()->with('success', 'Booking diselesaikan.');
    }
}