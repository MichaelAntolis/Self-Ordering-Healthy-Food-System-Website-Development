<?php

namespace App\Http\Controllers;

use App\Models\NutritionTracking;
use Illuminate\Http\Request;

class NutritionTrackingController extends Controller
{
    public function addNutrition(Request $request, $customerId)
    {
        $request->validate([
            'calories' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
        ]);

        $nutrition = NutritionTracking::where('customer_id', $customerId)->first();

        if ($nutrition) {
            $nutrition->addNutrition($request->calories, $request->protein, $request->carbs, $request->fat);
            return response()->json(['message' => 'Nutrition data updated successfully.'], 200);
        }

        return response()->json(['message' => 'Customer not found.'], 404);
    }
}
