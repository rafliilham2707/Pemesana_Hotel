<?php

namespace App\Enums;

enum FacilityType: string
{
    case Hotel = 'hotel';
    case Room = 'room';

    public function label(): string
    {
        return match ($this) {
            self::Hotel => 'Fasilitas Hotel',
            self::Room => 'Fasilitas Kamar',
        };
    }
}
