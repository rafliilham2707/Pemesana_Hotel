<?php

namespace App\Models;

use Database\Factories\RoomInventoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomInventory extends Model
{
    /** @use HasFactory<RoomInventoryFactory> */
    use HasFactory;

    protected $fillable = [
        'room_type_id',
        'date',
        'available_rooms',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'available_rooms' => 'integer',
            'price' => 'decimal:2',
        ];
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }
}
