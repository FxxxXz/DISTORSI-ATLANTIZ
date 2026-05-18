@extends('layouts.app')

@section('title', 'HOME - Distorsi Atlantiz')

<link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
<link rel="shortcut icon" type="image/png" href="{{ asset('img/logo.png') }}">

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
