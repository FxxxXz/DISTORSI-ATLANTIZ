@extends('layouts.app')

@section('title', 'Kontak - Distorsi Atlantiz')

@push('styles')
<link href="{{ asset('css/contact.css') }}" rel="stylesheet">
@endpush

@section('content')

{{-- PAGE HEADER --}}
<section class="page-header">
    <div class="container">
        <div class="text-center header-content">
            <h6 class="page-subtitle reveal">HUBUNGI KAMI</h6>

            <h1 class="page-title reveal">
                Mari Berkolaborasi
            </h1>

            <p class="page-desc reveal">
                Punya pertanyaan atau ingin berkunjung?
                Hubungi kami melalui form atau datang langsung ke studio Distorsi Atlantiz.
            </p>
        </div>
    </div>
</section>

{{-- CONTACT SECTION --}}
<section class="contact-section">
    <div class="container">

        <div class="row align-items-start g-5">

            {{-- LEFT --}}
            <div class="col-lg-5">
                <div class="contact-info-wrapper reveal">

                    <h3 class="contact-heading">
                        Informasi Kontak
                    </h3>

                    <p class="contact-subtext">
                        Kami siap membantu kebutuhan studio, recording,
                        rehearsal, hingga kolaborasi event musik Anda.
                    </p>

                    <div class="contact-items">

                        {{-- ITEM --}}
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>

                            <div class="contact-detail">
                                <h5>Alamat Studio</h5>
                                <p>
                                    Jl. Musik No.123 <br>
                                    Banda Aceh, Indonesia
                                </p>
                            </div>
                        </div>

                        {{-- ITEM --}}
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-telephone-fill"></i>
                            </div>

                            <div class="contact-detail">
                                <h5>Telepon</h5>
                                <p>
                                    +62 812-3456-7890
                                </p>
                            </div>
                        </div>

                        {{-- ITEM --}}
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-envelope-fill"></i>
                            </div>

                            <div class="contact-detail">
                                <h5>Email</h5>
                                <p>
                                    booking@distorsiatlantiz.com
                                </p>
                            </div>
                        </div>

                        {{-- ITEM --}}
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-clock-fill"></i>
                            </div>

                            <div class="contact-detail">
                                <h5>Jam Operasional</h5>
                                <p>
                                    Senin - Minggu <br>
                                    24 Jam
                                </p>
                            </div>
                        </div>

                    </div>

                    {{-- SOCIAL --}}
                    <div class="social-section">

                        <h6>FOLLOW US</h6>

                        <div class="social-links">

                            <a href="#" class="social-link">
                                <i class="bi bi-instagram"></i>
                            </a>

                            <a href="#" class="social-link">
                                <i class="bi bi-facebook"></i>
                            </a>

                            <a href="#" class="social-link">
                                <i class="bi bi-youtube"></i>
                            </a>

                            <a href="#" class="social-link">
                                <i class="bi bi-tiktok"></i>
                            </a>

                        </div>

                    </div>

                </div>
            </div>

            {{-- RIGHT --}}
            <div class="col-lg-7">
                <div class="contact-form-wrapper reveal">

                    <h3 class="form-heading">
                        Kirim Pesan
                    </h3>

                    <p class="form-subtext">
                        Isi form di bawah dan tim kami akan segera menghubungi Anda.
                    </p>

                    <form class="contact-form">

                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="form-label">
                                    Nama Lengkap
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Masukkan nama lengkap"
                                >
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    class="form-control"
                                    placeholder="email@example.com"
                                >
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Nomor Telepon
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="+62 xxx xxxx xxxx"
                                >
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">
                                    Subjek
                                </label>

                                <select class="form-select">
                                    <option selected disabled>
                                        Pilih Subjek
                                    </option>

                                    <option>
                                        Booking Studio
                                    </option>

                                    <option>
                                        Recording
                                    </option>

                                    <option>
                                        Event Musik
                                    </option>

                                    <option>
                                        Kolaborasi
                                    </option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">
                                    Pesan
                                </label>

                                <textarea
                                    rows="6"
                                    class="form-control"
                                    placeholder="Tulis pesan Anda..."
                                ></textarea>
                            </div>

                            <div class="col-12">
                                <button
                                    type="submit"
                                    class="btn-submit"
                                >
                                    <i class="bi bi-send-fill me-2"></i>
                                    KIRIM PESAN
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

@section('extra-js')
<script src="{{ asset('js/contact.js') }}"></script>
@endsection
