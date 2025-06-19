<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_number',
        'order_type',
        'status',
        'total_amount',
        'special_requests'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // Order type constants
    const TYPE_DINE_IN = 'dine_in';
    const TYPE_TAKE_AWAY = 'take_away';

    // Relasi belongsTo dengan Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi many-to-many dengan Food melalui pivot table order_details
    public function foods()
    {
        return $this->belongsToMany(Food::class, 'order_details')
                    ->withPivot('quantity', 'price', 'customization')
                    ->withTimestamps();
    }

    // Relasi hasMany dengan OrderDetail (tetap dipertahankan untuk backward compatibility)
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Relasi hasOne dengan Payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk filter berdasarkan customer
    public function scopeByCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    // Scope untuk order hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Scope untuk order yang sudah selesai
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    // Method untuk menghitung total kalori dalam order
    public function getTotalCalories()
    {
        $totalCalories = 0;
        foreach ($this->foods as $food) {
            $totalCalories += $food->getTotalCalories($food->pivot->quantity);
        }
        return $totalCalories;
    }

    // Method untuk menghitung total protein dalam order
    public function getTotalProtein()
    {
        $totalProtein = 0;
        foreach ($this->foods as $food) {
            $totalProtein += $food->getTotalProtein($food->pivot->quantity);
        }
        return $totalProtein;
    }

    // Method untuk menghitung total karbohidrat dalam order
    public function getTotalCarbs()
    {
        $totalCarbs = 0;
        foreach ($this->foods as $food) {
            $totalCarbs += $food->getTotalCarbs($food->pivot->quantity);
        }
        return $totalCarbs;
    }

    // Method untuk menghitung total lemak dalam order
    public function getTotalFat()
    {
        $totalFat = 0;
        foreach ($this->foods as $food) {
            $totalFat += $food->getTotalFat($food->pivot->quantity);
        }
        return $totalFat;
    }

    // Method untuk mendapatkan status label yang lebih user-friendly
    public function getStatusLabelAttribute()
    {
        $labels = [
            self::STATUS_PENDING => 'Menunggu',
            self::STATUS_PROCESSING => 'Diproses',
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_CANCELLED => 'Dibatalkan',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    // Method untuk mendapatkan order type label
    public function getOrderTypeLabelAttribute()
    {
        $labels = [
            self::TYPE_DINE_IN => 'Makan di Tempat',
            self::TYPE_TAKE_AWAY => 'Bawa Pulang',
        ];

        return $labels[$this->order_type] ?? $this->order_type;
    }

    // Method untuk mengecek apakah order dapat dibatalkan
    public function canBeCancelled()
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_PROCESSING]);
    }

    // Method untuk mengecek apakah order sudah selesai
    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    // Method untuk mengecek apakah order dibatalkan
    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }
}