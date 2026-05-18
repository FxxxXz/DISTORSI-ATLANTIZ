<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Bagian Booking Saya --}}
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Booking Saya</h5>
    </div>
    <div class="card-body">
        @php
            $myBookings = Auth::user()->bookings()->with('studio', 'payment')->latest()->take(5)->get();
        @endphp

        @forelse($myBookings as $booking)
            <div class="d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded-3">
                <div>
                    <div class="fw-semibold">{{ $booking->studio->nama }}</div>
                    <small class="text-muted">{{ $booking->tanggal->format('d M Y') }} | {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</small>
                    <div class="mt-1">{!! $booking->status_badge !!}</div>
                </div>
                <div class="text-end">
                    <div class="fw-bold text-danger mb-1">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</div>
                    
                    @if($booking->status === 'pending' && !$booking->payment)
                        <a href="{{ route('payment.form', $booking) }}" class="btn btn-danger btn-sm">
                            <i class="bi bi-credit-card me-1"></i>Bayar
                        </a>
                    @elseif($booking->payment)
                        <a href="{{ route('payment.status', $booking->payment) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-receipt me-1"></i>{{ ucfirst($booking->payment->status) }}
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-muted text-center mb-0">Belum ada booking</p>
        @endforelse
    </div>
</div>