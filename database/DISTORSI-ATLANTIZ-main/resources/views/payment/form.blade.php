@extends('layouts.app')

@section('title', 'Pembayaran Booking')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-credit-card me-2"></i>Pembayaran Booking</h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-light border mb-4">
                        <h6 class="fw-bold mb-3">Detail Booking</h6>
                        <div class="row g-2 small">
                            <div class="col-6">Studio:</div>
                            <div class="col-6 text-end fw-semibold">{{ $studio->nama }}</div>
                            <div class="col-6">Tanggal:</div>
                            <div class="col-6 text-end">{{ $booking->tanggal->format('d M Y') }}</div>
                            <div class="col-6">Waktu:</div>
                            <div class="col-6 text-end">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</div>
                            <div class="col-6">Durasi:</div>
                            <div class="col-6 text-end">{{ $booking->durasi }} jam</div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total:</span>
                            <span class="fs-4 fw-bold text-danger">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('payment.create', $booking) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Metode Pembayaran</label>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-check card p-3 border">
                                        <input class="form-check-input" type="radio" name="method" id="transfer" value="transfer_bank" checked>
                                        <label class="form-check-label w-100 ms-2" for="transfer">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-bank fs-3 text-primary me-3"></i>
                                                <div>
                                                    <div class="fw-semibold">Transfer Bank</div>
                                                    <small class="text-muted">BCA, Mandiri, BNI, BRI</small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check card p-3 border">
                                        <input class="form-check-input" type="radio" name="method" id="ewallet" value="e_wallet">
                                        <label class="form-check-label w-100 ms-2" for="ewallet">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-phone fs-3 text-success me-3"></i>
                                                <div>
                                                    <div class="fw-semibold">E-Wallet</div>
                                                    <small class="text-muted">GoPay, OVO, DANA</small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check card p-3 border">
                                        <input class="form-check-input" type="radio" name="method" id="va" value="virtual_account">
                                        <label class="form-check-label w-100 ms-2" for="va">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-upc-scan fs-3 text-warning me-3"></i>
                                                <div>
                                                    <div class="fw-semibold">Virtual Account</div>
                                                    <small class="text-muted">Pembayaran otomatis 24 jam</small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">  <!-- ✅ QRIS di dalam form -->
                                    <div class="form-check card p-3 border">
                                        <input class="form-check-input" type="radio" name="method" id="qris" value="qris">
                                        <label class="form-check-label w-100 ms-2" for="qris">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-qr-code-scan fs-3 text-info me-3"></i>
                                                <div>
                                                    <div class="fw-semibold">QRIS</div>
                                                    <small class="text-muted">Scan QR dari semua e-wallet & mobile banking</small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 py-3 fw-semibold">
                            <i class="bi bi-lock-fill me-2"></i>Bayar Sekarang
                        </button>
                    </form>  <!-- ✅ Form ditutup setelah semua method -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection