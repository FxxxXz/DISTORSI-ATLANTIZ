@extends('layouts.app')

@section('title', 'Booking Studio Musik - Register')

@section('hide-navbar')
@endsection

@section('hide-footer')
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')
{{-- LOGO LUAR --}}
<img src="{{ asset('img/logo.png') }}" alt="Logo Studio Musik" class="logo-top">

<div class="login-box">
    {{-- LOGO --}}
    <img src="{{ asset('img/logo.png') }}" alt="Logo Studio Musik" class="logo2">
    <h2 class="login-title">REGISTER</h2>
    <p class="login-desc">Buat akun untuk mulai melakukan booking studio musik dan mengatur jadwal latihan band Anda.</p>

    {{-- Alert Error --}}
    <div id="errorAlert" class="alert alert-danger d-none" role="alert">
        <ul class="mb-0" id="errorList"></ul>
    </div>

    {{-- Alert Sukses --}}
    <div id="successAlert" class="alert alert-success d-none" role="alert">Registrasi berhasil! Mengalihkan ke login...</div>

    <form class="needs-validation" id="registerForm" novalidate>
        @csrf
        {{-- Nama Lengkap --}}
        <div class="mb-3">
            <input type="text" class="form-control" id="namaLengkap" name="namaLengkap" required placeholder="Nama Lengkap" minlength="3">
            <div class="invalid-feedback">Nama lengkap minimal 3 karakter.</div>
        </div>

        {{-- Username --}}
        <div class="mb-3">
            <input type="text" class="form-control" id="username" name="username" required placeholder="Username" minlength="5">
            <div class="invalid-feedback">Username minimal 5 karakter.</div>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <input type="email" class="form-control" id="email" name="email" required placeholder="Email">
            <div class="invalid-feedback">Email wajib diisi dengan format yang benar.</div>
        </div>

        {{-- Password dengan Toggle --}}
        <div class="mb-3 position-relative password-wrapper">
            <input type="password" class="form-control" id="password" name="password" required placeholder="Password" minlength="6">
            <span class="toggle-password" onclick="togglePassword('password', 'toggleIcon1')">
                <i class="bi bi-eye-slash" id="toggleIcon1"></i>
            </span>
            <div class="invalid-feedback">Password minimal 6 karakter.</div>
        </div>

        {{-- Konfirmasi Password dengan Toggle --}}
        <div class="mb-3 position-relative password-wrapper">
            <input type="password" class="form-control" id="konfirmasiPassword" name="konfirmasiPassword" required placeholder="Konfirmasi Password">
            <span class="toggle-password" onclick="togglePassword('konfirmasiPassword', 'toggleIcon2')">
                <i class="bi bi-eye-slash" id="toggleIcon2"></i>
            </span>
            <div class="invalid-feedback">Konfirmasi password wajib diisi.</div>
        </div>

        {{-- Tombol Register --}}
        <button type="submit" class="btn btn-login" id="btnSubmit">
            <span class="spinner-border spinner-border-sm d-none" id="btnSpinner"></span>
            <span id="btnText">REGISTER</span>
        </button>

        <p class="register-text">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
    </form>
</div>
@endsection

@section('extra-js')
<script src="{{ asset('js/register.js') }}"></script>
@endsection