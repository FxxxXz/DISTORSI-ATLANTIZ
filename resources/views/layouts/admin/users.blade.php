@extends('layouts.app')

@section('title', 'Kelola User - Admin')

@push('styles')
<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="admin-container">
    @include('admin.partials.sidebar')

    <main class="admin-main">
        <div class="admin-header">
            <div>
                <h1>Kelola User</h1>
                <p>Mengelola data pengguna</p>
            </div>
            <div class="admin-user">
                <span>{{ auth()->user()->nama_lengkap ?? 'Admin' }}</span>
                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Admin">
            </div>
        </div>

        <div class="page-actions">
            <button class="btn-add" onclick="openUserModal()">
                <i class="bi bi-plus-circle"></i> Tambah User
            </button>
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="usersTable">
                    <tr><td colspan="7" class="text-center">Loading...</td></tr>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Modal User -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="userModalTitle">Tambah User</h3>
            <span class="close" onclick="closeUserModal()">&times;</span>
        </div>
        <form id="userForm">
            <input type="hidden" id="userId">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" id="userNama" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" id="userUsername" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="userEmail" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" id="userPassword" class="form-control" placeholder="Kosongkan jika tidak diubah">
            </div>
            <div class="form-group">
                <label>Role</label>
                <select id="userRole" class="form-control">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select id="userStatus" class="form-control">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeUserModal()">Batal</button>
                <button type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('extra-js')
<script src="{{ asset('js/admin.js') }}"></script>
@endsection
