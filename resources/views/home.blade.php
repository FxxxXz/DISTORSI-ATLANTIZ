@extends('layouts.app')

@section('title', 'Studio Booking - Distorsi Atlantiz')

@section('content')
{{-- ================= HERO SECTION ================= --}}
<section class="hero">
    <div class="hero-bg"></div>
    <div class="overlay"></div>
    <div class="hero-content text-center">
        <h1 class="hero-title reveal">
            BRINGING YOUR MUSIC<br>INTO FOCUS
        </h1>
    </div>
</section>
@endsection

@section('extra-js')
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
 5
