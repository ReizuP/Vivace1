<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_users' => User::count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
        ];

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $lowStockProducts = Product::where('stock', '<', 10)->get();

        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
                              ->groupBy('status')
                              ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts', 'ordersByStatus'));
    }
}