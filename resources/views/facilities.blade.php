@extends('layouts.app')

@section('title', 'Fasilitas & Booking - Distorsi Atlantiz')

@push('styles')
<style>
/* ================= PAGE HEADER ================= */
.page-header {
    padding: 150px 0 80px;
    text-align: center;
    color: white;
    position: relative;
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.8)), url("{{ asset('img/background.png') }}") center/cover no-repeat;
}

.page-subtitle {
    font-size: 14px;
    letter-spacing: 3px;
    color: #ff4d4d;
    margin-bottom: 15px;
    font-weight: 600;
}

.page-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 20px;
    text-shadow: 0 4px 15px rgba(0,0,0,0.5);
}

/* ================= STUDIO SECTION ================= */
.studio-section {
    padding: 60px 0;
    background: #0a0a0a;
}

.studio-section .row {
    display: flex !important;
    flex-wrap: wrap !important;
}

.studio-section .col-lg-4 {
    flex: 0 0 33.333333% !important;
    max-width: 33.333333% !important;
    padding: 0 12px;
    margin-bottom: 24px;
}

@media (max-width: 991px) {
    .studio-section .col-lg-4 {
        flex: 0 0 50% !important;
        max-width: 50% !important;
    }
}

@media (max-width: 767px) {
    .studio-section .col-lg-4 {
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
}

.studio-card {
    background: linear-gradient(145deg, #111111, #1a1a1a);
    border: 1px solid #222;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s ease;
    height: 100%;
    position: relative;
    display: flex;
    flex-direction: column;
}

.studio-card:hover {
    transform: translateY(-10px);
    border-color: rgba(255, 77, 77, 0.3);
    box-shadow: 0 20px 60px rgba(255, 77, 77, 0.15);
}

.studio-card.featured {
    border: 2px solid #ff4d4d;
    box-shadow: 0 0 30px rgba(255, 77, 77, 0.2);
}

.studio-image {
    position: relative;
    overflow: hidden;
    height: 220px;
    background: #1a1a1a;
    flex-shrink: 0;
}

.studio-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
    display: block;
}

.studio-card:hover .studio-image img {
    transform: scale(1.1);
}

.studio-badge {
    position: absolute;
    top: 15px;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    z-index: 2;
}

.studio-badge.populer {
    left: 15px;
    background: linear-gradient(135deg, #ff4d4d, #cc0000);
    color: white;
    box-shadow: 0 4px 15px rgba(255, 77, 77, 0.4);
}

.studio-badge.best {
    right: 15px;
    background: linear-gradient(135deg, #ffd700, #ff8c00);
    color: #000;
    box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
}

.studio-content {
    padding: 25px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.studio-content h4 {
    color: white;
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 12px;
}

.studio-content > p {
    color: #aaa;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 20px;
}

.studio-features {
    list-style: none;
    padding: 0;
    margin-bottom: 25px;
}

.studio-features li {
    color: #ccc;
    font-size: 13px;
    padding: 6px 0;
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.studio-features li:last-child {
    border-bottom: none;
}

.studio-features li i {
    color: #ff4d4d;
    font-size: 16px;
}

.studio-price {
    margin-bottom: 20px;
    padding: 15px 0;
    border-top: 1px solid rgba(255,255,255,0.1);
    border-bottom: 1px solid rgba(255,255,255,0.1);
    margin-top: auto;
}

.studio-price .price {
    color: #ff4d4d;
    font-size: 1.8rem;
    font-weight: 700;
}

.studio-price .per {
    color: #888;
    font-size: 14px;
    margin-left: 5px;
}

.btn-book {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #ff4d4d, #cc0000);
    border: none;
    border-radius: 12px;
    color: white;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    font-size: 13px;
    transition: all 0.3s ease;
    cursor: pointer;
    margin-top: auto;
}

.btn-book:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(255, 77, 77, 0.4);
    color: white;
}

/* ================= BOOKING FORM ================= */
.booking-section {
    padding: 80px 0;
    background: linear-gradient(180deg, #0a0a0a 0%, #111 100%);
    position: relative;
}

.booking-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, #ff4d4d, transparent);
}

.booking-form-wrapper {
    background: linear-gradient(145deg, #111, #1a1a1a);
    border: 1px solid #222;
    border-radius: 20px;
    padding: 40px;
    position: relative;
}

.booking-form-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 3px;
    background: linear-gradient(90deg, transparent, #ff4d4d, transparent);
    border-radius: 0 0 3px 3px;
}

.section-subtitle {
    color: #ff4d4d;
    font-size: 13px;
    letter-spacing: 3px;
    text-transform: uppercase;
    font-weight: 600;
    margin-bottom: 10px;
}

.section-title {
    color: white;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 30px;
}

.form-label {
    color: #aaa;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 8px;
}

.booking-form .form-control,
.booking-form .form-select {
    background: #0a0a0a;
    border: 1px solid #333;
    color: white;
    padding: 14px 18px;
    border-radius: 12px;
    font-size: 14px;
    transition: all 0.3s;
}

.booking-form .form-control:focus,
.booking-form .form-select:focus {
    background: #0a0a0a;
    border-color: #ff4d4d;
    box-shadow: 0 0 0 4px rgba(255, 77, 77, 0.1);
    color: white;
}

.booking-form .form-control::placeholder {
    color: #555;
}

.booking-form .form-select option {
    background: #1a1a1a;
    color: white;
}

.price-preview {
    background: linear-gradient(135deg, rgba(255, 77, 77, 0.1), rgba(204, 0, 0, 0.05));
    border: 1px solid rgba(255, 77, 77, 0.2);
    border-radius: 12px;
    padding: 20px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.price-preview .label {
    color: #aaa;
    font-size: 14px;
}

.price-preview .value {
    color: #ff4d4d;
    font-size: 1.5rem;
    font-weight: 700;
}

.btn-submit {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #ff4d4d, #cc0000);
    border: none;
    border-radius: 12px;
    color: white;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-size: 14px;
    transition: all 0.3s;
    margin-top: 10px;
}

.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(255, 77, 77, 0.4);
    color: white;
}

.btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.alert-custom {
    background: rgba(255, 77, 77, 0.1);
    border: 1px solid rgba(255, 77, 77, 0.3);
    color: #ff4d4d;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 20px;
}

.alert-custom.success {
    background: rgba(76, 175, 80, 0.1);
    border-color: rgba(76, 175, 80, 0.3);
    color: #4CAF50;
}

/* ================= REVEAL ANIMATION ================= */
.reveal {
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.reveal.active {
    opacity: 1;
    transform: translateY(0);
}

/* ================= RESPONSIVE ================= */
@media (max-width: 991px) {
    .page-title {
        font-size: 2rem;
    }

    .studio-image {
        height: 180px;
    }

    .booking-form-wrapper {
        padding: 25px;
    }
}
</style>
@endpush

@section('content')
{{-- PAGE HEADER --}}
<section class="page-header">
    <div class="container text-center">
        <h6 class="page-subtitle reveal">FASILITAS KAMI</h6>
        <h1 class="page-title reveal">Pilih Ruang Studio<br>Sesuai Kebutuhan Anda</h1>
    </div>
</section>

{{-- STUDIO CARDS --}}
<section class="studio-section">
    <div class="container">
        <div class="row g-4">
            {{-- Studio Regular --}}
            <div class="col-lg-4 col-md-6 reveal">
                <div class="studio-card">
                    <div class="studio-image">
                        <img src="{{ asset('img/studio-regular.png') }}" alt="Studio Regular">
                        <div class="studio-badge populer">POPULER</div>
                    </div>
                    <div class="studio-content">
                        <h4>Studio Regular</h4>
                        <p>Ruang latihan standar dengan peralatan lengkap untuk band 4-5 orang.</p>
                        <ul class="studio-features">
                            <li><i class="bi bi-check-circle-fill"></i> Drum Kit Standar</li>
                            <li><i class="bi bi-check-circle-fill"></i> Ampli Gitar & Bass</li>
                            <li><i class="bi bi-check-circle-fill"></i> Sound System 500W</li>
                            <li><i class="bi bi-check-circle-fill"></i> AC & WiFi</li>
                            <li><i class="bi bi-check-circle-fill"></i> Ruang 20m²</li>
                        </ul>
                        <div class="studio-price">
                            <span class="price">Rp 75.000</span>
                            <span class="per">/jam</span>
                        </div>
                        <button class="btn btn-book" onclick="openBooking(1)">BOOKING SEKARANG</button>
                    </div>
                </div>
            </div>

            {{-- Studio Premium --}}
            <div class="col-lg-4 col-md-6 reveal">
                <div class="studio-card featured">
                    <div class="studio-image">
                        <img src="{{ asset('img/studio-premium.png') }}" alt="Studio Premium">
                        <div class="studio-badge best">BEST VALUE</div>
                    </div>
                    <div class="studio-content">
                        <h4>Studio Premium</h4>
                        <p>Ruang dengan peralatan premium dan akustik profesional untuk hasil maksimal.</p>
                        <ul class="studio-features">
                            <li><i class="bi bi-check-circle-fill"></i> Drum Kit Premium</li>
                            <li><i class="bi bi-check-circle-fill"></i> Ampli Tube High-End</li>
                            <li><i class="bi bi-check-circle-fill"></i> Sound System 1000W</li>
                            <li><i class="bi bi-check-circle-fill"></i> Recording Ready</li>
                            <li><i class="bi bi-check-circle-fill"></i> Ruang 30m²</li>
                        </ul>
                        <div class="studio-price">
                            <span class="price">Rp 150.000</span>
                            <span class="per">/jam</span>
                        </div>
                        <button class="btn btn-book" onclick="openBooking(2)">BOOKING SEKARANG</button>
                    </div>
                </div>
            </div>

            {{-- Recording Studio --}}
            <div class="col-lg-4 col-md-6 reveal">
                <div class="studio-card">
                    <div class="studio-image">
                        <img src="{{ asset('img/studio-recording.png') }}" alt="Recording Studio" onerror="this.src='https://images.unsplash.com/photo-1590602847861-f357a9332bbc?w=400'">
                    </div>
                    <div class="studio-content">
                        <h4>Recording Studio</h4>
                        <p>Ruang rekaman profesional dengan engineer berpengalaman.</p>
                        <ul class="studio-features">
                            <li><i class="bi bi-check-circle-fill"></i> Multi-track Recording</li>
                            <li><i class="bi bi-check-circle-fill"></i> Pro Tools & Logic Pro</li>
                            <li><i class="bi bi-check-circle-fill"></i> Sound Engineer</li>
                            <li><i class="bi bi-check-circle-fill"></i> Mixing & Mastering</li>
                            <li><i class="bi bi-check-circle-fill"></i> Ruang 40m²</li>
                        </ul>
                        <div class="studio-price">
                            <span class="price">Rp 500.000</span>
                            <span class="per">/sesi (4 jam)</span>
                        </div>
                        <button class="btn btn-book" onclick="openBooking(3)">BOOKING SEKARANG</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BOOKING FORM SECTION --}}
<section class="booking-section" id="booking">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 reveal">
                <div class="booking-form-wrapper">
                    <h6 class="section-subtitle text-center">FORM BOOKING</h6>
                    <h2 class="section-title text-center">Pesan Studio Sekarang</h2>

                    {{-- Alert Container --}}
                    <div id="bookingAlert"></div>

                    <form class="booking-form" id="bookingForm">
                        @csrf

                        @guest
                        <div class="alert-custom mb-4">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            Silakan <a href="{{ route('login') }}" style="color: #ff4d4d; text-decoration: underline;">login</a> terlebih dahulu untuk melakukan booking.
                        </div>
                        @endguest

                        @auth
                        <input type="hidden" id="userId" value="{{ auth()->id() }}">
                        @endauth

                        <div class="row g-3">
                            {{-- NAMA LENGKAP --}}
                             <div class="col-md-6">
        <label class="form-label">Nama Lengkap</label>  {{-- WAJIB ADA --}}
        <input type="text" class="form-control" id="nama" 
               value="{{ auth()->user()->name ?? '' }}" 
               required>  {{-- HAPUS readonly kalau mau bisa edit --}}
    </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="telepon" pattern="[0-9]*" inputmode="numeric" placeholder="Contoh: 081234567890" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="{{ auth()->user()->email ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pilih Studio</label>
                                <select class="form-select" id="studioType" required>
                                    <option value="" selected disabled>Pilih Studio</option>
                                    <option value="1" data-harga="75000">Studio Regular - Rp 75.000/jam</option>
                                    <option value="2" data-harga="150000">Studio Premium - Rp 150.000/jam</option>
                                    <option value="3" data-harga="500000">Recording Studio - Rp 500.000/sesi</option>
                                </select>
                            </div>
                            <div class="col-md-6">
    <label class="form-label">Tanggal Booking</label>
    <div class="d-flex gap-2">
        {{-- Tanggal --}}
        <select class="form-select" id="tanggalHari" required style="flex: 1;">
            <option value="" selected disabled>Tanggal</option>
            @for($i = 1; $i <= 31; $i++)
                <option value="{{ sprintf('%02d', $i) }}">{{ $i }}</option>
            @endfor
        </select>
        
        {{-- Bulan --}}
        <select class="form-select" id="bulan" required style="flex: 2;">
            <option value="" selected disabled>Bulan</option>
            @for($i = 1; $i <= 12; $i++)
                <option value="{{ sprintf('%02d', $i) }}" {{ $i == date('n') ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create(2026, $i, 1)->translatedFormat('F') }}
                </option>
            @endfor
        </select>
        
        {{-- Tahun (Tetap 2026, readonly) --}}
        <input type="text" class="form-control" value="2026" readonly style="flex: 1; text-align: center; cursor: default; opacity: 0.7;">
    </div>
</div>

                            {{-- Input hidden untuk kirim ke server --}}
                            <input type="hidden" id="tanggal" name="tanggal" value="">

                            <div class="col-md-6">
    <label class="form-label">Jam Mulai</label>
    <select class="form-select" id="jamMulai" required>
        <option value="" selected disabled>Pilih Jam</option>
        @for($jam = 8; $jam <= 22; $jam++)
            <option value="{{ sprintf('%02d:00', $jam) }}">{{ sprintf('%02d:00', $jam) }} WIB</option>
        @endfor
    </select>
</div>
                            <div class="col-md-6">
                                <label class="form-label">Durasi (jam)</label>
                                <select class="form-select" id="durasi" required>
                                    @for($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ $i == 2 ? 'selected' : '' }}>{{ $i }} Jam</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jumlah Orang</label>
                                <input type="number" class="form-control" id="jumlahOrang" min="1" max="10" value="4" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Catatan Tambahan</label>
                                <textarea class="form-control" id="catatan" rows="3" placeholder="Permintaan khusus, kebutuhan peralatan tambahan, dll."></textarea>
                            </div>
                            <div class="col-12">
                                <div class="price-preview" id="pricePreview">
                                    <span class="label">Total Harga:</span>
                                    <span class="value" id="totalPrice">Rp 0</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-submit w-100" id="btnSubmit" {{ auth()->guest() ? 'disabled' : '' }}>
                                    {{ auth()->check() ? 'KONFIRMASI BOOKING' : 'LOGIN UNTUK BOOKING' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
"use strict";

/* ================= REVEAL ANIMATION ================= */
window.addEventListener("load", () => {
  const reveals = document.querySelectorAll(".reveal");

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
      if (entry.isIntersecting) {
        setTimeout(() => {
          entry.target.classList.add("active");
        }, 150 + index * 100);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  reveals.forEach(el => observer.observe(el));
});

/* ================= TANGGAL COMBINER ================= */
const bulanSelect = document.getElementById("bulan");
const tanggalHariSelect = document.getElementById("tanggalHari");
const tanggalHidden = document.getElementById("tanggal");

function updateTanggal() {
    const bulan = bulanSelect ? bulanSelect.value : '';
    const hari = tanggalHariSelect ? tanggalHariSelect.value : '';
    
    if (bulan && hari) {
        const date = new Date(2026, parseInt(bulan) - 1, parseInt(hari));
        if (date.getMonth() + 1 === parseInt(bulan) && parseInt(hari) >= 1) {
            tanggalHidden.value = `2026-${bulan}-${hari}`;
            tanggalHariSelect.classList.remove('is-invalid');
        } else {
            tanggalHidden.value = '';
            tanggalHariSelect.classList.add('is-invalid');
            console.warn('Tanggal tidak valid untuk bulan tersebut');
        }
    } else {
        tanggalHidden.value = '';
    }
}

if (bulanSelect) bulanSelect.addEventListener("change", updateTanggal);
if (tanggalHariSelect) tanggalHariSelect.addEventListener("change", updateTanggal);

/* ================= NOMOR TELEPON HANYA ANGKA ================= */
const teleponInput = document.getElementById("telepon");

if (teleponInput) {
    // Hanya izinkan angka saat mengetik
    teleponInput.addEventListener("input", function(e) {
        // Hapus semua karakter non-angka
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Cegah paste karakter non-angka
    teleponInput.addEventListener("paste", function(e) {
        e.preventDefault();
        const pasted = (e.clipboardData || window.clipboardData).getData("text");
        const cleaned = pasted.replace(/[^0-9]/g, '');
        this.value = cleaned;
    });

    // Cegah tombol selain angka & navigasi
    teleponInput.addEventListener("keydown", function(e) {
        // Izinkan: backspace, delete, tab, escape, enter, arrow keys
        const allowedKeys = ['Backspace', 'Delete', 'Tab', 'Escape', 'Enter', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'];
        if (allowedKeys.includes(e.key)) return;

        // Izinkan: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
        if ((e.ctrlKey || e.metaKey) && ['a','c','v','x'].includes(e.key.toLowerCase())) return;

        // Cegal jika bukan angka
        if (!/^[0-9]$/.test(e.key)) {
            e.preventDefault();
        }
    });
}

/* ================= PRICE CALCULATION ================= */
const studioSelect = document.getElementById("studioType");
const durasi = document.getElementById("durasi");
const totalPrice = document.getElementById("totalPrice");

function updatePrice() {
  const selectedOption = studioSelect ? studioSelect.options[studioSelect.selectedIndex] : null;
  const harga = selectedOption ? parseInt(selectedOption.getAttribute('data-harga')) : 0;
  const jam = durasi ? parseInt(durasi.value) : 2;

  if (harga && totalPrice) {
    const total = harga * jam;
    totalPrice.textContent = "Rp " + total.toLocaleString("id-ID");
  }
}

if (studioSelect) studioSelect.addEventListener("change", updatePrice);
if (durasi) durasi.addEventListener("change", updatePrice);

/* ================= OPEN BOOKING ================= */
function openBooking(studioId) {
  const studioSelect = document.getElementById("studioType");
  const bookingSection = document.getElementById("booking");

  if (studioSelect) {
    studioSelect.value = studioId;
    updatePrice();
  }

  if (bookingSection) {
    bookingSection.scrollIntoView({ behavior: "smooth" });
  }
}

/* ================= BOOKING FORM SUBMIT ================= */
const bookingForm = document.getElementById("bookingForm");
const btnSubmit = document.getElementById("btnSubmit");
const alertContainer = document.getElementById("bookingAlert");

function showAlert(message, type = 'error') {
  if (!alertContainer) return;

  const alertClass = type === 'success' ? 'alert-custom success' : 'alert-custom';
  const icon = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle';

  alertContainer.innerHTML = `
    <div class="${alertClass}">
      <i class="bi ${icon} me-2"></i>${message}
    </div>
  `;

  if (type === 'success') {
    setTimeout(() => {
      alertContainer.innerHTML = '';
    }, 5000);
  }
}

if (bookingForm) {
  bookingForm.addEventListener("submit", async function(e) {
    e.preventDefault();

    // Cek login
    const userId = document.getElementById("userId");
    if (!userId || !userId.value) {
      showAlert('Silakan login terlebih dahulu untuk melakukan booking.');
      return;
    }

    if (!btnSubmit) return;

    const originalText = btnSubmit.textContent;
    btnSubmit.textContent = "MEMPROSES...";
    btnSubmit.disabled = true;

    // Hitung jam selesai
    const jamMulai = document.getElementById("jamMulai").value;
    const durasiJam = parseInt(document.getElementById("durasi").value);
    const [hours, minutes] = jamMulai.split(':').map(Number);
    const jamSelesaiDate = new Date();
    jamSelesaiDate.setHours(hours + durasiJam, minutes);
    const jamSelesai = jamSelesaiDate.toTimeString().slice(0, 5);

    // Hitung total harga
    const selectedOption = studioSelect.options[studioSelect.selectedIndex];
    const harga = parseInt(selectedOption.getAttribute('data-harga'));
    const totalHarga = harga * durasiJam;

    const formData = {
      user_id: parseInt(userId.value),
      studio_id: parseInt(studioSelect.value),
      tanggal: document.getElementById("tanggal").value,
      jam_mulai: jamMulai,
      durasi: durasiJam,
      jam_selesai: jamSelesai,
      jumlah_orang: parseInt(document.getElementById("jumlahOrang").value),
      total_harga: totalHarga,
      catatan: document.getElementById("catatan").value || null,
      _token: document.querySelector('input[name="_token"]').value
    };

    try {
      const response = await fetch('{{ route("booking.store") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': formData._token,
          'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
      });

      const result = await response.json();

      if (response.ok && result.success) {
        showAlert('Booking berhasil! Silakan cek email untuk konfirmasi.', 'success');

        btnSubmit.textContent = "BOOKING BERHASIL ✓";
        btnSubmit.style.background = "#4CAF50";

        setTimeout(() => {
          btnSubmit.textContent = originalText;
          btnSubmit.style.background = "";
          btnSubmit.disabled = false;
          bookingForm.reset();
          updatePrice();
        }, 3000);
      } else {
        throw new Error(result.message || 'Terjadi kesalahan');
      }
    } catch (error) {
      showAlert(error.message || 'Gagal melakukan booking. Silakan coba lagi.');
      btnSubmit.textContent = originalText;
      btnSubmit.disabled = false;
    }
  });
}

// Init
updatePrice();
</script>
@endpush