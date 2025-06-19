<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Category;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Food::where('is_available', true);

        if ($request->has('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('vegetarian') && $request->vegetarian) {
            $query->where('is_vegetarian', true);
        }

        if ($request->has('vegan') && $request->vegan) {
            $query->where('is_vegan', true);
        }

        if ($request->has('gluten_free') && $request->gluten_free) {
            $query->where('is_gluten_free', true);
        }

        if ($request->has('dairy_free') && $request->dairy_free) {
            $query->where('is_dairy_free', true);
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'calories_low':
                    $query->orderBy('calories', 'asc');
                    break;
                case 'protein_high':
                    $query->orderBy('protein', 'desc');
                    break;
                default:
                    $query->orderBy('name', 'asc');
            }
        } else {
            $query->orderBy('name', 'asc');
        }

        $foods = $query->paginate(12);
        $categories = Category::all();

        return view('menu.index', compact('foods', 'categories'));
    }


    public function show(Food $food)
    {
        $similarFoods = Food::where('category_id', $food->category_id)
            ->where('id', '!=', $food->id)
            ->where('is_available', true)
            ->take(4)
            ->get();

        return view('menu.show', compact('food', 'similarFoods'));
    }
}
