<?php

use App\Enums\BookingStatus;
use App\Enums\UserRole;
use App\Models\Booking;
use App\Models\City;
use App\Models\Facility;
use App\Models\Hotel;
use App\Models\RoomInventory;
use App\Models\RoomType;
use App\Models\User;
use App\Models\Voucher;
use Carbon\Carbon;

test('database has seeded realistic data according to specification', function () {
    expect(City::count())->toBeGreaterThanOrEqual(8)
        ->and(Hotel::count())->toBeGreaterThanOrEqual(30)
        ->and(RoomType::count())->toBeGreaterThanOrEqual(90)
        ->and(RoomInventory::count())->toBeGreaterThanOrEqual(8100)
        ->and(Facility::count())->toBeGreaterThanOrEqual(15)
        ->and(Voucher::count())->toBeGreaterThanOrEqual(4);

    $admin = User::where('email', 'admin@example.com')->first();
    expect($admin)->not->toBeNull()
        ->and($admin->role)->toBe(UserRole::Admin)
        ->and($admin->isAdmin())->toBeTrue();

    $user = User::where('email', 'user@example.com')->first();
    expect($user)->not->toBeNull()
        ->and($user->role)->toBe(UserRole::Customer);
});

test('hotel relationships and scopes work properly', function () {
    $hotel = Hotel::with(['city', 'images', 'coverImage', 'facilities', 'roomTypes'])->first();

    expect($hotel)->not->toBeNull()
        ->and($hotel->city)->toBeInstanceOf(City::class)
        ->and($hotel->images)->not->toBeEmpty()
        ->and($hotel->roomTypes->count())->toBeGreaterThanOrEqual(3)
        ->and($hotel->cover_image_url)->toBeString();
});

test('room type availability check and price calculation work properly', function () {
    $roomType = RoomType::first();
    $today = Carbon::today()->format('Y-m-d');
    $tomorrow = Carbon::today()->addDays(2)->format('Y-m-d');

    expect($roomType->checkAvailability($today, $tomorrow, 1))->toBeTrue()
        ->and($roomType->getMinAvailableRooms($today, $tomorrow))->toBeGreaterThanOrEqual(1)
        ->and($roomType->calculateTotalPrice($today, $tomorrow, 1))->toBeGreaterThan(0);
});

test('voucher calculation works properly for percent and fixed types', function () {
    $percentVoucher = Voucher::where('code', 'STAYHEMAT20')->first();
    expect($percentVoucher)->not->toBeNull()
        ->and($percentVoucher->calculateDiscount(1000000))->toBe(200000.0) // 20% of 1M = 200k
        ->and($percentVoucher->calculateDiscount(2000000))->toBe(250000.0); // capped at max_discount 250k

    $fixedVoucher = Voucher::where('code', 'WELCOME50K')->first();
    expect($fixedVoucher)->not->toBeNull()
        ->and($fixedVoucher->calculateDiscount(500000))->toBe(50000.0);
});

test('booking factory can create valid booking and code', function () {
    $booking = Booking::factory()->create([
        'status' => BookingStatus::Paid,
    ]);

    expect($booking->booking_code)->toStartWith('BK-')
        ->and($booking->hotel)->toBeInstanceOf(Hotel::class)
        ->and($booking->roomType)->toBeInstanceOf(RoomType::class)
        ->and($booking->isPaid())->toBeTrue();
});
