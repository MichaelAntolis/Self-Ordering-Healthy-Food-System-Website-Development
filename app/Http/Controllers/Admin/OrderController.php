<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\NutritionTracking;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Load relasi menggunakan many-to-many dan hasOne
        $order->load(['customer', 'foods', 'payment']);
        return view('admin.orders.show', compact('order'));
    }



    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        
        $order->update([
            'status' => $request->status
        ]);

        // Jika status berubah menjadi completed, update nutrition tracking
        if ($request->status === Order::STATUS_COMPLETED && $oldStatus !== Order::STATUS_COMPLETED) {
            $this->updateNutritionTracking($order);
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Status pesanan berhasil diperbarui');
    }

    public function destroy(Order $order)
    {
        // Soft delete dengan mengubah status menjadi cancelled
        $order->update(['status' => Order::STATUS_CANCELLED]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan');
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

        // Hitung total nutrisi dari order menggunakan relasi many-to-many
        $totalCalories = 0;
        $totalProtein = 0;
        $totalCarbs = 0;
        $totalFat = 0;

        foreach ($order->foods as $food) {
            $quantity = $food->pivot->quantity;
            $totalCalories += $food->getTotalCalories($quantity);
            $totalProtein += $food->getTotalProtein($quantity);
            $totalCarbs += $food->getTotalCarbs($quantity);
            $totalFat += $food->getTotalFat($quantity);
        }

        $nutritionTracking->addNutrition(
            $totalCalories,
            $totalProtein,
            $totalCarbs,
            $totalFat
        );
    }

    public function updateStatusAjax(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        
        $order->update([
            'status' => $request->status
        ]);

        // Jika status berubah menjadi completed, update nutrition tracking
        if ($request->status === Order::STATUS_COMPLETED && $oldStatus !== Order::STATUS_COMPLETED) {
            $this->updateNutritionTracking($order);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan berhasil diperbarui',
            'status_label' => $order->status_label
        ]);
    }
}