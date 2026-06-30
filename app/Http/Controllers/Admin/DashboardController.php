<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'products' => Product::query()->count(),
            'orders' => Order::query()->count(),
            'customers' => Customer::query()->count(),
            'pages' => Page::query()->count(),
        ];

        $sales = [
            'total' => (float) Order::query()->sum('total'),
            'pending' => (float) Order::query()->where('status', 'pending')->sum('total'),
            'completed' => (float) Order::query()->where('status', 'completed')->sum('total'),
            'average_order' => (float) Order::query()->avg('total'),
        ];

        $recentOrders = Order::query()
            ->latest()
            ->limit(5)
            ->get();

        $recentProducts = Product::query()
            ->with('category')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'sales', 'recentOrders', 'recentProducts'));
    }
}
