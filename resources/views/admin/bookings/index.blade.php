@extends('layouts.admin')

@section('title', 'Kelola Booking')

@section('content')
<div class="container-fluid">
    <div class="row">
        
        <main class="col-md-10 ms-sm-auto px-md-4 py-4">
            <h1>Kelola Booking</h1>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Studio</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->user->nama_lengkap }}</td>
                            <td>{{ $booking->studio->nama }}</td>
                            <td>{{ $booking->tanggal }}</td>
                            <td>
                                <span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : 'success' }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">Belum ada booking</td></tr>
                    @endforelse
                </tbody>
            </table>
        </main>
    </div>
</div>
@endsection