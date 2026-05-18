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

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'unread' => '<span class="badge bg-danger">Belum Dibaca</span>',
            'read' => '<span class="badge bg-warning">Sudah Dibaca</span>',
            'replied' => '<span class="badge bg-success">Dibalas</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function markAsRead(): void
    {
        if (!$this->dibaca_pada) {
            $this->update([
                'status' => 'read',
                'dibaca_pada' => now(),
                'dibaca_oleh' => auth()->id(),
            ]);
        }
    }
}