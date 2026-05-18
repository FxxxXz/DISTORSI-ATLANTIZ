@extends('layouts.admin')

@section('title', 'Kelola Kontak')
@section('page-title', 'Kelola Kontak')

@section('content')
<div class="table-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Daftar Pesan Masuk</h5>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Subjek</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kontaks as $kontak)
                <tr>
                    <td>#{{ $kontak->id }}</td>
                    <td>{{ $kontak->nama }}</td>
                    <td>{{ $kontak->email }}</td>
                    <td>{{ $kontak->telepon ?? '-' }}</td>
                    <td>{{ $kontak->subjek }}</td>
                    <td>
                        @if($kontak->status == 'unread' || !$kontak->dibaca_pada)
                            <span class="badge bg-danger">Belum Dibaca</span>
                        @else
                            <span class="badge bg-success">Sudah Dibaca</span>
                        @endif
                    </td>
                    <td>{{ $kontak->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.kontaks.show', $kontak->id) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <form action="{{ route('admin.kontaks.destroy', $kontak->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus pesan ini?')">
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
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Belum ada pesan masuk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($kontaks->hasPages())
    <div class="mt-3">
        {{ $kontaks->links() }}
    </div>
    @endif
</div>
@endsection