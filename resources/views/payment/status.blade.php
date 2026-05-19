@extends('layouts.app')

@section('title', 'Status Pembayaran')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-receipt me-2"></i>Status Pembayaran
                    </h5>
                </div>
                <div class="card-body p-4">
                    
                    {{-- Alert Status --}}
                    @php
                        $statusConfig = [
                            'pending' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Menunggu Pembayaran'],
                            'paid' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Pembayaran Berhasil'],
                            'failed' => ['class' => 'danger', 'icon' => 'x-circle', 'text' => 'Pembayaran Gagal'],
                            'expired' => ['class' => 'secondary', 'icon' => 'clock-history', 'text' => 'Pembayaran Kedaluwarsa'],
                        ];
                        $config = $statusConfig[$payment->status] ?? $statusConfig['pending'];
                    @endphp

                    <div class="alert alert-{{ $config['class'] }} d-flex align-items-center mb-4">
                        <i class="bi bi-{{ $config['icon'] }} fs-4 me-3"></i>
                        <div>
                            <strong>{{ $config['text'] }}</strong>
                            <div class="small">Order ID: <code>{{ $payment->order_id }}</code></div>
                        </div>
                    </div>

                    {{-- Detail Booking --}}
                    <div class="alert alert-light border mb-4">
                        <h6 class="fw-bold mb-3">Detail Booking</h6>
                        <div class="row g-2 small">
                            <div class="col-6">Studio:</div>
                            <div class="col-6 text-end fw-semibold">{{ $payment->booking->studio->nama }}</div>
                            <div class="col-6">Tanggal:</div>
                            <div class="col-6 text-end">{{ $payment->booking->tanggal->format('d M Y') }}</div>
                            <div class="col-6">Waktu:</div>
                            <div class="col-6 text-end">{{ $payment->booking->jam_mulai }} - {{ $payment->booking->jam_selesai }}</div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total:</span>
                            <span class="fs-4 fw-bold text-danger">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- ============================================================ --}}
                    {{-- QRIS - API ONLINE                                            --}}
                    {{-- ============================================================ --}}
                    @if($payment->method === 'qris' && $payment->status === 'pending')
                        <div class="text-center mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-qr-code-scan me-2"></i>Scan QRIS untuk Membayar
                            </h6>
                            
                            {{-- QR Code dari API Online (qrserver.com) --}}
                            <div class="d-inline-block p-3 bg-white border rounded-3 shadow-sm mb-3">
                                <img 
                                    src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode('ID' . $payment->order_id . '.X' . $payment->amount . '.QRIS') }}" 
                                    alt="QRIS Code" 
                                    class="img-fluid"
                                    style="width: 250px; height: 250px;"
                                    id="qris-image"
                                >
                            </div>
                            
                            <p class="text-muted small mb-3">
                                Scan kode QR di atas menggunakan aplikasi e-wallet atau mobile banking Anda
                            </p>
                            
                            {{-- Badge E-Wallet --}}
                            <div class="d-flex justify-content-center flex-wrap gap-1 mb-3">
                                <span class="badge bg-primary">DANA</span>
                                <span class="badge bg-success">GoPay</span>
                                <span class="badge bg-warning text-dark">OVO</span>
                                <span class="badge bg-danger">ShopeePay</span>
                                <span class="badge bg-info text-dark">LinkAja</span>
                                <span class="badge bg-secondary">SeaBank</span>
                            </div>
                            
                            {{-- Info Order & Countdown --}}
                            <div class="mt-3 p-3 bg-light rounded text-start small border">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Order ID:</span>
                                    <span class="font-monospace fw-semibold text-dark">{{ $payment->order_id }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Total Pembayaran:</span>
                                    <span class="fw-bold text-danger">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Berlaku sampai:</span>
                                    <span class="fw-semibold text-danger" id="expiry-time">
                                        {{ $payment->expired_at->format('d M Y H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi QRIS --}}
                        <div class="d-grid gap-2 mb-3">
                            <button class="btn btn-outline-primary" onclick="downloadQR()">
                                <i class="bi bi-download me-2"></i>Simpan QR Code
                            </button>
                            <button class="btn btn-outline-secondary" onclick="shareQR()">
                                <i class="bi bi-share me-2"></i>Bagikan
                            </button>
                        </div>

                    {{-- ============================================================ --}}
                    {{-- TRANSFER BANK                                                --}}
                    {{-- ============================================================ --}}
                    @elseif($payment->method === 'transfer_bank' && $payment->status === 'pending')
                        <div class="alert alert-light border mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-bank me-2"></i>Informasi Rekening
                            </h6>
                            
                            <div class="d-flex align-items-center p-3 bg-white border rounded mb-3">
                                <div class="flex-grow-1">
                                    <div class="small text-muted">Bank BCA</div>
                                    <div class="fs-5 fw-bold font-monospace" id="va-number">1234-5678-9012</div>
                                    <div class="small text-muted">a.n. PT Distorsi Atlantis</div>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('123456789012')">
                                    <i class="bi bi-copy"></i>
                                </button>
                            </div>
                            
                            <div class="alert alert-warning small py-2">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Transfer sesuai nominal hingga 3 digit terakhir untuk verifikasi otomatis
                            </div>
                        </div>

                    {{-- ============================================================ --}}
                    {{-- E-WALLET                                                     --}}
                    {{-- ============================================================ --}}
                    @elseif($payment->method === 'e_wallet' && $payment->status === 'pending')
                        <div class="alert alert-light border mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-phone me-2"></i>Pembayaran E-Wallet
                            </h6>
                            <p class="small text-muted mb-3">
                                Silakan cek notifikasi di aplikasi e-wallet Anda atau klik tombol di bawah untuk melanjutkan pembayaran.
                            </p>
                            <button class="btn btn-success w-100 py-2">
                                <i class="bi bi-phone me-2"></i>Buka Aplikasi E-Wallet
                            </button>
                        </div>

                    {{-- ============================================================ --}}
                    {{-- VIRTUAL ACCOUNT                                              --}}
                    {{-- ============================================================ --}}
                    @elseif($payment->method === 'virtual_account' && $payment->status === 'pending')
                        <div class="alert alert-light border mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-upc-scan me-2"></i>Virtual Account
                            </h6>
                            <div class="d-flex align-items-center p-3 bg-white border rounded mb-3">
                                <div class="flex-grow-1">
                                    <div class="small text-muted">Virtual Account BCA</div>
                                    <div class="fs-5 fw-bold font-monospace" id="va-number">{{ $payment->order_id }}</div>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('{{ $payment->order_id }}')">
                                    <i class="bi bi-copy"></i>
                                </button>
                            </div>
                            <div class="small text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                VA aktif 24 jam. Pembayaran otomatis terverifikasi.
                            </div>
                        </div>
                    @endif

                    {{-- ============================================================ --}}
                    {{-- UPLOAD BUKTI PEMBAYARAN (Semua Method)                      --}}
                    {{-- ============================================================ --}}
                    @if($payment->status === 'pending' && !$payment->payment_proof)
                        <hr class="my-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-upload me-2"></i>Upload Bukti Pembayaran
                        </h6>
                        <form action="{{ route('payment.proof', $payment) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input 
                                    type="file" 
                                    name="payment_proof" 
                                    class="form-control" 
                                    accept="image/jpeg,image/png,image/jpg" 
                                    required
                                >
                                <div class="form-text">Format: JPG, PNG (Maksimal 2MB)</div>
                            </div>
                            <div class="mb-3">
                                <textarea 
                                    name="notes" 
                                    class="form-control" 
                                    rows="2" 
                                    placeholder="Catatan tambahan (opsional)"
                                ></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="bi bi-upload me-2"></i>Upload Bukti
                            </button>
                        </form>
                    @elseif($payment->payment_proof)
                        <div class="alert alert-info d-flex align-items-center">
                            <i class="bi bi-check-circle fs-5 me-3"></i>
                            <div>
                                <strong>Bukti sudah diupload!</strong>
                                <div class="small">Menunggu verifikasi admin. Silakan cek status secara berkala.</div>
                            </div>
                        </div>
                    @endif

                    {{-- ============================================================ --}}
                    {{-- TOMBOL AKSI                                                  --}}
                    {{-- ============================================================ --}}
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary flex-fill py-2">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                        
                        @if($payment->status === 'pending')
                            <form action="{{ route('payment.cancel', $payment) }}" method="POST" class="flex-fill">
                                @csrf
                                <button 
                                    type="submit" 
                                    class="btn btn-outline-danger w-100 py-2" 
                                    onclick="return confirm('Yakin ingin membatalkan pembayaran ini?')"
                                >
                                    <i class="bi bi-x-circle me-2"></i>Batalkan
                                </button>
                            </form>
                        @endif

                        {{-- Simulasi Bayar (hanya Local/Development) --}}
                        @if(app()->environment('local') && $payment->status === 'pending')
                            <form action="{{ route('payment.simulate', $payment) }}" method="POST" class="flex-fill">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 py-2">
                                    <i class="bi bi-check-lg me-2"></i>Simulasi Bayar
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
/**
 * Copy text to clipboard
 */
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Toast notification (jika pakai Bootstrap 5)
        if (typeof bootstrap !== 'undefined') {
            const toast = document.createElement('div');
            toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3';
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-2"></i>Nomor berhasil disalin!
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            document.body.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            setTimeout(() => toast.remove(), 3000);
        } else {
            alert('Nomor berhasil disalin!');
        }
    }).catch(err => {
        console.error('Gagal menyalin:', err);
        // Fallback
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('Nomor berhasil disalin!');
    });
}

/**
 * Download QR Code image
 */
function downloadQR() {
    const img = document.getElementById('qris-image');
    if (!img) {
        alert('QR Code tidak ditemukan!');
        return;
    }
    
    fetch(img.src)
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'qris-{{ $payment->order_id }}.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
        })
        .catch(err => {
            console.error('Gagal download:', err);
            // Fallback: buka di tab baru
            window.open(img.src, '_blank');
        });
}

/**
 * Share QR Code (Web Share API)
 */
function shareQR() {
    const img = document.getElementById('qris-image');
    if (!img) return;
    
    if (navigator.share) {
        fetch(img.src)
            .then(response => response.blob())
            .then(blob => {
                const file = new File([blob], 'qris-{{ $payment->order_id }}.png', { type: 'image/png' });
                navigator.share({
                    title: 'Pembayaran QRIS - Distorsi Atlantis',
                    text: 'Silakan scan QRIS untuk pembayaran Order {{ $payment->order_id }} sebesar Rp {{ number_format($payment->amount, 0, ',', '.') }}',
                    files: [file]
                }).catch(err => {
                    if (err.name !== 'AbortError') {
                        console.error('Share failed:', err);
                    }
                });
            });
    } else {
        // Fallback: copy link
        copyToClipboard(img.src);
    }
}

/**
 * Countdown timer untuk expiry
 */
document.addEventListener('DOMContentLoaded', function() {
    const expiryElement = document.getElementById('expiry-time');
    if (!expiryElement) return;
    
    const expiryTime = new Date('{{ $payment->expired_at->toIso8601String() }}').getTime();
    
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = expiryTime - now;
        
        if (distance < 0) {
            expiryElement.innerHTML = '<span class="badge bg-danger">KEDALUWARSA</span>';
            expiryElement.classList.add('text-danger');
            return;
        }
        
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        expiryElement.innerHTML = `${hours}j ${minutes}m ${seconds}d`;
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000);
});
</script>
@endpush
@endsection