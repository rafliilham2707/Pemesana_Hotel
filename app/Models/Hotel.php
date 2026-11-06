<?php

namespace App\Models;

use App\Enums\PropertyType;
use Database\Factories\HotelFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Hotel extends Model
{
    /** @use HasFactory<HotelFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'city_id',
        'name',
        'slug',
        'description',
        'address',
        'latitude',
        'longitude',
        'star_rating',
        'property_type',
        'check_in_time',
        'check_out_time',
        'policy',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'star_rating' => 'integer',
            'property_type' => PropertyType::class,
            'is_active' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Hotel $hotel) {
            if (empty($hotel->slug)) {
                $hotel->slug = Str::slug($hotel->name).'-'.Str::random(5);
            }
        });
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(HotelImage::class)->orderBy('sort_order');
    }

    public function coverImage(): HasOne
    {
        return $this->hasOne(HotelImage::class)->where('is_cover', true);
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'facility_hotel')->withTimestamps();
    }

    public function roomTypes(): HasMany
    {
        return $this->hasMany(RoomType::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }

    public function isWishlistedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->wishlists()->where('user_id', $user->id)->exists();
    }

    public function getCoverImageUrlAttribute(): string
    {
        if ($this->relationLoaded('coverImage') && $this->coverImage) {
            return $this->coverImage->path;
        }

        if ($this->relationLoaded('images') && $this->images->isNotEmpty()) {
            return $this->images->first()->path;
        }

        $cover = $this->images()->where('is_cover', true)->first();

        return $cover ? $cover->path : ($this->images()->first()?->path ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&auto=format&fit=crop');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
