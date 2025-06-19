<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'diet_type',
        'low_carb',
        'high_protein',
        'low_fat',
        'gluten_free',
        'dairy_free'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
