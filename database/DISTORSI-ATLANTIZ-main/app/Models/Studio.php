<?php
// app/Models/Studio.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Studio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'tipe',
        'deskripsi',
        'fasilitas',
        'harga_per_jam',
        'harga_per_sesi',
        'durasi_sesi',
        'kapasitas',
        'foto',
        'is_aktif',
        'is_populer',
        'is_best_value',
    ];

    protected $casts = [
        'fasilitas' => 'array',
        'harga_per_jam' => 'decimal:2',
        'harga_per_sesi' => 'decimal:2',
        'is_aktif' => 'boolean',
        'is_populer' => 'boolean',
        'is_best_value' => 'boolean',
    ];

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($studio) {
            if (empty($studio->slug)) {
                $studio->slug = Str::slug($studio->nama);
            }
        });
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getFasilitasListAttribute(): array
    {
        return $this->fasilitas ?? [];
    }

    public function getFormattedHargaAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_per_jam, 0, ',', '.') . '/jam';
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : asset('img/studio-default.jpg');
    }

    public function getIsAvailableAttribute(): bool
    {
        return $this->is_aktif;
    }
}