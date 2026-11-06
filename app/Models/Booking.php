<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Carbon\Carbon;
use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_code',
        'user_id',
        'hotel_id',
        'room_type_id',
        'check_in',
        'check_out',
        'nights',
        'rooms',
        'guests',
        'guest_name',
        'guest_email',
        'guest_phone',
        'special_request',
        'subtotal',
        'tax',
        'service_fee',
        'discount',
        'total',
        'voucher_id',
        'status',
        'expires_at',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
            'nights' => 'integer',
            'rooms' => 'integer',
            'guests' => 'integer',
            'subtotal' => 'decimal:2',
            'tax' => 'decimal:2',
            'service_fee' => 'decimal:2',
            'discount' => 'decimal:2',
            'total' => 'decimal:2',
            'status' => BookingStatus::class,
            'expires_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            if (empty($booking->booking_code)) {
                $booking->booking_code = self::generateBookingCode();
            }
        });
    }

    public static function generateBookingCode(): string
    {
        $date = Carbon::now()->format('Ymd');
        $random = strtoupper(Str::random(5));

        return "BK-{$date}-{$random}";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function isPending(): bool
    {
        return $this->status === BookingStatus::Pending;
    }

    public function isPaid(): bool
    {
        return $this->status === BookingStatus::Paid;
    }

    public function isCancelled(): bool
    {
        return $this->status === BookingStatus::Cancelled;
    }

    public function isCompleted(): bool
    {
        return $this->status === BookingStatus::Completed;
    }

    public function isExpired(): bool
    {
        return $this->status === BookingStatus::Expired;
    }

    public function canBeCancelled(): bool
    {
        if ($this->status !== BookingStatus::Paid && $this->status !== BookingStatus::Pending) {
            return false;
        }

        // Must be at least 1 day before check-in date
        return Carbon::today()->lt($this->check_in);
    }

    public function canBeReviewed(): bool
    {
        if ($this->status !== BookingStatus::Completed && $this->status !== BookingStatus::Paid) {
            return false;
        }

        if ($this->review()->exists()) {
            return false;
        }

        return Carbon::today()->gte($this->check_in);
    }
}
