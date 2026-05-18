{{-- resources/views/partials/navbar.blade.php --}}
<<nav class="navbar navbar-expand-lg navbar-dark fixed-top custom-navbar">
    <div class="container-fluid d-flex align-items-center px-4 position-relative">
        
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('img/logo.png') }}" class="logo-top" alt="Logo">
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
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
            <div class="ms-auto d-flex align-items-center gap-3">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle btn-sm" data-bs-toggle="dropdown">
                            {{ auth()->user()->nama_lengkap }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            @if(auth()->user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>