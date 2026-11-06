<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoomType>
 */
class RoomTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'hotel_id' => Hotel::factory(),
            'name' => fake()->randomElement(['Superior Room', 'Deluxe Room', 'Executive Suite', 'Premier Ocean View', 'Presidential Villa']),
            'description' => fake('id_ID')->sentence(12),
            'max_guests' => fake()->randomElement([2, 2, 2, 3, 4]),
            'bed_type' => fake()->randomElement(['1 King Bed', '2 Twin Beds', '1 Queen Bed', '2 Double Beds']),
            'size_m2' => fake()->numberBetween(28, 65),
            'base_price' => fake()->randomElement([450000, 650000, 850000, 1250000, 1850000, 2500000]),
            'total_rooms' => fake()->numberBetween(5, 15),
            'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&auto=format&fit=crop',
        ];
    }
}
