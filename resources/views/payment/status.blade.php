@extends('layouts.app')

@section('title', 'Status Pembayaran')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Status Pembayaran</h5>
                </div>
                <div class="card-body p-4">
                    @php
                        $statusConfig = [
                            'pending' => ['class' => 'bg-warning text-dark', 'icon' => 'bi-hourglass-split', 'text' => 'Menunggu Pembayaran'],
                            'paid' => ['class' => 'bg-success', 'icon' => 'bi-check-circle-fill', 'text' => 'Pembayaran Berhasil'],
                            'failed' => ['class' => 'bg-danger', 'icon' => 'bi-x-circle-fill', 'text' => 'Pembayaran Gagal'],
                            'expired' => ['class' => 'bg-secondary', 'icon' => 'bi-clock-history', 'text' => 'Kadaluarsa'],
                            'refunded' => ['class' => 'bg-info', 'icon' => 'bi-arrow-counterclockwise', 'text' => 'Dana Dikembalikan'],
                        ];
                        $config = $statusConfig[$payment->status];
                    @endphp

                    <div class="text-center mb-4">
                        <span class="badge {{ $config['class'] }} px-4 py-2 fs-6 rounded-pill">
                            <i class="bi {{ $config['icon'] }} me-2"></i>{{ $config['text'] }}
                        </span>
                    </div>

                    <div class="bg-light rounded-3 p-3 mb-4">
                        <div class="row g-2 small">
                            <div class="col-5 text-muted">Order ID:</div>
                            <div class="col-7 text-end fw-bold font-monospace">{{ $payment->order_id }}</div>
                            <div class="col-5 text-muted">Metode:</div>
                            <div class="col-7 text-end text-capitalize">{{ str_replace('_', ' ', $payment->method) }}</div>
                            <div class="col-5 text-muted">Total:</div>
                            <div class="col-7 text-end fw-bold text-danger">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                            <div class="col-5 text-muted">Dibuat:</div>
                            <div class="col-7 text-end">{{ $payment->created_at->format('d M Y, H:i') }}</div>
                            @if($payment->expired_at && $payment->status === 'pending')
                                <div class="col-5 text-muted">Berlaku sampai:</div>
                                <div class="col-7 text-end text-warning fw-semibold">
                                    <i class="bi bi-clock me-1"></i>{{ $payment->expired_at->format('d M Y, H:i') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($payment->status === 'pending')
                        <div class="alert alert-warning border-0 mb-4">
                            <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Instruksi Pembayaran</h6>
                            
                            @if($payment->method === 'transfer_bank')
                                <div class="small">
                                    <p class="mb-2">Transfer ke rekening:</p>
                                    <div class="bg-white rounded-2 p-2 mb-2">
                                        <div class="d-flex justify-content-between"><span>Bank BCA</span><span class="fw-bold">1234 5678 9012</span></div>
                                        <div class="d-flex justify-content-between"><span>Atas Nama</span><span class="fw-bold">PT Distorsi Atlantiz</span></div>
                                    </div>
                                    <p class="mb-0 text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Transfer sesuai nominal: <strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong></p>
                                </div>
                                
                            @elseif($payment->method === 'e_wallet')
                                <div class="small text-center">
                                    <p class="mb-2">Scan QRIS:</p>
                                    <div class="bg-white rounded-2 p-3 mb-2 d-inline-block">
                                        <div class="bg-secondary rounded-2" style="width:150px;height:150px;">
                                            <div class="d-flex align-items-center justify-content-center h-100 text-white">
                                                <i class="bi bi-qr-code fs-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-muted">QRIS Dummy (Simulasi)</p>
                                </div>
                                
                            @elseif($payment->method === 'virtual_account')
                                <div class="small text-center">
                                    <p class="mb-2">Virtual Account Number:</p>
                                    <div class="bg-white rounded-2 p-3 mb-2">
                                        <div class="fs-3 fw-bold text-primary font-monospace">88777{{ $payment->booking_id }}</div>
                                        <small class="text-muted">BCA Virtual Account</small>
                                    </div>
                                </div>
                                
                            @elseif($payment->method === 'qris')
                                <div class="small text-center">
                                    <p class="mb-2">Scan QRIS berikut:</p>
                                    <div class="bg-white rounded-2 p-3 mb-2 d-inline-block">
                                        <div class="bg-light border rounded-2 p-2" style="width:180px;height:180px;">
                                            <svg viewBox="0 0 100 100" class="w-100 h-100">
                                                <rect x="10" y="10" width="30" height="30" fill="#000"/>
                                                <rect x="15" y="15" width="20" height="20" fill="#fff"/>
                                                <rect x="20" y="20" width="10" height="10" fill="#000"/>
                                                <rect x="60" y="10" width="30" height="30" fill="#000"/>
                                                <rect x="65" y="15" width="20" height="20" fill="#fff"/>
                                                <rect x="70" y="20" width="10" height="10" fill="#000"/>
                                                <rect x="10" y="60" width="30" height="30" fill="#000"/>
                                                <rect x="15" y="65" width="20" height="20" fill="#fff"/>
                                                <rect x="20" y="70" width="10" height="10" fill="#000"/>
                                                <rect x="45" y="10" width="10" height="10" fill="#000"/>
                                                <rect x="45" y="30" width="10" height="10" fill="#000"/>
                                                <rect x="10" y="45" width="10" height="10" fill="#000"/>
                                                <rect x="30" y="45" width="10" height="10" fill="#000"/>
                                                <rect x="60" y="45" width="10" height="10" fill="#000"/>
                                                <rect x="80" y="45" width="10" height="10" fill="#000"/>
                                                <rect x="45" y="60" width="10" height="10" fill="#000"/>
                                                <rect x="45" y="80" width="10" height="10" fill="#000"/>
                                                <rect x="60" y="60" width="30" height="30" fill="#000"/>
                                                <rect x="65" y="65" width="20" height="20" fill="#fff"/>
                                                <rect x="70" y="70" width="10" height="10" fill="#000"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-muted small mb-0">QRIS Dummy (Simulasi)</p>
                                    <p class="text-info small mt-2"><i class="bi bi-info-circle me-1"></i>Support: GoPay, OVO, DANA, LinkAja, ShopeePay, QRIS lainnya</p>
                                </div>
                            @endif
                        </div>

                        <form action="{{ route('payment.proof', $payment) }}" method="POST" enctype="multipart/form-data" class="mb-3">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Upload Bukti Pembayaran</label>
                                <input type="file" name="payment_proof" class="form-control form-control-sm" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Catatan (opsional)</label>
                                <textarea name="notes" class="form-control form-control-sm" rows="2" placeholder="Nama pengirim, bank asal, dll"></textarea>
                            </div>
                            <button type="submit" class="btn btn-outline-primary btn-sm w-100 mb-2">
                                <i class="bi bi-upload me-2"></i>Konfirmasi Pembayaran
                            </button>
                        </form>

                        @if(!app()->environment('production'))
                            <form action="{{ route('payment.simulate', $payment) }}" method="POST" class="mb-2">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    <i class="bi bi-lightning-charge me-2"></i>[SIMULASI] Bayar Langsung
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('payment.cancel', $payment) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link btn-sm text-danger text-decoration-none w-100" onclick="return confirm('Yakin membatalkan pembayaran?')">
                                <i class="bi bi-x-circle me-2"></i>Batalkan Pembayaran
                            </button>
                        </form>

                    @elseif($payment->status === 'paid')
                        <div class="alert alert-success border-0 mb-4">
                            <h6 class="fw-bold mb-2"><i class="bi bi-check-circle-fill me-2"></i>Pembayaran Berhasil!</h6>
                            <p class="small mb-2">Booking kamu telah dikonfirmasi.</p>
                            <div class="small text-muted">
                                <p class="mb-1">Dibayar pada: {{ $payment->paid_at->format('d M Y, H:i') }}</p>
                                @if($payment->payment_proof)
                                    <p class="mb-0">Bukti: <a href="{{ Storage::url($payment->payment_proof) }}" target="_blank" class="text-success">Lihat Bukti</a></p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('dashboard') }}" class="btn btn-dark w-100">
                            <i class="bi bi-house me-2"></i>Kembali ke Dashboard
                        </a>
                    @else
                        <div class="alert alert-secondary border-0 mb-4">
                            <p class="mb-0 small">Pembayaran tidak dapat diproses. Silakan buat booking baru.</p>
                        </div>
                        <a href="{{ route('booking.index') }}" class="btn btn-dark w-100">
                            <i class="bi bi-arrow-left me-2"></i>Booking Baru
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection