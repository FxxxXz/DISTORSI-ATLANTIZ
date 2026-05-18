@extends('layouts.admin')

@section('title', 'Kelola Studio')
@section('page-title', 'Kelola Studio')

@section('content')
<div class="table-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Daftar Studio</h5>
        <button class="btn btn-primary" onclick="openModal()">
            <i class="bi bi-plus-circle"></i> Tambah Studio
        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Harga/Jam</th>
                    <th>Kapasitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($studios as $studio)
                <tr>
                    <td>#{{ $studio->id }}</td>
                    <td>{{ $studio->nama }}</td>
                    <td>{{ $studio->tipe }}</td>
                    <td>Rp {{ number_format($studio->harga_per_jam, 0, ',', '.') }}</td>
                    <td>{{ $studio->kapasitas }}</td>
                    <td>
                        <a href="{{ route('admin.studios.edit', $studio->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.studios.destroy', $studio->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus studio ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-music-note-beamed fs-1 d-block mb-2"></i>
                        Belum ada studio
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($studios->hasPages())
    <div class="mt-3">
        {{ $studios->links() }}
    </div>
    @endif
</div>

<!-- Modal Tambah Studio -->
<div id="studioModal" class="modal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
    <div style="background-color: white; margin: 5% auto; padding: 20px; border-radius: 10px; width: 500px; max-width: 90%;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Tambah Studio</h5>
            <button onclick="closeModal()" class="btn btn-sm btn-outline-secondary">&times;</button>
        </div>
        
        <form action="{{ route('admin.studios.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Studio</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipe</label>
                <select name="tipe" class="form-control">
                    <option value="regular">Regular</option>
                    <option value="premium">Premium</option>
                    <option value="recording">Recording</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga/Jam</label>
                    <input type="number" name="harga_per_jam" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kapasitas</label>
                    <input type="number" name="kapasitas" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Foto</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
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
    document.getElementById('studioModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('studioModal').style.display = 'none';
}

// Tutup modal kalau klik di luar
window.onclick = function(event) {
    var modal = document.getElementById('studioModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>
@endpush
@endsection