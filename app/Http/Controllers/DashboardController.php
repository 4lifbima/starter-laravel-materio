<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\GlobalSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        // User statistics
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        $bannedUsers = User::where('status', 'banned')->count();

        // Users by role
        $usersByRole = Role::withCount('users')->get();

        // Recent activities
        $recentActivities = ActivityLog::with(['causer', 'subject'])
            ->latest()
            ->take(10)
            ->get();

        // User growth data (last 7 days)
        $userGrowth = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Fill missing dates with 0
        $userGrowthData = [];
        $userGrowthLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $userGrowthLabels[] = now()->subDays($i)->format('d M');
            $userGrowthData[] = $userGrowth[$date] ?? 0;
        }

        // Activity by log type (last 30 days)
        $activityByType = ActivityLog::selectRaw('log_name, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('log_name')
            ->get()
            ->pluck('count', 'log_name')
            ->toArray();

        // Monthly activity trend (last 6 months)
        $monthlyActivity = ActivityLog::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $monthlyActivityLabels = [];
        $monthlyActivityData = [];
        foreach ($monthlyActivity as $activity) {
            $monthlyActivityLabels[] = date('M Y', mktime(0, 0, 0, $activity->month, 1, $activity->year));
            $monthlyActivityData[] = $activity->count;
        }

        // Users registered this month vs last month
        $usersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $usersLastMonth = User::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        
        $userGrowthPercentage = $usersLastMonth > 0 
            ? round((($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100, 1)
            : ($usersThisMonth > 0 ? 100 : 0);

        // Today's logins
        $todayLogins = ActivityLog::where('log_name', 'auth')
            ->where('description', 'like', '%logged in%')
            ->whereDate('created_at', today())
            ->count();

        // New users today
        $newUsersToday = User::whereDate('created_at', today())->count();

        return view('content.dashboard.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'bannedUsers',
            'usersByRole',
            'recentActivities',
            'userGrowthLabels',
            'userGrowthData',
            'activityByType',
            'monthlyActivityLabels',
            'monthlyActivityData',
            'usersThisMonth',
            'usersLastMonth',
            'userGrowthPercentage',
            'todayLogins',
            'newUsersToday'
        ));
    }
}
