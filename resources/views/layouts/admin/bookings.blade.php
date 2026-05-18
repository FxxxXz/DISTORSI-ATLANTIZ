@extends('layouts.app')

@section('title', 'Kelola Booking - Admin')

@push('styles')
<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <div class="admin-header">
            <div>
                <h1>Kelola Booking</h1>
                <p>Mengelola data pemesanan studio</p>
            </div>
            <div class="admin-user">
                <span>{{ auth()->user()->nama_lengkap ?? 'Admin' }}</span>
                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Admin">
            </div>
        </div>

        <div class="page-actions">
            <div class="filter-group">
                <select id="filterStatus" class="filter-select">
                    <option value="all">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Studio</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Durasi</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="bookingsTable">
                    <tr><td colspan="9" class="text-center">Loading...</td></tr>
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection

@section('extra-js')
<script src="{{ asset('js/admin.js') }}"></script>
@endsection
