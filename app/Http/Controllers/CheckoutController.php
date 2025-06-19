<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Keranjang Anda kosong.');
        }

        $customer = Auth::guard('customer')->user();
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

        // Load customer profile untuk rekomendasi
        $customer->load('profile');

        return view('checkout.index', compact(
            'customer',
            'cartItems', 
            'totalAmount',
            'totalCalories',
            'totalProtein',
            'totalCarbs',
            'totalFat'
        ));
    }
}