<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'kapasitas',
        'foto',
        'is_populer',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
