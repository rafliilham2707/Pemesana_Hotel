<?php

namespace Database\Factories;

use App\Enums\PropertyType;
use App\Models\City;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Hotel>
 */
class HotelFactory extends Factory
{
    public function definition(): array
    {
        $name = fake('id_ID')->company().' Hotel & Resort';

        return [
            'city_id' => City::factory(),
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(100, 999),
            'description' => fake('id_ID')->paragraphs(3, true),
            'address' => fake('id_ID')->address(),
            'latitude' => fake()->latitude(-8.9, -6.1),
            'longitude' => fake()->longitude(106.5, 115.5),
            'star_rating' => fake()->numberBetween(3, 5),
            'property_type' => fake()->randomElement(PropertyType::cases()),
            'check_in_time' => '14:00',
            'check_out_time' => '12:00',
            'policy' => "1. Check-in mulai pukul 14:00, check-out maksimal pukul 12:00 WIB.\n2. Wajib menunjukkan kartu identitas resmi saat check-in.\n3. Pembatalan gratis hingga H-3 kedatangan.",
            'is_active' => true,
        ];
    }
}
