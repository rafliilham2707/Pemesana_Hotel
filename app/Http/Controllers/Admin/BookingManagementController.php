<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingManagementController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

    public function index(Request $request): View
    {
        $status = $request->get('status');
        $search = $request->get('q');

        $query = Booking::with(['hotel.city', 'user', 'roomType'])->latest();

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                    ->orWhere('guest_name', 'like', "%{$search}%")
                    ->orWhere('guest_email', 'like', "%{$search}%")
                    ->orWhereHas('hotel', fn ($hq) => $hq->where('name', 'like', "%{$search}%"));
            });
        }

        $bookings = $query->paginate(15)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking): View
    {
        $booking->load(['hotel.city', 'roomType', 'payment', 'voucher', 'user', 'review']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function confirmPayment(Booking $booking): RedirectResponse
    {
        $this->bookingService->markAsPaid($booking, 'manual_admin');

        return back()->with('status', "Pembayaran untuk pesanan {$booking->booking_code} berhasil dikonfirmasi secara manual.");
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        $this->bookingService->cancelBooking($booking);

        return back()->with('status', "Pesanan {$booking->booking_code} berhasil dibatalkan dan stok kamar telah dikembalikan.");
    }

    public function complete(Booking $booking): RedirectResponse
    {
        $booking->update(['status' => BookingStatus::Completed]);

        return back()->with('status', "Pesanan {$booking->booking_code} telah ditandai selesai.");
    }
}
