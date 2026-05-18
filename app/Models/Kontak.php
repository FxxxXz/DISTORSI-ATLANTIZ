<?php
// app/Models/Kontak.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    use HasFactory;

    protected $table = 'kontaks';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'subjek',
        'pesan',
        'status',
        'dibaca_pada',
        'dibaca_oleh',
    ];

    protected $casts = [
        'dibaca_pada' => 'datetime',
    ];

    public function reader()
    {
        return $this->belongsTo(User::class, 'dibaca_oleh');
    }
}