@extends('layouts.app')

@section('title', 'Tentang Studio - Distorsi Atlantiz')

@push('styles')
<link href="{{ asset('css/about.css') }}" rel="stylesheet">
@endpush

@section('content')
{{-- SLIDER --}}
<section class="about-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 reveal">
                <div class="about-image">
                    <img src="{{ asset('img/about-1.png') }}" alt="Studio Musik">
                    <div class="experience-badge">
                        <span class="tahun">5+</span>
                        <span class="text">Tahun<br>Pengalaman</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reveal">
                <div class="about-slider-wrapper">
                    <div class="about-slider" id="aboutSlider">
                        <div class="about-slide active">
                            <h6>TENTANG KAMI</h6>
                            <h2>Distorsi Atlantiz Studio</h2>
                            <p>Studio musik yang dirancang untuk para musisi, band, dan kreator audio yang ingin menghasilkan karya dengan kualitas terbaik. Kami menyediakan ruang studio yang nyaman dengan peralatan rekaman dan latihan yang modern untuk mendukung setiap proses berkarya.</p>
                            <p>Studio ini hadir sebagai tempat bagi musisi untuk berlatih, merekam, dan mengembangkan ide musik dengan lebih maksimal. Dengan suasana yang profesional namun tetap santai, Distorsi Atlantiz menjadi ruang yang tepat untuk menyalurkan kreativitas tanpa batas.</p>
                            <p>Kami percaya bahwa setiap musik memiliki karakter dan cerita. Oleh karena itu, Distorsi Atlantiz berkomitmen menyediakan fasilitas dan lingkungan yang mendukung agar setiap musisi dapat menghasilkan suara terbaik mereka.</p>
                        </div>
                        <div class="about-slide">
                            <h6>SEJARAH</h6>
                            <h2>Didirikan pada tahun 2024 di Banda Aceh</h2>
                            <p>Studio ini lahir dari keinginan untuk menyediakan ruang berkarya bagi para musisi lokal yang membutuhkan tempat latihan dan rekaman dengan suasana yang nyaman dan fasilitas yang memadai.</p>
                            <p>Sejak awal berdirinya, Distorsi Atlantiz berkomitmen menjadi wadah bagi musisi, band, maupun kreator audio untuk mengembangkan ide dan menghasilkan karya musik berkualitas.</p>
                            <p>Dengan konsep studio yang modern namun tetap hangat dan santai, tempat ini diharapkan dapat menjadi ruang kreatif bagi komunitas musik.</p>
                        </div>
                        <div class="about-slide">
                            <h6>KOMUNITAS</h6>
                            <h2>Lebih Dari Sekadar Studio</h2>
                            <p>Distorsi Atlantiz tidak hanya berfungsi sebagai studio latihan dan rekaman, tetapi juga sebagai tempat bertemunya para musisi untuk berkolaborasi, berbagi pengalaman, dan membangun ekosistem musik yang lebih berkembang.</p>
                        </div>
                    </div>
                    <div class="slider-nav">
                        <button class="slider-btn prev" onclick="prevSlide()"><i class="bi bi-chevron-left"></i></button>
                        <div class="slider-dots" id="sliderDots"></div>
                        <button class="slider-btn next" onclick="nextSlide()"><i class="bi bi-chevron-right"></i></button>
                    </div>
                    <div class="about-stats">
                        <div class="stat-item"><span class="stat-number">99+</span><span class="stat-label">Band Aktif</span></div>
                        <div class="stat-item"><span class="stat-number">20+</span><span class="stat-label">Ruang Studio</span></div>
                        <div class="stat-item"><span class="stat-number">24/7</span><span class="stat-label">Jam Operasional</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- OUR TEAM (TANPA ICON PANAH) --}}
<section class="team-section">
    <div class="container">
        <h6 class="section-subtitle">MEET OUR TEAM</h6>
        <div class="team-wrapper">
            <div class="team-grid" id="teamGrid">
                <div class="team-card">
                    <div class="team-image"><img src="{{ asset('img/team/asti.png') }}" alt="Asti Auliah Siregar" onerror="this.src='https://via.placeholder.com/300x400/333/fff?text=ASTI'"></div>
                    <h4 class="team-name">Asti Auliah Siregar</h4>
                </div>
                <div class="team-card">
                    <div class="team-image"><img src="{{ asset('img/team/alya.png') }}" alt="Alya Syakira" onerror="this.src='https://via.placeholder.com/300x400/333/fff?text=ALYA'"></div>
                    <h4 class="team-name">Alya Syakira</h4>
                </div>
                <div class="team-card">
                    <div class="team-image"><img src="{{ asset('img/team/adlan.png') }}" alt="Di Adlan Novianda" onerror="this.src='https://via.placeholder.com/300x400/333/fff?text=ADLAN'"></div>
                    <h4 class="team-name">Di Adlan Novianda</h4>
                </div>
                <div class="team-card">
                    {{-- PERBAIKI PATH: hapus double slash // --}}
                    <div class="team-image"><img src="{{ asset('img/team/faiz.jpeg') }}" alt="M Faiz Firmansyah" onerror="this.src='https://via.placeholder.com/300x400/333/fff?text=FAIZ'"></div>
                    <h4 class="team-name">M Faiz Firmansyah</h4>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('extra-js')
<script src="{{ asset('js/about.js') }}"></script>
@endsection
x
