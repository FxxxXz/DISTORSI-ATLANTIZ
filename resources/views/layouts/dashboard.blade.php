@extends('layouts.app')

@section('title', 'Dashboard - Distorsi Atlantiz Studio')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- Welcome Card --}}
            <div class="card bg-dark text-white border-0 shadow-lg mb-4">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-2">Selamat Datang, {{ auth()->user()->nama_lengkap ?? auth()->user()->username }}! 👋</h3>
                    <p class="text-white-50 mb-0">Anda berhasil login ke sistem booking studio musik.</p>
                </div>
            </div>

            {{-- Info Cards --}}
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card bg-dark text-white border-secondary h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-calendar-check me-2"></i>Booking Saya</h5>
                            <p class="card-text text-white-50">Lihat dan kelola jadwal booking studio Anda.</p>
                            <a href="{{ route('booking.index') }}" class="btn btn-outline-light btn-sm">Lihat Booking</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-dark text-white border-secondary h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-person me-2"></i>Profil</h5>
                            <p class="card-text text-white-50">Kelola informasi akun dan data pribadi Anda.</p>
                            <a href="#" class="btn btn-outline-light btn-sm">Edit Profil</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Role Info --}}
            @if(auth()->user()->isAdmin())
            <div class="alert alert-warning mt-4 border-0">
                <i class="bi bi-shield-lock me-2"></i>
                <strong>Admin Detected!</strong> 
                <a href="{{ route('admin.dashboard') }}" class="alert-link">Klik di sini untuk masuk ke Admin Panel</a>.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection