<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;



class DashboardController extends Controller
{
    public function index()
{
    // 1. Widgets (existing)
    $totalProperties      = Property::count();
    $activeProperties     = Property::where('verified', 1)->count();
    $inactiveProperties   = Property::where('verified', 0)->count();
    $totalUsers           = User::count();
    $totalTransactions    = \App\Models\Transaction::count();
    $totalRevenue         = \App\Models\Transaction::sum('amount');
    $newUsersThisMonth    = User::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count();
    $pendingApprovals     = Property::where('verified', 0)->count();

    // 2. Properties Added Per Month (Bar Chart)
    $monthlyProperties = Property::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->whereYear('created_at', now()->year)
        ->groupBy('month')
        ->pluck('count', 'month')->toArray();

    $months = [];
    $propertyCounts = [];
    for ($i = 1; $i <= 12; $i++) {
        $months[] = date('M', mktime(0, 0, 0, $i, 10));
        $propertyCounts[] = $monthlyProperties[$i] ?? 0;
    }

    // 3. Active vs Inactive (Doughnut Chart)
    $active = Property::where('verified', 1)->count();
    $inactive = Property::where('verified', 0)->count();

    return view('admin.dashboard', [
        // Widgets
        'totalProperties'    => $totalProperties,
        'activeProperties'   => $activeProperties,
        'inactiveProperties' => $inactiveProperties,
        'totalUsers'         => $totalUsers,
        'totalTransactions'  => $totalTransactions,
        'totalRevenue'       => $totalRevenue,
        'newUsersThisMonth'  => $newUsersThisMonth,
        'pendingApprovals'   => $pendingApprovals,
        // Charts
        'months'             => $months,
        'propertyCounts'     => $propertyCounts,
        'active'             => $active,
        'inactive'           => $inactive,
    ]);
}

    public function notifications()
    {
        $notifications = DatabaseNotification::orderByDesc('created_at')->limit(100)->get();
        return view('admin.notifications', compact('notifications'));
    }


}
