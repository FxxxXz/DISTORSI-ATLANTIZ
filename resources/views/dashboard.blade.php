@extends('layouts.app')

@section('title', 'Pembayaran Saya - Distorsi Atlantiz')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-white mb-0" style="font-size: 1.75rem;">
                    <i class="bi bi-credit-card me-2" style="color: #ff4444;"></i>Pembayaran Saya
                </h2>
                <a href="{{ route('booking.index') }}" class="btn fw-semibold text-white" style="background: #ff4444; border: none; padding: 0.6rem 1.5rem;">
                    <i class="bi bi-plus-lg me-2"></i>Booking Baru
                </a>
            </div>

            {{-- Statistik Card --}}
            @php
                $stats = [
                    'pending' => Auth::user()->bookings()->pending()->count(),
                    'confirmed' => Auth::user()->bookings()->confirmed()->count(),
                    'completed' => Auth::user()->bookings()->completed()->count(),
                ];
            @endphp
            
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0" style="background: #1a1a1a;">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1" style="color: #888; font-size: 0.85rem;">Menunggu Pembayaran</p>
                                <h3 class="fw-bold text-white mb-0" style="font-size: 1.75rem;">{{ $stats['pending'] }}</h3>
                            </div>
                            <i class="bi bi-clock-history fs-1" style="color: #ff4444;"></i>
                        </div>
                        <div style="height: 3px; background: #ff4444; border-radius: 0 0 0.375rem 0.375rem;"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0" style="background: #1a1a1a;">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1" style="color: #888; font-size: 0.85rem;">Terkonfirmasi</p>
                                <h3 class="fw-bold text-white mb-0" style="font-size: 1.75rem;">{{ $stats['confirmed'] }}</h3>
                            </div>
                            <i class="bi bi-check-circle fs-1" style="color: #4ade80;"></i>
                        </div>
                        <div style="height: 3px; background: #4ade80; border-radius: 0 0 0.375rem 0.375rem;"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0" style="background: #1a1a1a;">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-1" style="color: #888; font-size: 0.85rem;">Selesai</p>
                                <h3 class="fw-bold text-white mb-0" style="font-size: 1.75rem;">{{ $stats['completed'] }}</h3>
                            </div>
                            <i class="bi bi-calendar-check fs-1" style="color: #60a5fa;"></i>
                        </div>
                        <div style="height: 3px; background: #60a5fa; border-radius: 0 0 0.375rem 0.375rem;"></div>
                    </div>
                </div>
            </div>

            {{-- Daftar Transaksi --}}
            <div class="card border-0" style="background: #1a1a1a;">
                <div class="card-header border-0 d-flex align-items-center py-3" style="background: #111;">
                    <h5 class="mb-0 text-white fw-semibold">
                        <i class="bi bi-list-check me-2" style="color: #ff4444;"></i>Daftar Transaksi
                    </h5>
                </div>
                <div class="card-body p-4">

                    @php
                        $myBookings = Auth::user()->bookings()->with('studio', 'payment')->latest()->get();
                    @endphp

                    @forelse($myBookings as $booking)
                        @php
                            $paymentStatus = $booking->payment?->status ?? 'unpaid';
                            $paymentBadge = match($paymentStatus) {
                                'paid' => ['bg' => '#4ade80', 'text' => '#000'],
                                'pending' => ['bg' => '#fbbf24', 'text' => '#000'],
                                'expired' => ['bg' => '#ff4444', 'text' => '#fff'],
                                'failed' => ['bg' => '#ff4444', 'text' => '#fff'],
                                default => ['bg' => '#333', 'text' => '#888'],
                            };
                            
                            $step = match($booking->status) {
                                'pending' => 1,
                                'confirmed' => 2,
                                'completed' => 3,
                                'cancelled' => 0,
                                default => 1,
                            };
                        @endphp

                        <div class="card mb-3 border-0 overflow-hidden" style="background: #111;">
                            {{-- Header --}}
                            <div class="card-header border-0 py-3" style="background: #161616;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 d-flex align-items-center justify-content-center" 
                                             style="width: 48px; height: 48px; background: rgba(255, 68, 68, 0.15);">
                                            <i class="bi bi-music-note-beamed fs-4" style="color: #ff4444;"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold text-white mb-1" style="font-size: 1.1rem;">{{ $booking->studio->nama }}</h5>
                                            <p class="mb-0" style="color: #888; font-size: 0.8rem;">
                                                <i class="bi bi-calendar me-1"></i>{{ $booking->tanggal->format('d M Y') }}
                                                <span class="mx-1">|</span>
                                                <i class="bi bi-clock me-1"></i>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                                                <span class="mx-1">|</span>
                                                <i class="bi bi-hourglass me-1"></i>{{ $booking->durasi }} jam
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge border-0 fw-medium" 
                                              style="background: {{ $paymentBadge['bg'] }}; color: {{ $paymentBadge['text'] }}; padding: 0.4rem 0.8rem;">
                                            {{ $paymentStatus === 'unpaid' ? 'Belum Bayar' : ucfirst($paymentStatus) }}
                                        </span>
                                        @if($booking->payment?->expired_at && $booking->payment?->status === 'pending')
                                            <div class="mt-1 countdown" style="color: #ff4444; font-size: 0.75rem;" 
                                                 data-expiry="{{ $booking->payment->expired_at->toIso8601String() }}">
                                                <i class="bi bi-stopwatch me-1"></i>Menghitung...
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Progress Step --}}
                            @if($booking->status !== 'cancelled')
                                <div class="card-body py-3 border-bottom" style="border-color: #222 !important;">
                                    <div class="d-flex align-items-center justify-content-between position-relative">
                                        @php $steps = ['Booking', 'Pembayaran', 'Konfirmasi', 'Selesai']; @endphp
                                        @for($i = 0; $i < 4; $i++)
                                            <div class="d-flex flex-column align-items-center position-relative" style="z-index: 2;">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                     style="width: 32px; height: 32px; font-size: 0.75rem; border: 2px solid;
                                                     {{ $step > $i ? 'background: #ff4444; border-color: #ff4444; color: #fff;' : 'background: transparent; border-color: #333; color: #555;' }}">
                                                    @if($step > $i + 1)
                                                        <i class="bi bi-check-lg"></i>
                                                    @else
                                                        {{ $i + 1 }}
                                                    @endif
                                                </div>
                                                <small class="mt-1 fw-medium" 
                                                      style="font-size: 0.65rem; {{ $step > $i ? 'color: #ff4444;' : 'color: #555;' }}">
                                                    {{ $steps[$i] }}
                                                </small>
                                            </div>
                                            @if($i < 3)
                                                <div class="flex-fill mx-2" 
                                                     style="height: 2px; margin-top: -20px; background: {{ $step > $i + 1 ? '#ff4444' : '#222' }};"></div>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            @else
                                <div class="card-body py-3 border-bottom" style="border-color: #222 !important; background: rgba(255, 68, 68, 0.1);">
                                    <p class="mb-0" style="color: #ff4444; font-size: 0.85rem;">
                                        <i class="bi bi-x-circle me-2"></i>
                                        Booking dibatalkan 
                                        @if($booking->dibatalkan_pada)
                                            {{ $booking->dibatalkan_pada->diffForHumans() }}
                                        @endif
                                        @if($booking->alasan_pembatalan)
                                            • {{ $booking->alasan_pembatalan }}
                                        @endif
                                    </p>
                                </div>
                            @endif

                            {{-- Footer --}}
                            <div class="card-footer border-0 d-flex justify-content-between align-items-center py-3" style="background: #161616;">
                                <div>
                                    <span style="color: #888; font-size: 0.8rem;">Total:</span>
                                    <span class="fw-bold ms-2" style="color: #ff4444; font-size: 1.25rem;">
                                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                    </span>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    {{-- Belum Bayar --}}
                                    @if($booking->status === 'pending' && !$booking->payment)
                                        <a href="{{ route('payment.form', $booking) }}" 
                                           class="btn fw-semibold text-white" 
                                           style="background: #ff4444; border: none; padding: 0.5rem 1.25rem; font-size: 0.85rem;">
                                            <i class="bi bi-credit-card me-2"></i>Bayar Sekarang
                                        </a>
                                    
                                    {{-- Sudah ada Payment --}}
                                    @elseif($booking->payment)
                                        <a href="{{ route('payment.status', $booking->payment) }}" 
                                           class="btn fw-medium" 
                                           style="background: transparent; border: 1px solid #ff4444; color: #ff4444; padding: 0.5rem 1.25rem; font-size: 0.85rem;">
                                            <i class="bi bi-receipt me-2"></i>Detail Pembayaran
                                        </a>
                                        
                                        @if($booking->payment->status === 'pending' && !$booking->payment->payment_proof)
                                            <button class="btn btn-sm" onclick="toggleUpload('upload-{{ $booking->id }}')"
                                                    style="background: #222; border: 1px solid #333; color: #888; padding: 0.5rem 0.75rem;">
                                                <i class="bi bi-upload"></i>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            {{-- Hidden Upload Form --}}
                            @if($booking->payment && $booking->payment->status === 'pending' && !$booking->payment->payment_proof)
                                <div id="upload-{{ $booking->id }}" class="d-none card-body border-top" style="background: #0a0a0a; border-color: #222 !important;">
                                    <form action="{{ route('payment.proof', $booking->payment) }}" method="POST" enctype="multipart/form-data" 
                                          class="d-flex gap-3 align-items-end">
                                        @csrf
                                        <div class="flex-fill">
                                            <label class="form-label mb-1" style="color: #888; font-size: 0.75rem;">Upload Bukti Pembayaran</label>
                                            <input type="file" name="payment_proof" accept="image/*" required 
                                                   class="form-control form-control-sm border-0"
                                                   style="background: #1a1a1a; color: #fff; padding: 0.5rem;">
                                        </div>
                                        <button type="submit" class="btn fw-semibold text-dark" 
                                                style="background: #ff4444; border: none; padding: 0.5rem 1.25rem;">
                                            <i class="bi bi-send me-1"></i>Kirim
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                    @empty
                        {{-- Empty State --}}
                        <div class="text-center py-5">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 80px; height: 80px; background: #1a1a1a;">
                                <i class="bi bi-inbox fs-1" style="color: #333;"></i>
                            </div>
                            <h4 class="text-white mb-2" style="font-size: 1.25rem;">Belum Ada Transaksi</h4>
                            <p style="color: #888; font-size: 0.9rem;" class="mb-4">Mulai booking studio musik Anda sekarang</p>
                            <a href="{{ route('booking.index') }}" class="btn fw-semibold text-white" 
                               style="background: #ff4444; border: none; padding: 0.6rem 2rem;">
                                <i class="bi bi-plus-lg me-2"></i>Booking Studio
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Riwayat Selesai --}}
            @php
                $completedBookings = Auth::user()->bookings()->completed()->with('studio')->latest()->take(5)->get();
            @endphp
            
            @if($completedBookings->count() > 0)
                <div class="card border-0 mt-4" style="background: #1a1a1a;">
                    <div class="card-header border-0 py-3" style="background: #111;">
                        <h6 class="mb-0 fw-semibold" style="color: #888; font-size: 0.85rem;">
                            <i class="bi bi-clock-history me-2"></i>Riwayat Selesai
                        </h6>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($completedBookings as $booking)
                            <div class="list-group-item border-0 d-flex justify-content-between align-items-center py-3" 
                                 style="background: #161616; border-bottom: 1px solid #222 !important;">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-check-circle-fill fs-5" style="color: #4ade80;"></i>
                                    <div>
                                        <span class="text-white fw-medium" style="font-size: 0.9rem;">{{ $booking->studio->nama }}</span>
                                        <span class="ms-2" style="color: #555; font-size: 0.75rem;">{{ $booking->tanggal->format('d M Y') }}</span>
                                    </div>
                                </div>
                                <span class="fw-semibold text-white" style="font-size: 0.9rem;">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleUpload(id) {
    const el = document.getElementById(id);
    el.classList.toggle('d-none');
}

// Countdown timer
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.countdown').forEach(el => {
        const expiry = new Date(el.dataset.expiry).getTime();
        
        function update() {
            const now = new Date().getTime();
            const distance = expiry - now;
            
            if (distance < 0) {
                el.innerHTML = '<span style="background: #ff4444; color: #fff; padding: 0.2rem 0.5rem; border-radius: 0.25rem; font-size: 0.7rem; font-weight: 600;">KEDALUWARSA</span>';
                return;
            }
            
            const h = Math.floor(distance / (1000 * 60 * 60));
            const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const s = Math.floor((distance % (1000 * 60)) / 1000);
            
            el.innerHTML = `<i class="bi bi-stopwatch me-1"></i>${h}j ${m}m ${s}d`;
        }
        
        update();
        setInterval(update, 1000);
    });
});
</script>
@endpush