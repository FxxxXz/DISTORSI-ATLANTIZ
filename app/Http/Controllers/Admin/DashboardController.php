<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Kontak;
use App\Models\Studio;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::user()->count(),
            'total_studios' => Studio::count(),
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::pending()->count(),
            'today_bookings' => Booking::today()->count(),
            'total_revenue' => Booking::whereIn('status', ['confirmed', 'completed'])->sum('total_harga'),
            'unread_messages' => Kontak::where('status', 'unread')->count(),
        ];

        $recent_bookings = Booking::with(['user', 'studio'])
            ->latest()
            ->take(10)
            ->get();

        $monthly_revenue = Booking::selectRaw('MONTH(created_at) as month, SUM(total_harga) as total')
            ->whereYear('created_at', now()->year)
            ->whereIn('status', ['confirmed', 'completed'])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->mapWithKeys(fn($v, $k) => [Carbon::create()->month($k)->translatedFormat('F') => $v]);

        return view('admin.dashboard', compact('stats', 'recent_bookings', 'monthly_revenue'));
    }
}