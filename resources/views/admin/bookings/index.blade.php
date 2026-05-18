@extends('layouts.admin')

@section('title', 'Kelola Booking')

@section('content')
<div class="container-fluid">
    <div class="row">
        <main class="col-md-10 ms-sm-auto px-md-4 py-4">
            <h1>Kelola Booking</h1>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Studio</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status Booking</th>
                        <th>Payment</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->user->nama_lengkap }}</td>
                            <td>{{ $booking->studio->nama }}</td>
                            <td>{{ $booking->tanggal->format('d M Y') }}</td>
                            <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                            <td>{!! $booking->status_badge !!}</td>
                            <td>
                                @if($booking->payment)
                                    @php
                                        $payStatus = $booking->payment->status;
                                        $payBadge = match($payStatus) {
                                            'pending' => 'warning',
                                            'paid' => 'success',
                                            'failed' => 'danger',
                                            'expired' => 'secondary',
                                            default => 'secondary'
                                        };
                                        $methodIcon = match($booking->payment->method ?? '') {
                                            'transfer_bank' => 'bi-bank',
                                            'e_wallet' => 'bi-phone',
                                            'virtual_account' => 'bi-upc-scan',
                                            'qris' => 'bi-qr-code-scan',
                                            default => 'bi-credit-card'
                                        };
                                    @endphp
                                    <i class="bi {{ $methodIcon }} me-1"></i>
                                    <span class="badge bg-{{ $payBadge }}">{{ ucfirst($payStatus) }}</span>
                                    @if($payStatus === 'pending' && $booking->payment->payment_proof)
                                        <form action="{{ route('admin.payments.verify', $booking->payment) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success ms-1" onclick="return confirm('Verifikasi pembayaran ini?')">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <span class="badge bg-light text-dark">Belum Bayar</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">Belum ada booking</td></tr>
                    @endforelse
                </tbody>
            </table>
        </main>
    </div>
</div>
@endsection