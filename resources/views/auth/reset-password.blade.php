@extends('layouts.app')

@section('title', 'Reset Password')

@section('hide-navbar')
@endsection

@section('hide-footer')
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4 p-4">
                <h4 class="text-center mb-3">Reset Password</h4>
                <p class="text-center text-muted small">Masukkan password baru kamu</p>
                <form id="resetForm">
                    @csrf
                    {{-- Password Baru --}}
                    <div class="mb-3">
                        <input type="password" class="form-control" id="newPassword" placeholder="Password Baru" required>
                        <small id="passwordError" class="text-danger"></small>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-3">
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Konfirmasi Password" required>
                        <small id="confirmError" class="text-danger"></small>
                    </div>

                    <button class="btn btn-primary w-100">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script src="{{ asset('js/reset-password.js') }}"></script>
@endsection