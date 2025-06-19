<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_calories',
        'total_protein',
        'total_carbs',
        'total_fat',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function addNutrition($calories, $protein, $carbs, $fat)
    {
        $this->total_calories += $calories;
        $this->total_protein += $protein;
        $this->total_carbs += $carbs;
        $this->total_fat += $fat;
        $this->save();
    }
}
