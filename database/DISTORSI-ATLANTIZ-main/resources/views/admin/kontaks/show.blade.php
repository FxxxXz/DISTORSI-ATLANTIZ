@extends('layouts.admin')

@section('title', 'Detail Pesan')
@section('page-title', 'Detail Pesan')

@section('content')
<div class="table-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Detail Pesan #{{ $kontak->id }}</h5>
        <a href="{{ route('admin.kontaks') }}" class="btn btn-sm btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="text-muted">Nama</label>
                    <p class="fw-bold">{{ $kontak->nama }}</p>
                </div>
                <div class="col-md-6">
                    <label class="text-muted">Email</label>
                    <p class="fw-bold">{{ $kontak->email }}</p>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="text-muted">Telepon</label>
                    <p class="fw-bold">{{ $kontak->telepon ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <label class="text-muted">Tanggal Kirim</label>
                    <p class="fw-bold">{{ $kontak->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="text-muted">Subjek</label>
                <p class="fw-bold">{{ $kontak->subjek }}</p>
            </div>
            
            <div class="mb-3">
                <label class="text-muted">Status</label>
                <p>
                    @if($kontak->dibaca_pada)
                        <span class="badge bg-success">Sudah Dibaca</span>
                        <small class="text-muted">(dibaca pada {{ $kontak->dibaca_pada->format('d M Y H:i') }} oleh {{ $kontak->reader->nama_lengkap ?? 'Admin' }})</small>
                    @else
                        <span class="badge bg-danger">Belum Dibaca</span>
                    @endif
                </p>
            </div>
            
            <div class="mb-3">
                <label class="text-muted">Pesan</label>
                <div class="p-3 bg-light rounded">
                    {{ $kontak->pesan }}
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <form action="{{ route('admin.kontaks.destroy', $kontak->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pesan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Hapus Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection