<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Food;
use App\Models\NutritionTracking;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_type' => 'required|in:dine_in,take_away',
            'special_requests' => 'nullable|string',
            'payment_method' => 'required|in:qris,credit_card,debit_card,e_wallet'
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Keranjang Anda kosong.');
        }

        // Validasi ketersediaan makanan
        foreach ($cart as $id => $details) {
            $food = Food::find($id);
            if (!$food || !$food->is_available) {
                return redirect()->route('cart.index')
                    ->with('error', 'Beberapa item dalam keranjang tidak tersedia.');
            }
        }

        DB::beginTransaction();

        try {
            $customer = Auth::guard('customer')->user();

            // Hitung total amount
            $totalAmount = 0;
            foreach ($cart as $id => $details) {
                $food = Food::find($id);
                if ($food) {
                    $totalAmount += $food->price * $details['quantity'];
                }
            }

            // Buat order
            $order = Order::create([
                'customer_id' => $customer->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'order_type' => $request->order_type,
                'status' => Order::STATUS_PENDING,
                'total_amount' => $totalAmount,
                'special_requests' => $request->special_requests
            ]);

            // Data untuk many-to-many relationship
            $foodOrderData = [];
            $totalCalories = 0;
            $totalProtein = 0;
            $totalCarbs = 0;
            $totalFat = 0;

            foreach ($cart as $id => $details) {
                $food = Food::find($id);
                if ($food) {
                    // Data untuk pivot table menggunakan many-to-many
                    $foodOrderData[$food->id] = [
                        'quantity' => $details['quantity'],
                        'price' => $food->price,
                        'customization' => $details['customization'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];

                    // Hitung total nutrisi
                    $totalCalories += $food->getTotalCalories($details['quantity']);
                    $totalProtein += $food->getTotalProtein($details['quantity']);
                    $totalCarbs += $food->getTotalCarbs($details['quantity']);
                    $totalFat += $food->getTotalFat($details['quantity']);
                }
            }

            // Attach foods to order menggunakan many-to-many relationship
            $order->foods()->attach($foodOrderData);

            // Buat payment
            Payment::create([
                'order_id' => $order->id,
                'method' => $request->payment_method,
                'amount' => $totalAmount,
                'transaction_id' => 'TRX-' . strtoupper(Str::random(10)),
                'status' => 'pending'
            ]);

            DB::commit();

            // Hapus cart
            session()->forget('cart');

            return redirect()->route('orders.status', $order->id)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')
                ->with('error', 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi.');
        }
    }

    public function status(Order $order)
    {
        // Pastikan customer hanya bisa melihat order sendiri
        if ($order->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized access to order');
        }

        // Load relasi menggunakan many-to-many
        $order->load(['customer', 'foods', 'payment']);
        
        return view('orders.status', compact('order'));
    }

    public function show(Order $order)
    {
        // Pastikan customer hanya bisa melihat order sendiri
        if ($order->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized access to order');
        }

        $order->load(['customer', 'foods', 'payment']);
        return view('orders.show', compact('order'));
    }

    public function history()
    {
        $customer = Auth::guard('customer')->user();
        
        $orders = Order::where('customer_id', $customer->id)
            ->with(['foods', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.history', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Jika status berubah menjadi completed, update nutrition tracking
        if ($request->status === Order::STATUS_COMPLETED && $oldStatus !== Order::STATUS_COMPLETED) {
            $this->updateNutritionTracking($order);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan berhasil diperbarui'
        ]);
    }

    protected function updateNutritionTracking(Order $order)
    {
        $nutritionTracking = NutritionTracking::firstOrCreate(
            ['customer_id' => $order->customer_id],
            [
                'total_calories' => 0,
                'total_protein' => 0,
                'total_carbs' => 0,
                'total_fat' => 0,
            ]
        );

        $nutritionTracking->addNutrition(
            $order->getTotalCalories(),
            $order->getTotalProtein(),
            $order->getTotalCarbs(),
            $order->getTotalFat()
        );
    }

    public function cancel(Order $order)
    {
        // Pastikan customer hanya bisa cancel order sendiri
        if ($order->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized access to order');
        }

        if (!$order->canBeCancelled()) {
            return redirect()->back()
                ->with('error', 'Pesanan tidak dapat dibatalkan');
        }

        $order->update(['status' => Order::STATUS_CANCELLED]);

        return redirect()->back()
            ->with('success', 'Pesanan berhasil dibatalkan');
    }
}