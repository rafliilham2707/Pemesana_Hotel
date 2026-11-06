<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    public function definition(): array
    {
        $checkIn = Carbon::today()->addDays(fake()->numberBetween(1, 14));
        $nights = fake()->numberBetween(1, 3);
        $checkOut = (clone $checkIn)->addDays($nights);
        $subtotal = 1250000 * $nights;
        $tax = $subtotal * 0.10;
        $serviceFee = 25000;
        $total = $subtotal + $tax + $serviceFee;

        return [
            'booking_code' => Booking::generateBookingCode(),
            'user_id' => User::factory(),
            'hotel_id' => Hotel::factory(),
            'room_type_id' => RoomType::factory(),
            'check_in' => $checkIn->format('Y-m-d'),
            'check_out' => $checkOut->format('Y-m-d'),
            'nights' => $nights,
            'rooms' => 1,
            'guests' => 2,
            'guest_name' => fake('id_ID')->name(),
            'guest_email' => fake()->safeEmail(),
            'guest_phone' => '08'.fake()->numerify('##########'),
            'special_request' => fake()->optional()->sentence(),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'service_fee' => $serviceFee,
            'discount' => 0,
            'total' => $total,
            'voucher_id' => null,
            'status' => BookingStatus::Paid,
            'expires_at' => now()->addMinutes(60),
        ];
    }
}
