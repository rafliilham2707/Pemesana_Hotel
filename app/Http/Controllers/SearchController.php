<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Facility;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'check_in' => ['nullable', 'date', 'after_or_equal:today'],
            'check_out' => ['nullable', 'date', 'after:check_in'],
            'guests' => ['nullable', 'integer', 'min:1', 'max:20'],
            'rooms' => ['nullable', 'integer', 'min:1', 'max:10'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
            'star_rating' => ['nullable', 'array'],
            'star_rating.*' => ['integer', 'between:1,5'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['integer', 'exists:facilities,id'],
            'property_type' => ['nullable', 'array'],
            'sort' => ['nullable', 'string', 'in:price_asc,price_desc,rating,popular'],
        ]);

        $query = Hotel::with(['city', 'coverImage'])
            ->active()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->withMin('roomTypes', 'base_price');

        // Search by keyword or city
        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhereHas('city', fn ($cq) => $cq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('city')) {
            $query->whereHas('city', fn ($q) => $q->where('slug', $request->city)->orWhere('name', 'like', '%'.$request->city.'%'));
        }

        // Filter by star rating
        if ($request->filled('star_rating')) {
            $query->whereIn('star_rating', $request->star_rating);
        }

        // Filter by facilities
        if ($request->filled('facilities')) {
            foreach ($request->facilities as $facilityId) {
                $query->whereHas('facilities', fn ($q) => $q->where('facilities.id', $facilityId));
            }
        }

        // Filter by property type
        if ($request->filled('property_type')) {
            $query->whereIn('property_type', $request->property_type);
        }

        // Filter by price (via room types)
        if ($request->filled('min_price')) {
            $query->whereHas('roomTypes', fn ($q) => $q->where('base_price', '>=', $request->min_price));
        }

        if ($request->filled('max_price')) {
            $query->whereHas('roomTypes', fn ($q) => $q->where('base_price', '<=', $request->max_price));
        }

        // Sorting
        $sort = $request->get('sort', 'popular');
        match ($sort) {
            'price_asc' => $query->orderBy('room_types_min_base_price', 'asc'),
            'price_desc' => $query->orderBy('room_types_min_base_price', 'desc'),
            'rating' => $query->orderByDesc('reviews_avg_rating'),
            default => $query->orderByDesc('reviews_count'),
        };

        $hotels = $query->paginate(12)->withQueryString();

        $cities = City::orderBy('name')->get();
        $facilities = Facility::where('type', 'hotel')->orderBy('name')->get();

        return view('search', compact('hotels', 'cities', 'facilities'));
    }
}
