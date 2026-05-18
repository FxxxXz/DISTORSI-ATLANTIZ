{{-- ================= NAVBAR ================= --}}
<nav class="navbar navbar-expand-lg navbar-dark fixed-top custom-navbar">
    <div class="container-fluid d-flex align-items-center px-4 position-relative">
        {{-- LOGO --}}
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('img/logo.png') }}" class="logo-top" alt="Logo">
        </a>
        
        {{-- Mobile Toggle --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        {{-- CENTER MENU --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="nav-center mx-auto">
                <ul class="navbar-nav gap-4">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">TENTANG STUDIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('facilities') ? 'active' : '' }}" href="{{ route('facilities') }}">FASILITAS & BOOKING</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">KONTAK</a>
                    </li>
                </ul>
            </div>
            
            {{-- USER AREA --}}
            <div id="userArea" class="ms-auto"></div>
        </div>
    </div>
</nav>