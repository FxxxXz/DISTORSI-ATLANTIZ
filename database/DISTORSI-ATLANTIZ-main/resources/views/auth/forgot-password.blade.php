@extends('layouts.app')

@section('title', 'Lupa Password - Booking Studio Musik')

@section('hide-navbar')
@endsection

@section('hide-footer')
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')
{{-- LOGO --}}
<img src="{{ asset('img/logo.png') }}" class="logo-top" alt="Logo">

<div class="login-box">
    <img src="{{ asset('img/logo.png') }}" class="logo2" alt="Logo">
    <h2 class="login-title">FORGOT PASSWORD</h2>
    <p class="login-desc">Masukkan email akun Anda. Kami akan mengirimkan link untuk reset password.</p>

    {{-- ALERT ERROR --}}
    <div id="errorAlert" class="alert alert-danger d-none">
        <ul class="mb-0" id="errorList"></ul>
    </div>

    {{-- ALERT SUCCESS --}}
    <div id="successAlert" class="alert alert-success d-none">Link reset password telah dikirim ke email Anda.</div>

    <form class="needs-validation" novalidate>
        @csrf
        {{-- EMAIL --}}
        <div class="mb-3">
            <input type="email" class="form-control" id="email" placeholder="Masukkan Email Anda" required>
            <div class="invalid-feedback">Email wajib diisi dengan format benar.</div>
        </div>

        {{-- BUTTON --}}
        <button type="submit" class="btn btn-login" id="btnSubmit">
            <span class="spinner-border spinner-border-sm d-none" id="btnSpinner"></span>
            <span id="btnText">SEND LINK</span>
        </button>

        <p class="register-text">Ingat password? <a href="{{ route('login') }}">Login</a></p>
    </form>
</div>
@endsection

@section('extra-js')
<script src="{{ asset('js/forgot.js') }}"></script>
@endsection