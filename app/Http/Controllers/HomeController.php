<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Food;

class HomeController extends Controller
{
    public function index()
    {
        $featuredFoods = Food::where('is_available', true)
            ->take(6)
            ->get();
        $categories = Category::all();

        return view('home', compact('featuredFoods', 'categories'));
    }
}
