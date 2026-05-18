<aside class="admin-sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="sidebar-logo">
        <h3>Admin Panel</h3>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.studios') }}" class="nav-item {{ request()->routeIs('admin.studios') ? 'active' : '' }}">
            <i class="bi bi-building"></i>
            <span>Kelola Studio</span>
        </a>
        <a href="{{ route('admin.bookings') }}" class="nav-item {{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i>
            <span>Kelola Booking</span>
        </a>
        <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span>Kelola User</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="{{ url('/') }}" class="btn-back">
            <i class="bi bi-box-arrow-left"></i>
            <span>Kembali ke Website</span>
        </a>
    </div>
</aside>
