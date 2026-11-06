<?php

namespace Database\Factories;

use App\Enums\VoucherType;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Voucher>
 */
class VoucherFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => 'PROMO'.strtoupper(Str::random(5)),
            'name' => 'Diskon Menginap Spesial',
            'type' => VoucherType::Percent,
            'value' => fake()->randomElement([10, 15, 20, 25]),
            'min_spend' => 500000,
            'max_discount' => 200000,
            'quota' => 100,
            'used_count' => 0,
            'valid_from' => Carbon::today()->subDays(5)->format('Y-m-d'),
            'valid_until' => Carbon::today()->addDays(60)->format('Y-m-d'),
            'is_active' => true,
        ];
    }
}
