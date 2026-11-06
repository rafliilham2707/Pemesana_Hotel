<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HotelController extends Controller
{
    public function show(string $slug, Request $request): View
    {
        $request->validate([
            'check_in' => ['nullable', 'date', 'after_or_equal:today'],
            'check_out' => ['nullable', 'date', 'after:check_in'],
            'guests' => ['nullable', 'integer', 'min:1', 'max:20'],
            'rooms' => ['nullable', 'integer', 'min:1', 'max:10'],
        ]);

        $hotel = Hotel::with([
            'city',
            'images',
            'coverImage',
            'facilities',
            'roomTypes.facilities',
            'roomTypes.inventories',
        ])
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        $reviews = $hotel->reviews()
            ->with('user')
            ->latest()
            ->paginate(5);

        $avgRating = $hotel->reviews()->avg('rating') ?? 0;
        $reviewCount = $hotel->reviews()->count();

        $checkIn = $request->get('check_in', now()->addDay()->format('Y-m-d'));
        $checkOut = $request->get('check_out', now()->addDays(2)->format('Y-m-d'));
        $guests = (int) $request->get('guests', 2);
        $rooms = (int) $request->get('rooms', 1);

        $isWishlisted = $hotel->isWishlistedBy(auth()->user());

        return view('hotels.show', compact(
            'hotel',
            'reviews',
            'avgRating',
            'reviewCount',
            'checkIn',
            'checkOut',
            'guests',
            'rooms',
            'isWishlisted',
        ));
    }

    public function storeReview(Hotel $hotel, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
            'booking_id' => ['nullable', 'exists:bookings,id'],
        ]);

        // Cek jika ada booking_id, pastikan milik user yang sedang login
        if (! empty($validated['booking_id'])) {
            $booking = Booking::where('id', $validated['booking_id'])
                ->where('user_id', $request->user()->id)
                ->firstOrFail();
        }

        Review::create([
            'user_id' => $request->user()->id,
            'hotel_id' => $hotel->id,
            'booking_id' => $validated['booking_id'] ?? null,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('status', 'Terima kasih atas ulasan Anda!');
    }
}
