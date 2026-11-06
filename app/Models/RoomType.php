<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Database\Factories\RoomTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model
{
    /** @use HasFactory<RoomTypeFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hotel_id',
        'name',
        'description',
        'max_guests',
        'bed_type',
        'size_m2',
        'base_price',
        'total_rooms',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'max_guests' => 'integer',
            'size_m2' => 'integer',
            'base_price' => 'decimal:2',
            'total_rooms' => 'integer',
        ];
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'facility_room_type')->withTimestamps();
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(RoomInventory::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if this room type has enough available rooms for all nights in the range.
     */
    public function checkAvailability(string $checkIn, string $checkOut, int $requestedRooms = 1): bool
    {
        $dates = CarbonPeriod::create($checkIn, Carbon::parse($checkOut)->subDay()->format('Y-m-d'));

        foreach ($dates as $date) {
            $dateStr = $date->format('Y-m-d');
            $inventory = $this->inventories()->where('date', $dateStr)->first();

            $available = $inventory ? $inventory->available_rooms : $this->total_rooms;
            if ($available < $requestedRooms) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get minimum available rooms count across the requested date range.
     */
    public function getMinAvailableRooms(string $checkIn, string $checkOut): int
    {
        $dates = CarbonPeriod::create($checkIn, Carbon::parse($checkOut)->subDay()->format('Y-m-d'));
        $min = $this->total_rooms;

        foreach ($dates as $date) {
            $dateStr = $date->format('Y-m-d');
            $inventory = $this->inventories()->where('date', $dateStr)->first();
            $available = $inventory ? $inventory->available_rooms : $this->total_rooms;

            if ($available < $min) {
                $min = $available;
            }
        }

        return max(0, $min);
    }

    /**
     * Calculate total price for the date range based on daily inventories or base price.
     */
    public function calculateTotalPrice(string $checkIn, string $checkOut, int $rooms = 1): float
    {
        $dates = CarbonPeriod::create($checkIn, Carbon::parse($checkOut)->subDay()->format('Y-m-d'));
        $total = 0.0;

        foreach ($dates as $date) {
            $dateStr = $date->format('Y-m-d');
            $inventory = $this->inventories()->where('date', $dateStr)->first();
            $dailyPrice = $inventory ? (float) $inventory->price : (float) $this->base_price;
            $total += $dailyPrice * $rooms;
        }

        return $total;
    }
}
