<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PropertyType;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Facility;
use App\Models\Hotel;
use App\Models\HotelImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HotelController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->get('q');
        $cityId = $request->get('city_id');

        $query = Hotel::with(['city', 'roomTypes'])->withCount(['roomTypes', 'bookings']);

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%");
        }

        if ($cityId) {
            $query->where('city_id', $cityId);
        }

        $hotels = $query->latest()->paginate(10)->withQueryString();
        $cities = City::orderBy('name')->get();

        return view('admin.hotels.index', compact('hotels', 'cities'));
    }

    public function create(): View
    {
        $cities = City::orderBy('name')->get();
        $facilities = Facility::where('type', 'hotel')->orderBy('name')->get();

        return view('admin.hotels.create', compact('cities', 'facilities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'city_id' => ['required', 'exists:cities,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'address' => ['required', 'string', 'max:500'],
            'star_rating' => ['required', 'integer', 'between:1,5'],
            'property_type' => ['required', 'string'],
            'check_in_time' => ['required', 'string'],
            'check_out_time' => ['required', 'string'],
            'policy' => ['nullable', 'string'],
            'cover_image_url' => ['nullable', 'url', 'max:1000'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['exists:facilities,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $hotel = Hotel::create([
            'city_id' => $validated['city_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']).'-'.Str::random(5),
            'description' => $validated['description'],
            'address' => $validated['address'],
            'star_rating' => $validated['star_rating'],
            'property_type' => PropertyType::tryFrom($validated['property_type']) ?? PropertyType::Hotel,
            'check_in_time' => $validated['check_in_time'],
            'check_out_time' => $validated['check_out_time'],
            'policy' => $validated['policy'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Attach facilities
        if (! empty($validated['facilities'])) {
            $hotel->facilities()->sync($validated['facilities']);
        }

        // Add cover image
        $coverUrl = ($validated['cover_image_url'] ?? null) ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&auto=format&fit=crop';
        HotelImage::create([
            'hotel_id' => $hotel->id,
            'path' => $coverUrl,
            'is_cover' => true,
            'sort_order' => 1,
        ]);

        return redirect()->route('admin.hotels.index')->with('status', 'Hotel berhasil ditambahkan.');
    }

    public function edit(Hotel $hotel): View
    {
        $hotel->load(['facilities', 'coverImage']);
        $cities = City::orderBy('name')->get();
        $facilities = Facility::where('type', 'hotel')->orderBy('name')->get();

        return view('admin.hotels.edit', compact('hotel', 'cities', 'facilities'));
    }

    public function update(Request $request, Hotel $hotel): RedirectResponse
    {
        $validated = $request->validate([
            'city_id' => ['required', 'exists:cities,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'address' => ['required', 'string', 'max:500'],
            'star_rating' => ['required', 'integer', 'between:1,5'],
            'property_type' => ['required', 'string'],
            'check_in_time' => ['required', 'string'],
            'check_out_time' => ['required', 'string'],
            'policy' => ['nullable', 'string'],
            'cover_image_url' => ['nullable', 'url', 'max:1000'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['exists:facilities,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $hotel->update([
            'city_id' => $validated['city_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'star_rating' => $validated['star_rating'],
            'property_type' => PropertyType::tryFrom($validated['property_type']) ?? PropertyType::Hotel,
            'check_in_time' => $validated['check_in_time'],
            'check_out_time' => $validated['check_out_time'],
            'policy' => $validated['policy'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        if (isset($validated['facilities'])) {
            $hotel->facilities()->sync($validated['facilities']);
        }

        if (! empty($validated['cover_image_url'])) {
            $cover = $hotel->coverImage ?: $hotel->images()->first();
            if ($cover) {
                $cover->update(['path' => $validated['cover_image_url']]);
            } else {
                HotelImage::create([
                    'hotel_id' => $hotel->id,
                    'path' => $validated['cover_image_url'],
                    'is_cover' => true,
                    'sort_order' => 1,
                ]);
            }
        }

        return redirect()->route('admin.hotels.index')->with('status', 'Hotel berhasil diperbarui.');
    }

    public function destroy(Hotel $hotel): RedirectResponse
    {
        $hotel->delete();

        return redirect()->route('admin.hotels.index')->with('status', 'Hotel berhasil dihapus.');
    }

    public function toggleStatus(Hotel $hotel): RedirectResponse
    {
        $hotel->update(['is_active' => ! $hotel->is_active]);

        return back()->with('status', 'Status hotel berhasil diubah.');
    }
}
