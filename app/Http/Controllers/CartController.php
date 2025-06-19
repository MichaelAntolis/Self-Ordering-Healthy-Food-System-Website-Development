<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $totalAmount = 0;
        $totalCalories = 0;
        $totalProtein = 0;
        $totalCarbs = 0;
        $totalFat = 0;

        foreach ($cart as $id => $details) {
            $food = Food::find($id);
            if ($food) {
                $quantity = $details['quantity'];
                $subtotal = $food->price * $quantity;
                
                $cartItems[] = [
                    'food' => $food,
                    'quantity' => $quantity,
                    'customization' => $details['customization'] ?? '',
                    'subtotal' => $subtotal
                ];
                
                $totalAmount += $subtotal;
                $totalCalories += $food->getTotalCalories($quantity);
                $totalProtein += $food->getTotalProtein($quantity);
                $totalCarbs += $food->getTotalCarbs($quantity);
                $totalFat += $food->getTotalFat($quantity);
            }
        }

        return view('cart.index', compact(
            'cartItems', 
            'totalAmount',
            'totalCalories',
            'totalProtein',
            'totalCarbs',
            'totalFat'
        ));
    }

    public function add(Request $request)
    {
        $request->validate([
            'food_id' => 'required|exists:food,id',
            'quantity' => 'required|integer|min:1|max:10',
            'customization' => 'nullable|string|max:500'
        ]);

        $food = Food::findOrFail($request->food_id);

        // Cek ketersediaan makanan
        if (!$food->is_available) {
            return redirect()->back()->with('error', 'Maaf, makanan ini sedang tidak tersedia.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$request->food_id])) {
            // Jika sudah ada, tambahkan quantity
            $cart[$request->food_id]['quantity'] += $request->quantity;
            $cart[$request->food_id]['customization'] = $request->customization;
        } else {
            // Jika belum ada, buat entry baru
            $cart[$request->food_id] = [
                'quantity' => $request->quantity,
                'customization' => $request->customization
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', "{$food->name} berhasil ditambahkan ke keranjang!");
    }

    public function update(Request $request)
    {
        $request->validate([
            'food_id' => 'required|exists:food,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->food_id])) {
            $cart[$request->food_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            
            // Check if request expects JSON (for AJAX calls)
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Jumlah item berhasil diperbarui'
                ]);
            }
            
            // For regular form submissions, redirect back
            return redirect()->route('cart.index')->with('success', 'Jumlah item berhasil diperbarui');
        }

        // Check if request expects JSON (for AJAX calls)
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan dalam keranjang'
            ]);
        }
        
        // For regular form submissions, redirect back with error
        return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan dalam keranjang');
    }

    public function remove(Request $request)
    {
        try {
            $request->validate([
                'food_id' => 'required|exists:food,id',
            ]);

            $cart = session()->get('cart', []);
            $foodId = $request->food_id;

            if (isset($cart[$foodId])) {
                unset($cart[$foodId]);
                session()->put('cart', $cart);
                
                if ($request->ajax() || $request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Item berhasil dihapus dari keranjang',
                        'cart_count' => count($cart)
                    ], 200);
                }
                
                return redirect()->route('cart.index')
                    ->with('success', 'Item berhasil dihapus dari keranjang');
            }

            // Item tidak ada, tapi anggap sukses karena hasil sama
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item berhasil dihapus dari keranjang',
                    'cart_count' => count($cart)
                ], 200);
            }

            return redirect()->route('cart.index')
                ->with('success', 'Item berhasil dihapus dari keranjang');

        } catch (\Exception $e) {
            //Log::error('Cart remove error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus item'
                ], 500);
            }

            return redirect()->route('cart.index')
                ->with('error', 'Terjadi kesalahan saat menghapus item');
        }
    }

    public function clear()
    {
        session()->forget('cart');
        
        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan');
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        $count = 0;
        
        foreach ($cart as $details) {
            $count += $details['quantity'];
        }
        
        return response()->json(['count' => $count]);
    }
}