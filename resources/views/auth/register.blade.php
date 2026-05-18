@extends('layouts.app')

@section('title', 'Distorsi Atlantiz - Register')

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
<div id="successAlert" class="alert alert-success d-none" role="alert">Registrasi berhasil! Mengalihkan...</div>

{{-- SATU FORM LENGKAP --}}
<form method="POST" action="{{ route('register') }}" id="registerForm">
    @csrf
    
    {{-- Nama Lengkap --}}
    <div class="mb-3">
        <input type="text" 
               class="form-control" 
               id="namaLengkap" 
               name="namaLengkap" 
               required 
               placeholder="Nama Lengkap" 
               minlength="3"
               autocomplete="off"
               autocorrect="off"
               autocapitalize="words"
               spellcheck="false">
        <div class="invalid-feedback">Nama lengkap minimal 3 karakter.</div>
    </div>

    {{-- Username --}}
    <div class="mb-3">
        <input type="text" 
               class="form-control" 
               id="username" 
               name="username" 
               required 
               placeholder="Username" 
               minlength="5"
               autocomplete="off"
               autocorrect="off"
               autocapitalize="off"
               spellcheck="false">
        <div class="invalid-feedback">Username minimal 5 karakter, tidak boleh ada spasi.</div>
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <input type="email" 
               class="form-control" 
               id="email" 
               name="email" 
               required 
               placeholder="Email"
               autocomplete="off"
               autocorrect="off"
               autocapitalize="off"
               spellcheck="false">
        <div class="invalid-feedback">Email wajib diisi dengan format yang benar.</div>
    </div>

    {{-- Password dengan Toggle --}}
    <div class="mb-3 position-relative password-wrapper">
        <input type="password" 
               class="form-control" 
               id="password" 
               name="password" 
               required 
               placeholder="Password" 
               minlength="6"
               autocomplete="new-password">
        <span class="toggle-password" onclick="togglePassword('password', 'toggleIcon1')">
            <i class="bi bi-eye-slash" id="toggleIcon1"></i>
        </span>
        <div class="invalid-feedback">Password minimal 6 karakter.</div>
    </div>

    {{-- Konfirmasi Password dengan Toggle --}}
    <div class="mb-3 position-relative password-wrapper">
        <input type="password" 
               class="form-control" 
               id="password_confirmation" 
               name="password_confirmation" 
               required 
               placeholder="Konfirmasi Password"
               autocomplete="new-password">
        <span class="toggle-password" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
            <i class="bi bi-eye-slash" id="toggleIcon2"></i>
        </span>
        <div class="invalid-feedback" id="matchFeedback">Konfirmasi password tidak cocok.</div>
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
<script>
/* ================= TOGGLE PASSWORD ================= */
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (!input || !icon) return;
    
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

/* ================= NAMA LENGKAP AUTO TITLE CASE ================= */
const namaInput = document.getElementById('namaLengkap');
if (namaInput) {
    namaInput.addEventListener('input', function() {
        this.value = this.value.replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    });
}

/* ================= USERNAME AUTO LOWERCASE + NO SPACE ================= */
const usernameInput = document.getElementById('username');
if (usernameInput) {
    usernameInput.addEventListener('input', function() {
        this.value = this.value.toLowerCase().replace(/\s/g, '').replace(/[^a-z0-9_.-]/g, '');
    });
    
    usernameInput.addEventListener('keydown', function(e) {
        if (e.key === ' ') {
            e.preventDefault();
        }
    });
}

/* ================= EMAIL VALIDASI ================= */
const emailInput = document.getElementById('email');

function validateEmail(email) {
    const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return regex.test(email);
}

if (emailInput) {
    emailInput.addEventListener('input', function() {
        this.value = this.value.toLowerCase().replace(/\s/g, '');
        
        if (this.value && !validateEmail(this.value)) {
            this.classList.add('is-invalid');
            this.nextElementSibling.textContent = 'Format email tidak valid (contoh: nama@email.com)';
        } else {
            this.classList.remove('is-invalid');
        }
    });
}

/* ================= PASSWORD MATCH CHECK ================= */
const passwordInput = document.getElementById('password');
const confirmInput = document.getElementById('password_confirmation');
const matchFeedback = document.getElementById('matchFeedback');

function checkMatch() {
    if (confirmInput.value && passwordInput.value !== confirmInput.value) {
        confirmInput.classList.add('is-invalid');
        confirmInput.classList.remove('is-valid');
        matchFeedback.textContent = 'Password tidak cocok!';
        return false;
    } else if (confirmInput.value && passwordInput.value === confirmInput.value) {
        confirmInput.classList.remove('is-invalid');
        confirmInput.classList.add('is-valid');
        return true;
    } else {
        confirmInput.classList.remove('is-valid', 'is-invalid');
        return false;
    }
}

if (confirmInput) confirmInput.addEventListener('input', checkMatch);
if (passwordInput) passwordInput.addEventListener('input', checkMatch);

/* ================= FORM SUBMIT ================= */
const registerForm = document.getElementById('registerForm');
const btnSubmit = document.getElementById('btnSubmit');
const btnSpinner = document.getElementById('btnSpinner');
const btnText = document.getElementById('btnText');
const errorAlert = document.getElementById('errorAlert');
const errorList = document.getElementById('errorList');
const successAlert = document.getElementById('successAlert');

if (registerForm) {
    registerForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!registerForm.checkValidity()) {
            e.stopPropagation();
            registerForm.classList.add('was-validated');
            return;
        }
        
        if (!validateEmail(emailInput.value)) {
            emailInput.classList.add('is-invalid');
            emailInput.nextElementSibling.textContent = 'Format email tidak valid!';
            return;
        }
        
        if (passwordInput.value !== confirmInput.value) {
            confirmInput.classList.add('is-invalid');
            matchFeedback.textContent = 'Password tidak cocok!';
            return;
        }
        
        btnSubmit.disabled = true;
        btnSpinner.classList.remove('d-none');
        btnText.textContent = 'MEMPROSES...';
        errorAlert.classList.add('d-none');
        
        const formData = new FormData(registerForm);
        
        try {
            const response = await fetch('{{ route("register") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
            });
            
            const result = await response.json();
            
            if (response.ok && result.success) {
                successAlert.classList.remove('d-none');
                registerForm.reset();
                registerForm.classList.remove('was-validated');
                
                setTimeout(() => {
                    window.location.href = result.redirect || '{{ route("home") }}';
                }, 1500);
            } else {
                if (result.errors) {
                    errorAlert.classList.remove('d-none');
                    errorList.innerHTML = '';
                    Object.values(result.errors).forEach(errors => {
                        errors.forEach(error => {
                            errorList.innerHTML += `<li>${error}</li>`;
                        });
                    });
                } else {
                    throw new Error(result.message || 'Terjadi kesalahan');
                }
            }
        } catch (error) {
            errorAlert.classList.remove('d-none');
            errorList.innerHTML = `<li>${error.message || 'Gagal registrasi. Silakan coba lagi.'}</li>`;
        } finally {
            btnSubmit.disabled = false;
            btnSpinner.classList.add('d-none');
            btnText.textContent = 'REGISTER';
        }
    });
}
</script>
@endsection