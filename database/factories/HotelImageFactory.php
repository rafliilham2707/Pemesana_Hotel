<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\HotelImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HotelImage>
 */
class HotelImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'hotel_id' => Hotel::factory(),
            'path' => fake()->randomElement([
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1000&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1000&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=1000&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1000&auto=format&fit=crop',
            ]),
            'is_cover' => false,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
