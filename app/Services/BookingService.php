<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\RoomInventory;
use App\Models\RoomType;
use App\Models\User;
use App\Models\Voucher;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingService
{
    /**
     * Create a new hotel booking within a database transaction and row-level locks.
     *
     * @param  array<string, mixed>  $data
     *
     * @throws Exception
     */
    public function createBooking(User $user, array $data): Booking
    {
        return DB::transaction(function () use ($user, $data) {
            $roomType = RoomType::with('hotel')->findOrFail($data['room_type_id']);
            $checkIn = Carbon::parse($data['check_in'])->format('Y-m-d');
            $checkOut = Carbon::parse($data['check_out'])->format('Y-m-d');
            $rooms = (int) $data['rooms'];
            $nights = Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut));

            if ($nights <= 0) {
                throw new Exception('Tanggal check-out harus setelah tanggal check-in.');
            }

            // Lock inventory rows for each night
            $period = CarbonPeriod::create($checkIn, Carbon::parse($checkOut)->subDay()->format('Y-m-d'));
            $dailyPrices = [];

            foreach ($period as $date) {
                $dateStr = $date->format('Y-m-d');

                // Get or create inventory row with lock
                $inventory = RoomInventory::where('room_type_id', $roomType->id)
                    ->where('date', $dateStr)
                    ->lockForUpdate()
                    ->first();

                if (! $inventory) {
                    $inventory = RoomInventory::create([
                        'room_type_id' => $roomType->id,
                        'date' => $dateStr,
                        'available_rooms' => $roomType->total_rooms,
                        'price' => $roomType->base_price,
                    ]);
                }

                if ($inventory->available_rooms < $rooms) {
                    throw new Exception("Kamar tidak mencukupi untuk tanggal {$dateStr}. Tersisa: {$inventory->available_rooms} kamar.");
                }

                // Deduct available rooms
                $inventory->decrement('available_rooms', $rooms);
                $dailyPrices[] = (float) $inventory->price;
            }

            // Calculate amounts
            $subtotal = array_sum($dailyPrices) * $rooms;
            $tax = round($subtotal * 0.10); // 10% PB1 Hotel
            $serviceFee = 25000; // Flat Rp 25.000 platform fee
            $discount = 0.0;
            $voucherId = null;

            // Apply voucher if present
            if (! empty($data['voucher_code'])) {
                $voucher = Voucher::where('code', strtoupper($data['voucher_code']))
                    ->where('is_active', true)
                    ->lockForUpdate()
                    ->first();

                if ($voucher && $voucher->isValidForAmount($subtotal)) {
                    $discount = $voucher->calculateDiscount($subtotal);
                    $voucherId = $voucher->id;

                    if ($voucher->quota !== null) {
                        $voucher->decrement('quota', 1);
                    }
                }
            }

            $total = max(0, ($subtotal + $tax + $serviceFee) - $discount);
            $bookingCode = $this->generateUniqueBookingCode();

            $booking = Booking::create([
                'booking_code' => $bookingCode,
                'user_id' => $user->id,
                'hotel_id' => $roomType->hotel_id,
                'room_type_id' => $roomType->id,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'nights' => $nights,
                'rooms' => $rooms,
                'guests' => (int) $data['guests'],
                'guest_name' => $data['guest_name'],
                'guest_email' => $data['guest_email'],
                'guest_phone' => $data['guest_phone'],
                'special_request' => $data['special_request'] ?? null,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'service_fee' => $serviceFee,
                'discount' => $discount,
                'total' => $total,
                'voucher_id' => $voucherId,
                'status' => BookingStatus::Pending,
                'expires_at' => now()->addMinutes(60), // Batas waktu pembayaran 60 menit
            ]);

            // Create initial payment record
            Payment::create([
                'booking_id' => $booking->id,
                'method' => PaymentMethod::tryFrom($data['payment_method'] ?? 'bank_transfer') ?? PaymentMethod::BankTransfer,
                'provider_reference' => 'PAY-'.strtoupper(Str::random(10)),
                'amount' => $total,
                'status' => PaymentStatus::Pending,
            ]);

            return $booking;
        });
    }

    /**
     * Mark booking as paid (simulate payment gateway callback / instant user pay).
     */
    public function markAsPaid(Booking $booking, ?string $method = null): bool
    {
        return DB::transaction(function () use ($booking, $method) {
            if ($booking->status === BookingStatus::Paid) {
                return true;
            }

            $booking->update([
                'status' => BookingStatus::Paid,
            ]);

            $payment = $booking->payment ?? $booking->payments()->latest()->first();
            if ($payment) {
                $payment->update([
                    'status' => PaymentStatus::Paid,
                    'paid_at' => now(),
                    'method' => $method ? (PaymentMethod::tryFrom($method) ?? $payment->method) : $payment->method,
                ]);
            }

            return true;
        });
    }

    /**
     * Cancel booking and restore room inventories.
     */
    public function cancelBooking(Booking $booking, string $reason = 'cancelled'): bool
    {
        return DB::transaction(function () use ($booking, $reason) {
            if (in_array($booking->status, [BookingStatus::Cancelled, BookingStatus::Expired])) {
                return false;
            }

            $newStatus = $reason === 'expired' ? BookingStatus::Expired : BookingStatus::Cancelled;
            $booking->update(['status' => $newStatus]);

            // Restore room inventories
            $period = CarbonPeriod::create($booking->check_in, Carbon::parse($booking->check_out)->subDay()->format('Y-m-d'));

            foreach ($period as $date) {
                $dateStr = $date->format('Y-m-d');
                $inventory = RoomInventory::where('room_type_id', $booking->room_type_id)
                    ->where('date', $dateStr)
                    ->lockForUpdate()
                    ->first();

                if ($inventory) {
                    $inventory->increment('available_rooms', $booking->rooms);
                }
            }

            // Restore voucher quota if used
            if ($booking->voucher_id && $booking->voucher) {
                $booking->voucher->increment('quota', 1);
            }

            // Update payment status
            if ($booking->payment) {
                $booking->payment->update([
                    'status' => $reason === 'expired' ? PaymentStatus::Expired : PaymentStatus::Failed,
                ]);
            }

            return true;
        });
    }

    /**
     * Generate unique booking code format BK-YYYYMMDD-XXXXX.
     */
    protected function generateUniqueBookingCode(): string
    {
        do {
            $code = 'BK-'.date('Ymd').'-'.strtoupper(Str::random(5));
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }
}
