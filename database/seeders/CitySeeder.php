<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            [
                'name' => 'Bali',
                'slug' => 'bali',
                'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800&auto=format&fit=crop',
                'is_popular' => true,
            ],
            [
                'name' => 'Jakarta',
                'slug' => 'jakarta',
                'image' => 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?w=800&auto=format&fit=crop',
                'is_popular' => true,
            ],
            [
                'name' => 'Bandung',
                'slug' => 'bandung',
                'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&auto=format&fit=crop',
                'is_popular' => true,
            ],
            [
                'name' => 'Yogyakarta',
                'slug' => 'yogyakarta',
                'image' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=800&auto=format&fit=crop',
                'is_popular' => true,
            ],
            [
                'name' => 'Surabaya',
                'slug' => 'surabaya',
                'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&auto=format&fit=crop',
                'is_popular' => true,
            ],
            [
                'name' => 'Semarang',
                'slug' => 'semarang',
                'image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=800&auto=format&fit=crop',
                'is_popular' => false,
            ],
            [
                'name' => 'Malang',
                'slug' => 'malang',
                'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&auto=format&fit=crop',
                'is_popular' => false,
            ],
            [
                'name' => 'Lombok',
                'slug' => 'lombok',
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&auto=format&fit=crop',
                'is_popular' => true,
            ],
        ];

        foreach ($cities as $city) {
            City::updateOrCreate(['slug' => $city['slug']], $city);
        }
    }
}
