@extends('layouts.app')

@section('title', 'Kelola Studio - Admin')

@push('styles')
<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <div class="admin-header">
            <div>
                <h1>Kelola Studio</h1>
                <p>Mengelola data studio musik</p>
            </div>
            <div class="admin-user">
                <span>{{ auth()->user()->nama_lengkap ?? 'Admin' }}</span>
                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Admin">
            </div>
        </div>

        <div class="page-actions">
            <button class="btn-add" onclick="openStudioModal()">
                <i class="bi bi-plus-circle"></i> Tambah Studio
            </button>
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Studio</th>
                        <th>Tipe</th>
                        <th>Harga/Jam</th>
                        <th>Kapasitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="studiosTable">
                    <tr><td colspan="7" class="text-center">Loading...</td></tr>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Modal Studio -->
<div id="studioModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="studioModalTitle">Tambah Studio</h3>
            <span class="close" onclick="closeStudioModal()">&times;</span>
        </div>
        <form id="studioForm">
            <input type="hidden" id="studioId">
            <div class="form-group">
                <label>Nama Studio</label>
                <input type="text" id="studioNama" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tipe</label>
                <select id="studioTipe" class="form-control">
                    <option value="regular">Regular</option>
                    <option value="premium">Premium</option>
                    <option value="recording">Recording</option>
                </select>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea id="studioDeskripsi" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Harga/Jam</label>
                    <input type="number" id="studioHarga" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Kapasitas</label>
                    <input type="number" id="studioKapasitas" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label>Foto</label>
                <input type="file" id="studioFoto" class="form-control" accept="image/*">
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeStudioModal()">Batal</button>
                <button type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('extra-js')
<script src="{{ asset('js/admin.js') }}"></script>
@endsection
