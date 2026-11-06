<?php

namespace Database\Factories;

use App\Models\RoomInventory;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoomInventory>
 */
class RoomInventoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'room_type_id' => RoomType::factory(),
            'date' => Carbon::today()->addDays(fake()->numberBetween(0, 30))->format('Y-m-d'),
            'available_rooms' => fake()->numberBetween(1, 8),
            'price' => fake()->randomElement([450000, 650000, 850000, 1250000, 1850000]),
        ];
    }
}
