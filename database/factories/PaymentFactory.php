<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'method' => PaymentMethod::Midtrans,
            'provider_reference' => 'MIDTRANS-'.strtoupper(Str::random(10)),
            'amount' => 1250000,
            'status' => PaymentStatus::Paid,
            'paid_at' => now(),
            'payload' => ['transaction_status' => 'settlement', 'payment_type' => 'qris'],
        ];
    }
}
