<?php
// app/Models/Booking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'studio_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'durasi',
        'total_harga',
        'status',
        'catatan',
        'alasan_pembatalan',
        'dibatalkan_pada',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
        'dibatalkan_pada' => 'datetime',
    ];

    // Scopes
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('tanggal', today());
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->whereDate('tanggal', '>=', today());
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    // Accessors
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'confirmed' => '<span class="badge bg-success">Confirmed</span>',
            'completed' => '<span class="badge bg-info">Completed</span>',
            'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getFormattedTotalHargaAttribute(): string
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }
}