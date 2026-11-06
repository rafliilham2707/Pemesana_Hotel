<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Hotel;
use App\Models\Voucher;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $popularCities = City::withCount(['activeHotels'])
            ->where('is_popular', true)
            ->orderByDesc('active_hotels_count')
            ->take(8)
            ->get();

        $featuredHotels = Hotel::with(['city', 'coverImage', 'reviews'])
            ->active()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->orderByDesc('reviews_avg_rating')
            ->take(8)
            ->get();

        $activeVouchers = Voucher::where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where(function ($q) {
                $q->whereNull('quota')->orWhere('quota', '>', 0);
            })
            ->take(3)
            ->get();

        return view('home', compact('popularCities', 'featuredHotels', 'activeVouchers'));
    }
}
