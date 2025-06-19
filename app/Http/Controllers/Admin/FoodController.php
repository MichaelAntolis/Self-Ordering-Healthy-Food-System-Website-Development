<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::with('category')->paginate(10);
        return view('admin.foods.index', compact('foods'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.foods.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'nutrition_fact' => 'required|string',
            'calories' => 'nullable|numeric|min:0',
            'protein' => 'nullable|numeric|min:0',
            'carbs' => 'nullable|numeric|min:0',
            'fat' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        
        // Harga sudah dalam format rupiah yang benar, tidak perlu konversi

        $data['is_available'] = $request->has('is_available');
        $data['is_vegetarian'] = $request->has('is_vegetarian');
        $data['is_vegan'] = $request->has('is_vegan');
        $data['is_gluten_free'] = $request->has('is_gluten_free');
        $data['is_dairy_free'] = $request->has('is_dairy_free');
        $data['is_low_calorie'] = $request->has('is_low_calorie');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('foods', 'public');
            $data['image'] = $path;
            
            // Copy gambar ke public/storage/foods untuk akses langsung
            $sourcePath = storage_path('app/public/' . $path);
            $targetPath = public_path('storage/' . $path);
            $targetDir = dirname($targetPath);
            
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            
            if (file_exists($sourcePath)) {
                copy($sourcePath, $targetPath);
            }
        }

        Food::create($data);

        return redirect()->route('admin.foods.index')
            ->with('success', 'Food item created successfully');
    }

    public function show(Food $food)
    {
        return view('admin.foods.show', compact('food'));
    }



    public function update(Request $request, Food $food)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'nutrition_fact' => 'required|string',
            'calories' => 'nullable|numeric|min:0',
            'protein' => 'nullable|numeric|min:0',
            'carbs' => 'nullable|numeric|min:0',
            'fat' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        
        // Harga sudah dalam format rupiah yang benar, tidak perlu konversi

        $data['is_available'] = $request->has('is_available');
        $data['is_vegetarian'] = $request->has('is_vegetarian');
        $data['is_vegan'] = $request->has('is_vegan');
        $data['is_gluten_free'] = $request->has('is_gluten_free');
        $data['is_dairy_free'] = $request->has('is_dairy_free');
        $data['is_low_calorie'] = $request->has('is_low_calorie');

        if ($request->hasFile('image')) {
            if ($food->image) {
                Storage::disk('public')->delete($food->image);
                // Hapus juga dari public/storage/foods
                $publicPath = public_path('storage/' . $food->image);
                if (file_exists($publicPath)) {
                    unlink($publicPath);
                }
            }

            $path = $request->file('image')->store('foods', 'public');
            $data['image'] = $path;
            
            // Copy gambar ke public/storage/foods untuk akses langsung
            $sourcePath = storage_path('app/public/' . $path);
            $targetPath = public_path('storage/' . $path);
            $targetDir = dirname($targetPath);
            
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            
            if (file_exists($sourcePath)) {
                copy($sourcePath, $targetPath);
            }
        }
        $food->update($data);

        return redirect()->route('admin.foods.index')
            ->with('success', 'Food item updated successfully');
    }


    public function destroy(Food $food)
    {
        if ($food->image) {
            Storage::disk('public')->delete($food->image);
            // Hapus juga dari public/storage/foods
            $publicPath = public_path('storage/' . $food->image);
            if (file_exists($publicPath)) {
                unlink($publicPath);
            }
        }

        $food->delete();

        return redirect()->route('admin.foods.index')
            ->with('success', 'Food item deleted successfully');
    }
}
