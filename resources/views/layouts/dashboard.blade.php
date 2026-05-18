@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Admin')

@section('content')
{{-- STATS CARDS --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card d-flex justify-content-between align-items-center">
            <div>
                <h6 class="text-muted mb-1">Total Users</h6>
                <h3 class="mb-0">{{ number_format($stats['total_users']) }}</h3>
            </div>
            <i class="bi bi-people"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex justify-content-between align-items-center" style="border-left-color: #28a745;">
            <div>
                <h6 class="text-muted mb-1">Total Booking</h6>
                <h3 class="mb-0">{{ number_format($stats['total_bookings']) }}</h3>
            </div>
            <i class="bi bi-calendar-check" style="color: #28a745;"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex justify-content-between align-items-center" style="border-left-color: #ffc107;">
            <div>
                <h6 class="text-muted mb-1">Pending</h6>
                <h3 class="mb-0">{{ number_format($stats['pending_bookings']) }}</h3>
            </div>
            <i class="bi bi-clock-history" style="color: #ffc107;"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex justify-content-between align-items-center" style="border-left-color: #17a2b8;">
            <div>
                <h6 class="text-muted mb-1">Pendapatan</h6>
                <h3 class="mb-0">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
            </div>
            <i class="bi bi-cash-stack" style="color: #17a2b8;"></i>
        </div>
    </div>
</div>

{{-- RECENT BOOKINGS --}}
<div class="table-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Booking Terbaru</h5>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Studio</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_bookings as $booking)
                <tr>
                    <td>#{{ $booking->id }}</td>
                    <td>{{ $booking->user->nama_lengkap }}</td>
                    <td>{{ $booking->studio->nama }}</td>
                    <td>{{ $booking->tanggal->format('d M Y') }} {{ $booking->jam_mulai->format('H:i') }}</td>
                    <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-{{ $booking->status }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada booking</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection