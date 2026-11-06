<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View
    {
        $wishlists = $request->user()->wishlists()
            ->with(['hotel.city', 'hotel.coverImage', 'hotel.reviews'])
            ->latest()
            ->paginate(12);

        return view('account.wishlist', compact('wishlists'));
    }

    public function toggle(Hotel $hotel, Request $request): RedirectResponse
    {
        if (! $request->user()) {
            return redirect()->route('login')->with('status', 'Silakan masuk terlebih dahulu untuk menyimpan hotel.');
        }

        $wishlist = Wishlist::where('user_id', $request->user()->id)
            ->where('hotel_id', $hotel->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Hotel dihapus dari wishlist.';
        } else {
            Wishlist::create([
                'user_id' => $request->user()->id,
                'hotel_id' => $hotel->id,
            ]);
            $message = 'Hotel berhasil disimpan ke wishlist!';
        }

        return back()->with('status', $message);
    }
}
