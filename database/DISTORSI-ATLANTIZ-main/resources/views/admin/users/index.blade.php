@extends('layouts.admin')

@section('title', 'Kelola User')
@section('page-title', 'Kelola User')

@section('content')
<div class="table-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Daftar User</h5>
        <button class="btn btn-primary" onclick="openModal()">
            <i class="bi bi-plus-circle"></i> Tambah User
        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>#{{ $user->id }}</td>
                    <td>{{ $user->nama_lengkap }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'primary' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td>
                        <button onclick="openEditModal({{ $user->id }}, '{{ $user->nama_lengkap }}', '{{ $user->username }}', '{{ $user->email }}', '{{ $user->role }}', '{{ $user->no_telepon ?? '' }}', '{{ $user->alamat ?? '' }}')" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </button>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-people fs-1 d-block mb-2"></i>
                        Belum ada user
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div class="mt-3">
        {{ $users->links() }}
    </div>
    @endif
</div>

<!-- Modal Tambah User -->
<div id="userModal" class="modal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
    <div style="background-color: white; margin: 5% auto; padding: 20px; border-radius: 10px; width: 500px; max-width: 90%;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0" id="modalTitle">Tambah User</h5>
            <button onclick="closeModal()" class="btn btn-sm btn-outline-secondary">&times;</button>
        </div>
        
        <form id="userForm" action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <input type="hidden" id="userId" name="id">
            <input type="hidden" id="_method" name="_method" value="POST">
            
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">No Telepon</label>
                <input type="text" name="no_telepon" id="no_telepon" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" id="role" class="form-control">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="button" onclick="closeModal()" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openModal() {
    document.getElementById('modalTitle').textContent = 'Tambah User';
    document.getElementById('userForm').action = '{{ route("admin.users.store") }}';
    document.getElementById('_method').value = 'POST';
    document.getElementById('userId').value = '';
    document.getElementById('nama_lengkap').value = '';
    document.getElementById('username').value = '';
    document.getElementById('email').value = '';
    document.getElementById('password').value = '';
    document.getElementById('no_telepon').value = '';
    document.getElementById('alamat').value = '';
    document.getElementById('role').value = 'user';
    document.getElementById('userModal').style.display = 'block';
}

function openEditModal(id, nama, username, email, role, telepon, alamat) {
    document.getElementById('modalTitle').textContent = 'Edit User';
    document.getElementById('userForm').action = '{{ url("admin/users") }}/' + id;
    document.getElementById('_method').value = 'PUT';
    document.getElementById('userId').value = id;
    document.getElementById('nama_lengkap').value = nama;
    document.getElementById('username').value = username;
    document.getElementById('email').value = email;
    document.getElementById('password').value = '';
    document.getElementById('no_telepon').value = telepon;
    document.getElementById('alamat').value = alamat;
    document.getElementById('role').value = role;
    document.getElementById('userModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('userModal').style.display = 'none';
}

window.onclick = function(event) {
    var modal = document.getElementById('userModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>
@endpush
@endsection