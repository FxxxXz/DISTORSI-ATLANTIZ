<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | Distorsi Atlantiz</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
<link rel="shortcut icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <style>
    :root {
        --sidebar-width: 260px;
        --primary: #ff4d4d;
        --dark: #1a1a1a;
        --darker: #0f0f0f;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        /* HILANGKAN SCROLLBAR GLOBAL */
        scrollbar-width: none;        /* Firefox */
        -ms-overflow-style: none;     /* IE & Edge */
    }
    
    *::-webkit-scrollbar {
        display: none;                /* Chrome, Safari, Opera */
    }
    
    body {
        font-family: 'Montserrat', sans-serif;
        background: #f5f5f5;
        overflow-x: hidden;
    }
        
        .admin-sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background: var(--dark);
        color: white;
        overflow-y: auto;      /* tetap bisa scroll */
        z-index: 1000;
        /* scrollbar sudah di-hide oleh * selector di atas */
    }
        
        .admin-sidebar .logo {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .admin-sidebar .logo img {
            width: 50px;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 20px;
            border-radius: 0;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        
        .nav-link:hover, .nav-link.active {
            color: white;
            background: rgba(255,77,77,0.2);
            border-left: 3px solid var(--primary);
        }
        
        .nav-link i {
            width: 24px;
            font-size: 1.1rem;
        }
        
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 20px;
        }
        
        .admin-header {
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-left: 4px solid var(--primary);
        }
        
        .stat-card i {
            font-size: 2rem;
            color: var(--primary);
            opacity: 0.8;
        }
        
        .table-container {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .badge-pending { background: #ffc107; color: #000; }
        .badge-confirmed { background: #28a745; }
        .badge-cancelled { background: #dc3545; }
        .badge-completed { background: #6c757d; }
    </style>
    
    @stack('styles')
</head>
<body>
    {{-- SIDEBAR --}}
    <aside class="admin-sidebar">
        <div class="logo d-flex align-items-center gap-2">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
            <div>
                <h6 class="mb-0">Distorsi Atlantiz</h6>
                <small class="text-muted">Admin Panel</small>
            </div>
        </div>
        
        <nav class="nav flex-column mt-3">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.bookings') }}" class="nav-link {{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i> Booking
            </a>
            <a href="{{ route('admin.studios') }}" class="nav-link {{ request()->routeIs('admin.studios') ? 'active' : '' }}">
                <i class="bi bi-music-note-beamed"></i> Studio
            </a>
            <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Users
            </a>
            <a href="{{ route('admin.kontaks') }}" class="nav-link {{ request()->routeIs('admin.kontaks') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i> Pesan
            </a>
            
            <hr class="border-secondary my-3 mx-3">
            
            <a href="{{ route('home') }}" class="nav-link" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i> Lihat Website
            </a>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </nav>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="admin-main">
        <div class="admin-header">
            <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted">{{ auth()->user()->nama_lengkap }}</span>
                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" width="35" class="rounded-circle">
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>