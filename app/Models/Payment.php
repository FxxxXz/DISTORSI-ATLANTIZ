<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    // Constants untuk method pembayaran
    public const METHOD_TRANSFER_BANK = 'transfer_bank';
    public const METHOD_E_WALLET = 'e_wallet';
    public const METHOD_VIRTUAL_ACCOUNT = 'virtual_account';
    public const METHOD_QRIS = 'qris';

    public const METHODS = [
        self::METHOD_TRANSFER_BANK,
        self::METHOD_E_WALLET,
        self::METHOD_VIRTUAL_ACCOUNT,
        self::METHOD_QRIS,
    ];

    // Constants untuk status
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_FAILED = 'failed';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_REFUNDED = 'refunded';

    protected $fillable = [
        'booking_id',
        'user_id',
        'order_id',
        'method',
        'amount',
        'status',
        'payment_proof',
        'paid_at',
        'expired_at',
        'notes',
    ];

    protected $casts = [
        'amount' => 'integer',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function generateOrderId(): string
    {
        return 'DST-' . date('Ymd') . '-' . strtoupper(uniqid());
    }

    public function isExpired(): bool
    {
        return $this->expired_at && now()->greaterThan($this->expired_at);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function markAsPaid(): void
    {
        $this->update([
            'status' => self::STATUS_PAID,
            'paid_at' => now(),
        ]);

        $this->booking->update(['status' => 'confirmed']);
    }

    public function markAsExpired(): void
    {
        $this->update(['status' => self::STATUS_EXPIRED]);
        $this->booking->update(['status' => 'cancelled']);
    }

    public function getMethodLabel(): string
    {
        return match($this->method) {
            self::METHOD_TRANSFER_BANK => 'Transfer Bank',
            self::METHOD_E_WALLET => 'E-Wallet',
            self::METHOD_VIRTUAL_ACCOUNT => 'Virtual Account',
            self::METHOD_QRIS => 'QRIS',
            default => ucfirst(str_replace('_', ' ', $this->method)),
        };
    }
}