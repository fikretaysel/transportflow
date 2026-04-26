<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalOrders' => Order::count(),
            'activeOrders' => Order::whereNotIn('status', ['completed', 'cancelled'])->count(),
            'completedOrders' => Order::where('status', 'completed')->count(),
            'availableDrivers' => Driver::where('is_available', true)->count(),
            'latestOrders' => Order::with('driver')->latest()->take(5)->get(),
            'delayedOrders' => Order::whereNotIn('status', ['completed', 'cancelled'])
                ->whereNotNull('scheduled_at')
                ->where('scheduled_at', '<', now())
                ->count(),
            ]);
    }
}
