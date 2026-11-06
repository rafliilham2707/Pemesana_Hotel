<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalHotels = Hotel::count();
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('status', 'paid')->sum('total');
        $totalUsers = User::count();

        $recentBookings = Booking::with(['user', 'hotel', 'roomType'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalHotels',
            'totalBookings',
            'totalRevenue',
            'totalUsers',
            'recentBookings'
        ));
    }
}
