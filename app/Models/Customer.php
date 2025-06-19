<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_CUSTOMER = 'customer';
    const ROLE_ADMIN = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'allergies',
        'is_active',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Mutator untuk password
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    // Relasi dengan Order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relasi dengan Profile
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // Relasi dengan NutritionTracking
    public function nutritionTracking()
    {
        return $this->hasOne(NutritionTracking::class);
    }

    // Method untuk update last login
    public function updateLastLogin()
    {
        $this->update(['last_login_at' => now()]);
    }

    // Method untuk mengecek apakah customer aktif
    public function isActive()
    {
        return $this->is_active;
    }

    // Method untuk mendapatkan total orders
    public function getTotalOrdersAttribute()
    {
        return $this->orders()->count();
    }

    // Method untuk mendapatkan total spending
    public function getTotalSpentAttribute()
    {
        return $this->orders()
            ->where('status', Order::STATUS_COMPLETED)
            ->sum('total_amount');
    }

    // Method untuk mendapatkan order terakhir
    public function getLastOrderAttribute()
    {
        return $this->orders()
            ->orderBy('created_at', 'desc')
            ->first();
    }

    // Scope untuk customer aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk customer dengan orders
    public function scopeWithOrders($query)
    {
        return $query->has('orders');
    }

    // Method untuk mendapatkan initial name
    public function getInitialsAttribute()
    {
        $names = explode(' ', $this->name);
        $initials = '';
        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
        }
        return $initials;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }
}
