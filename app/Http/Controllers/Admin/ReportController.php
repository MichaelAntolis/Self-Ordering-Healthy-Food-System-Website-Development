<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Food;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    // 1. Categories with most foods
    public function categoryFoods()
    {
        $categories = Category::withCount('foods')
            ->orderBy('foods_count', 'desc')
            ->get();

        return view('admin.reports.category-foods', compact('categories'));
    }

    // 2. Top customers by order count
    public function topCustomers()
    {
        $customers = Customer::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(10)
            ->get();

        foreach ($customers as $customer) {
            $customer->total_spent = Order::where('customer_id', $customer->id)
                ->where('status', Order::STATUS_COMPLETED)
                ->sum('total_amount');
        }

        return view('admin.reports.top-customers', compact('customers'));
    }

    // 3. Popular foods report - Updated to use many-to-many relationship
    public function popularFoods()
    {
        $popularFoods = Food::select([
                'food.id',
                'food.name',
                'food.price',
                'food.category_id',
                'categories.name as category_name'
            ])
            ->leftJoin('categories', 'food.category_id', '=', 'categories.id')
            ->withCount([
                'orders as total_orders' => function ($query) {
                    $query->where('orders.status', Order::STATUS_COMPLETED);
                }
            ])
            ->withSum([
                'orders as total_quantity' => function ($query) {
                    $query->where('orders.status', Order::STATUS_COMPLETED);
                }
            ], 'order_details.quantity')
            ->having('total_orders', '>', 0)
            ->orderBy('total_quantity', 'desc')
            ->take(20)
            ->get();

        // Alternative approach using raw query for better performance
        $popularFoodsAlternative = DB::table('food')
            ->select([
                'food.id',
                'food.name',
                'food.price',
                'categories.name as category_name',
                DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
                DB::raw('SUM(order_details.quantity) as total_quantity'),
                DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue')
            ])
            ->leftJoin('order_details', 'food.id', '=', 'order_details.food_id')
            ->leftJoin('orders', 'order_details.order_id', '=', 'orders.id')
            ->leftJoin('categories', 'food.category_id', '=', 'categories.id')
            ->where('orders.status', Order::STATUS_COMPLETED)
            ->groupBy('food.id', 'food.name', 'food.price', 'categories.name')
            ->orderBy('total_quantity', 'desc')
            ->take(20)
            ->get();

        return view('admin.reports.popular-foods', compact('popularFoodsAlternative'), ['popularFoods' => $popularFoodsAlternative]);
    }

    // 4. Sales report by date range
    public function sales(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        $dailySales = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as order_count'),
            DB::raw('SUM(total_amount) as total_amount')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', Order::STATUS_COMPLETED)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalSales = $dailySales->sum('total_amount');
        $totalOrders = $dailySales->sum('order_count');
        $averageOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        // Additional metrics
        $topSellingFoods = DB::table('food')
            ->select([
                'food.name',
                DB::raw('SUM(order_details.quantity) as total_sold'),
                DB::raw('SUM(order_details.quantity * order_details.price) as revenue')
            ])
            ->join('order_details', 'food.id', '=', 'order_details.food_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', Order::STATUS_COMPLETED)
            ->groupBy('food.id', 'food.name')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();

        return view('admin.reports.sales', compact(
            'dailySales',
            'startDate',
            'endDate',
            'totalSales',
            'totalOrders',
            'averageOrderValue',
            'topSellingFoods'
        ));
    }

    // 5. Payment statistics report
    public function paymentStats()
    {
        $paymentStats = Payment::select(
            'method',
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(amount) as total_amount')
        )
            ->where('status', 'completed')
            ->groupBy('method')
            ->get();

        $totalPayments = $paymentStats->sum('count');
        $totalAmount = $paymentStats->sum('total_amount');

        foreach ($paymentStats as $stat) {
            $stat->percentage = $totalPayments > 0 ? ($stat->count / $totalPayments) * 100 : 0;
        }

        return view('admin.reports.payment-stats', compact('paymentStats', 'totalPayments', 'totalAmount'));
    }

    // 6. New: Nutrition Analytics Report
    public function nutritionAnalytics()
    {
        $nutritionData = DB::table('orders')
            ->select([
                DB::raw('DATE(orders.created_at) as date'),
                DB::raw('AVG(food.calories * order_details.quantity) as avg_calories'),
                DB::raw('AVG(food.protein * order_details.quantity) as avg_protein'),
                DB::raw('AVG(food.carbs * order_details.quantity) as avg_carbs'),
                DB::raw('AVG(food.fat * order_details.quantity) as avg_fat')
            ])
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('food', 'order_details.food_id', '=', 'food.id')
            ->where('orders.status', Order::STATUS_COMPLETED)
            ->whereBetween('orders.created_at', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.reports.nutrition-analytics', compact('nutritionData'));
    }

    // 7. New: Customer Preferences Report
    public function customerPreferences()
    {
        $preferences = DB::table('food')
            ->select([
                'food.name',
                DB::raw('COUNT(CASE WHEN food.is_vegetarian = 1 THEN 1 END) as vegetarian_orders'),
                DB::raw('COUNT(CASE WHEN food.is_vegan = 1 THEN 1 END) as vegan_orders'),
                DB::raw('COUNT(CASE WHEN food.is_gluten_free = 1 THEN 1 END) as gluten_free_orders'),
                DB::raw('COUNT(CASE WHEN food.is_dairy_free = 1 THEN 1 END) as dairy_free_orders'),
                DB::raw('COUNT(CASE WHEN food.is_low_calorie = 1 THEN 1 END) as low_calorie_orders')
            ])
            ->join('order_details', 'food.id', '=', 'order_details.food_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', Order::STATUS_COMPLETED)
            ->groupBy('food.id', 'food.name')
            ->get();

        return view('admin.reports.customer-preferences', compact('preferences'));
    }
}