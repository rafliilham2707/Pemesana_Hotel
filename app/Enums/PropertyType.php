<?php

namespace App\Enums;

enum PropertyType: string
{
    case Hotel = 'hotel';
    case Resort = 'resort';
    case Villa = 'villa';
    case Apartment = 'apartment';

    public function label(): string
    {
        return match ($this) {
            self::Hotel => 'Hotel',
            self::Resort => 'Resort',
            self::Villa => 'Villa',
            self::Apartment => 'Apartemen',
        };
    }
}
