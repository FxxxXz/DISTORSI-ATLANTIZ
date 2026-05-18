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

    {{-- Alert Error Laravel --}}
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM SUBMIT BIASA (POST ke route login) --}}
    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
        @csrf
        
        {{-- Email --}}
        <div class="mb-3">
            <input type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}"
                   required 
                   placeholder="Email"
                   autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password dengan toggle --}}
        <div class="mb-3 position-relative password-wrapper">
            <input type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   id="password" 
                   name="password" 
                   required 
                   placeholder="Password">
            <span class="toggle-password" onclick="togglePassword('password', 'toggleIcon')">
                <i class="bi bi-eye-slash" id="toggleIcon"></i>
            </span>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check text-start">
                <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                <label class="form-check-label" for="rememberMe">Remember Me</label>
            </div>
            {{-- FIX: Hapus route password.request yang tidak ada --}}
            <div class="forgot-password">
                <a href="javascript:void(0)" onclick="alert('Hubungi admin untuk reset password.')">Forgot Password?</a>
            </div>
        </div>

        {{-- Tombol Submit --}}
        <button type="submit" class="btn btn-login">
            SIGN IN
        </button>

        <p class="register-text">Belum punya akun? <a href="{{ route('register') }}">Registrasi</a></p>
    </form>
</div>
@endsection

@section('extra-js')
<script>
    // Toggle password visibility
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }

    // Bootstrap validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endsection