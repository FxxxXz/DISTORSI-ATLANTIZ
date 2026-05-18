@extends('layouts.app')

@section('title', 'Booking Studio Musik - Login')

@section('hide-navbar')
@endsection

@section('hide-footer')
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')
{{-- LOGO LUAR BOX --}}
<img src="{{ asset('img/logo.png') }}" alt="Logo Studio Musik" class="logo-top">

<div class="login-box">
    {{-- LOGO DALAM BOX --}}
    <img src="{{ asset('img/logo.png') }}" alt="Logo Studio Musik" class="logo2">
    <h2 class="login-title">SIGN IN</h2>
    <p class="login-desc">Masuk ke akun Anda untuk melakukan booking studio dan mengelola jadwal studio musik.</p>

    {{-- Alert Error --}}
    <div id="errorAlert" class="alert alert-danger d-none" role="alert">
        <ul class="mb-0" id="errorList"></ul>
    </div>

    {{-- Alert Sukses --}}
    <div id="successAlert" class="alert alert-success d-none" role="alert">Login berhasil!</div>

    <form class="needs-validation" id="loginForm" novalidate>
        @csrf
        {{-- Email --}}
        <div class="mb-3">
            <input type="email" class="form-control" id="email" name="email" required placeholder="Email / Username">
            <div class="invalid-feedback">Email wajib diisi dengan format yang benar.</div>
        </div>

        {{-- Password dengan toggle --}}
        <div class="mb-3 position-relative password-wrapper">
            <input type="password" class="form-control" id="password" name="password" required placeholder="Password">
            <span class="toggle-password" onclick="togglePassword('password', 'toggleIcon')">
                <i class="bi bi-eye-slash" id="toggleIcon"></i>
            </span>
            <div class="invalid-feedback">Password wajib diisi.</div>
        </div>

        {{-- Remember Me & Forgot Password --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check text-start">
                <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember Me</label>
            </div>
            <div class="forgot-password">
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
        </div>

        {{-- Tombol Submit --}}
        <button type="submit" class="btn btn-login" id="btnSubmit">
            <span class="spinner-border spinner-border-sm d-none" id="btnSpinner"></span>
            <span id="btnText">SIGN IN</span>
        </button>

        <p class="register-text">Belum punya akun? <a href="{{ route('register') }}">Registrasi</a></p>
    </form>
</div>
@endsection

@section('extra-js')
<script src="{{ asset('js/script.js') }}"></script>
@endsection
