<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Food;
use App\Models\Customer;
use App\Models\Category;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalCustomers = Customer::count();
        $totalFoods = Food::count();
        $totalCategories = Category::count();

        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();

        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');

        $latestOrders = Order::with('customer')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $popularFoods = Food::withCount(['orders as total_ordered' => function ($query) {
            $query->where('status', 'completed');
        }])
            ->orderBy('total_ordered', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalCustomers',
            'totalFoods',
            'totalCategories',
            'todayOrders',
            'totalRevenue',
            'latestOrders',
            'popularFoods'
        ));
    }
}
