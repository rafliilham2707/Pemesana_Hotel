<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatus;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Models\Booking;
use App\Models\RoomType;
use App\Models\Voucher;
use App\Services\BookingService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

    public function index(Request $request): View
    {
        $status = $request->get('status');

        $query = $request->user()->bookings()
            ->with(['hotel.city', 'hotel.coverImage', 'roomType', 'payment'])
            ->latest();

        if ($status && in_array($status, ['pending', 'paid', 'cancelled', 'completed', 'expired'])) {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(10)->withQueryString();

        return view('account.bookings', compact('bookings'));
    }

    public function show(Booking $booking, Request $request): View
    {
        if ($booking->user_id !== $request->user()->id && ! $request->user()->isAdmin()) {
            abort(403);
        }

        $booking->load(['hotel.city', 'hotel.coverImage', 'roomType', 'payment', 'voucher']);

        return view('account.booking-detail', compact('booking'));
    }

    public function create(Request $request): View|RedirectResponse
    {
        $request->validate([
            'room_type_id' => ['required', 'exists:room_types,id'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'rooms' => ['required', 'integer', 'min:1', 'max:10'],
            'guests' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $roomType = RoomType::with(['hotel.city', 'facilities'])->findOrFail($request->room_type_id);

        if (! $roomType->checkAvailability($request->check_in, $request->check_out, (int) $request->rooms)) {
            return redirect()->route('hotels.show', $roomType->hotel->slug)
                ->with('error', 'Kamar tidak tersedia untuk tanggal tersebut.');
        }

        $checkIn = $request->check_in;
        $checkOut = $request->check_out;
        $rooms = (int) $request->rooms;
        $guests = (int) $request->guests;

        $nights = Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut));
        $subtotal = $roomType->calculateTotalPrice($checkIn, $checkOut, $rooms);
        $tax = round($subtotal * 0.10);
        $serviceFee = 25000;
        $total = $subtotal + $tax + $serviceFee;

        return view('booking.create', compact('roomType', 'checkIn', 'checkOut', 'nights', 'rooms', 'guests', 'subtotal', 'tax', 'serviceFee', 'total'));
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        try {
            $booking = $this->bookingService->createBooking($request->user(), $request->validated());

            return redirect()->route('booking.payment', $booking->booking_code)
                ->with('status', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran.');
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function payment(Booking $booking, Request $request): View|RedirectResponse
    {
        if ($booking->user_id !== $request->user()->id && ! $request->user()->isAdmin()) {
            abort(403);
        }

        if ($booking->status === BookingStatus::Paid) {
            return redirect()->route('booking.success', $booking->booking_code);
        }

        if (in_array($booking->status, [BookingStatus::Cancelled, BookingStatus::Expired])) {
            return redirect()->route('account.bookings.show', $booking->booking_code)
                ->with('error', 'Pesanan ini sudah tidak berlaku.');
        }

        $booking->load(['hotel.city', 'roomType', 'payment', 'voucher']);

        return view('booking.payment', compact('booking'));
    }

    public function processPayment(Booking $booking, Request $request): RedirectResponse
    {
        if ($booking->user_id !== $request->user()->id && ! $request->user()->isAdmin()) {
            abort(403);
        }

        $method = $request->input('method', 'bank_transfer');
        $this->bookingService->markAsPaid($booking, $method);

        return redirect()->route('booking.success', $booking->booking_code)
            ->with('status', 'Pembayaran berhasil dikonfirmasi!');
    }

    public function success(Booking $booking, Request $request): View
    {
        if ($booking->user_id !== $request->user()->id && ! $request->user()->isAdmin()) {
            abort(403);
        }

        $booking->load(['hotel.city', 'hotel.coverImage', 'roomType', 'payment', 'voucher']);

        return view('booking.success', compact('booking'));
    }

    public function invoice(Booking $booking, Request $request): View
    {
        if ($booking->user_id !== $request->user()->id && ! $request->user()->isAdmin()) {
            abort(403);
        }

        $booking->load(['hotel.city', 'roomType', 'payment', 'voucher']);

        return view('booking.invoice', compact('booking'));
    }

    public function cancel(Booking $booking, Request $request): RedirectResponse
    {
        if ($booking->user_id !== $request->user()->id && ! $request->user()->isAdmin()) {
            abort(403);
        }

        if (! $booking->canBeCancelled()) {
            return back()->with('error', 'Pesanan ini tidak dapat dibatalkan.');
        }

        $this->bookingService->cancelBooking($booking);

        return back()->with('status', 'Pesanan berhasil dibatalkan dan stok kamar dikembalikan.');
    }

    public function checkVoucher(Request $request): JsonResponse
    {
        $request->validate([
            'code' => ['required', 'string'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        $voucher = Voucher::where('code', strtoupper($request->code))
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where(function ($q) {
                $q->whereNull('quota')->orWhere('quota', '>', 0);
            })
            ->first();

        if (! $voucher || ! $voucher->isValidForAmount((float) $request->amount)) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode voucher tidak berlaku atau total transaksi belum memenuhi minimum.',
            ], 422);
        }

        $discount = $voucher->calculateDiscount((float) $request->amount);

        return response()->json([
            'valid' => true,
            'discount' => $discount,
            'formatted_discount' => format_rupiah($discount),
            'voucher_id' => $voucher->id,
            'code' => $voucher->code,
        ]);
    }
}
