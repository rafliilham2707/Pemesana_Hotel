<?php

namespace Database\Seeders;

use App\Enums\FacilityType;
use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            // Fasilitas Hotel
            ['name' => 'WiFi Gratis', 'icon' => 'wifi', 'type' => FacilityType::Hotel],
            ['name' => 'Kolam Renang', 'icon' => 'waves', 'type' => FacilityType::Hotel],
            ['name' => 'Restoran', 'icon' => 'utensils', 'type' => FacilityType::Hotel],
            ['name' => 'Pusat Kebugaran (Gym)', 'icon' => 'dumbbell', 'type' => FacilityType::Hotel],
            ['name' => 'Tempat Parkir Gratis', 'icon' => 'car', 'type' => FacilityType::Hotel],
            ['name' => 'Resepsionis 24 Jam', 'icon' => 'clock', 'type' => FacilityType::Hotel],
            ['name' => 'Sarapan Gratis', 'icon' => 'coffee', 'type' => FacilityType::Hotel],
            ['name' => 'Spa & Pijat', 'icon' => 'sparkles', 'type' => FacilityType::Hotel],

            // Fasilitas Kamar
            ['name' => 'AC (Air Conditioning)', 'icon' => 'wind', 'type' => FacilityType::Room],
            ['name' => 'Smart TV', 'icon' => 'tv', 'type' => FacilityType::Room],
            ['name' => 'Kamar Mandi Pribadi & Bathtub', 'icon' => 'bath', 'type' => FacilityType::Room],
            ['name' => 'Pembuat Teh & Kopi', 'icon' => 'coffee', 'type' => FacilityType::Room],
            ['name' => 'Balkon Pribadi', 'icon' => 'compass', 'type' => FacilityType::Room],
            ['name' => 'Brankas Kamar', 'icon' => 'shield-check', 'type' => FacilityType::Room],
            ['name' => 'Mini Kulkas', 'icon' => 'hotel', 'type' => FacilityType::Room],
        ];

        foreach ($facilities as $facility) {
            Facility::firstOrCreate(['name' => $facility['name']], $facility);
        }
    }
}
