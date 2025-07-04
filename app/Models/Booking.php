<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'service_id',
        'booking_date',
        'pickup_time',
        'delivery_time',
        'status',
        'notes',
        'total_price',
        'payment_status',
        'payment_method',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'pickup_time' => 'datetime',
        'delivery_time' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    protected $dates = [
        'booking_date',
        'pickup_time', 
        'delivery_time',
        'created_at',
        'updated_at'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_PICKED_UP = 'picked_up';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_READY = 'ready';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_REFUNDED = 'refunded';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function getStatusOptions(): array
    {
        return [
            self::STATUS_PENDING => 'Menunggu Konfirmasi',
            self::STATUS_CONFIRMED => 'Dikonfirmasi',
            self::STATUS_PICKED_UP => 'Sudah Diambil',
            self::STATUS_IN_PROGRESS => 'Sedang Dikerjakan',
            self::STATUS_READY => 'Siap Diantar',
            self::STATUS_DELIVERED => 'Sudah Diantar',
            self::STATUS_CANCELLED => 'Dibatalkan',
        ];
    }

    public function getPaymentStatusOptions(): array
    {
        return [
            self::PAYMENT_PENDING => 'Belum Bayar',
            self::PAYMENT_PAID => 'Sudah Bayar',
            self::PAYMENT_REFUNDED => 'Dikembalikan',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->getStatusOptions()[$this->status] ?? ucfirst($this->status);
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return $this->getPaymentStatusOptions()[$this->payment_status] ?? ucfirst($this->payment_status);
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        $methods = [
            'cash' => 'Tunai',
            'transfer' => 'Transfer Bank',
            'e_wallet' => 'E-Wallet',
            'credit_card' => 'Kartu Kredit',
        ];
        
        return $methods[$this->payment_method] ?? ucfirst($this->payment_method);
    }
}