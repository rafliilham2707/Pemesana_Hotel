<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Cancelled = 'cancelled';
    case Completed = 'completed';
    case Expired = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu Pembayaran',
            self::Paid => 'Dikonfirmasi',
            self::Cancelled => 'Dibatalkan',
            self::Completed => 'Selesai',
            self::Expired => 'Kedaluwarsa',
        };
    }

    public function badgeVariant(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Paid => 'success',
            self::Cancelled => 'destructive',
            self::Completed => 'info',
            self::Expired => 'secondary',
        };
    }
}
