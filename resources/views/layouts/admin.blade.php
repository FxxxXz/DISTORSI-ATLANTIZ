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
    
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #ff4d4d;
            --dark: #1a1a1a;
            --darker: #0f0f0f;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background: #f5f5f5;
        }
        
        .admin-sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: var(--dark);
            color: white;
            overflow-y: auto;
            z-index: 1000;
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
        }
        
        .nav-link:hover, .nav-link.active {
            color: white;
            background: rgba(255,77,77,0.2);
            border-left: 3px solid var(--primary);
        }
        
        .nav-link i {
            width: 24px;
        }
        
        .admin-main {
            margin-left: var(--sidebar-width);
            padding: 20px;
        }
        
        .admin-header {
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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
            <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i> Booking
                @php($pendingCount = \App\Models\Booking::pending()->count())
                @if($pendingCount > 0)
                    <span class="badge bg-danger ms-auto">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.studios.index') }}" class="nav-link {{ request()->routeIs('admin.studios.*') ? 'active' : '' }}">
                <i class="bi bi-music-note-beamed"></i> Studio
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Users
            </a>
            <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i> Pesan
                @php($unreadCount = \App\Models\Kontak::where('status', 'unread')->count())
                @if($unreadCount > 0)
                    <span class="badge bg-danger ms-auto">{{ $unreadCount }}</span>
                @endif
            </a>
            
            <hr class="border-secondary my-3">
            
            <a href="{{ route('home') }}" class="nav-link" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i> Lihat Website
            </a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </nav>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="admin-main">
        <div class="admin-header d-flex justify-content-between align-items-center">
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

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>