<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'food';

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'nutrition_fact',
        'calories',
        'protein',
        'carbs',
        'fat',
        'is_vegetarian',
        'is_vegan',
        'is_dairy_free',
        'is_gluten_free',
        'is_low_calorie',
        'is_available',
        'image',
    ];

    protected $casts = [
        'is_vegetarian' => 'boolean',
        'is_vegan' => 'boolean',
        'is_dairy_free' => 'boolean',
        'is_gluten_free' => 'boolean',
        'is_low_calorie' => 'boolean',
        'is_available' => 'boolean',
        'price' => 'decimal:2',
        'calories' => 'decimal:2',
        'protein' => 'decimal:2',
        'carbs' => 'decimal:2',
        'fat' => 'decimal:2',
    ];

    // Relasi belongsTo dengan Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi many-to-many dengan Order melalui pivot table order_details
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details')
                    ->withPivot('quantity', 'price', 'customization')
                    ->withTimestamps();
    }

    // Relasi hasMany dengan OrderDetail (tetap dipertahankan untuk backward compatibility)
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Accessor untuk mendapatkan URL gambar
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/no-image.png');
        }
        
        // Langsung gunakan path ke storage dengan .htaccess redirect
        return asset('storage/' . $this->image);
    }

    // Scope untuk filter makanan yang tersedia
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    // Scope untuk filter berdasarkan kategori
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Method untuk mendapatkan total kalori berdasarkan quantity
    public function getTotalCalories($quantity = 1)
    {
        return $this->calories * $quantity;
    }

    // Method untuk mendapatkan total protein berdasarkan quantity
    public function getTotalProtein($quantity = 1)
    {
        return $this->protein * $quantity;
    }

    // Method untuk mendapatkan total karbohidrat berdasarkan quantity
    public function getTotalCarbs($quantity = 1)
    {
        return $this->carbs * $quantity;
    }

    // Method untuk mendapatkan total lemak berdasarkan quantity
    public function getTotalFat($quantity = 1)
    {
        return $this->fat * $quantity;
    }
}