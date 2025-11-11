<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Gather dashboard data to keep view thin
        $now = \Carbon\Carbon::now();

        $usersCount = \App\Models\User::count();
        $muasCount = \App\Models\Mua::count();
        $bookingsCount = \App\Models\Booking::count();
        $pendingCount = \App\Models\Booking::where('status', 'pending')->count();

        $last30_users = \App\Models\User::where('created_at', '>=', $now->copy()->subDays(30))->count();
        $prev30_users = \App\Models\User::whereBetween('created_at', [$now->copy()->subDays(60), $now->copy()->subDays(30)])->count();
        $usersCompare = $prev30_users ? round((($last30_users - $prev30_users) / max(1, $prev30_users)) * 100, 1) : null;

        $last30_muas = \App\Models\Mua::where('created_at', '>=', $now->copy()->subDays(30))->count();
        $prev30_muas = \App\Models\Mua::whereBetween('created_at', [$now->copy()->subDays(60), $now->copy()->subDays(30)])->count();
        $muasCompare = $prev30_muas ? round((($last30_muas - $prev30_muas) / max(1, $prev30_muas)) * 100, 1) : null;

        $last30_bookings = \App\Models\Booking::where('created_at', '>=', $now->copy()->subDays(30))->count();
        $prev30_bookings = \App\Models\Booking::whereBetween('created_at', [$now->copy()->subDays(60), $now->copy()->subDays(30)])->count();
        $bookingsCompare = $prev30_bookings ? round((($last30_bookings - $prev30_bookings) / max(1, $prev30_bookings)) * 100, 1) : null;

        $trendStart = $now->copy()->subDays(6)->startOfDay();
        $trendEnd = $now->copy()->endOfDay();
        $trend = \App\Models\Booking::whereBetween('created_at', [$trendStart, $trendEnd])->get()->groupBy(function ($b) {
            return $b->created_at->format('Y-m-d');
        });
        $trendLabels = [];
        $trendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = $now->copy()->subDays($i)->format('Y-m-d');
            $trendLabels[] = \Carbon\Carbon::parse($d)->format('d M');
            $trendData[] = isset($trend[$d]) ? count($trend[$d]) : 0;
        }

        $recentBookings = \App\Models\Booking::with('mua')->latest()->take(6)->get();

        return view('back.dashboard', compact(
            'usersCount',
            'muasCount',
            'bookingsCount',
            'pendingCount',
            'last30_users',
            'prev30_users',
            'usersCompare',
            'last30_muas',
            'prev30_muas',
            'muasCompare',
            'last30_bookings',
            'prev30_bookings',
            'bookingsCompare',
            'trendLabels',
            'trendData',
            'recentBookings'
        ));
    }
}
