<?php

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\City;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->admin = User::where('email', 'admin@example.com')->first();
});

test('admin can view hotels list and create new hotel', function () {
    $city = City::first();

    $response = $this->actingAs($this->admin)->get(route('admin.hotels.index'));
    $response->assertOk()->assertSee('Kelola Hotel');

    $createResponse = $this->actingAs($this->admin)->post(route('admin.hotels.store'), [
        'city_id' => $city->id,
        'name' => 'Hotel Baru Antigravity',
        'description' => 'Deskripsi hotel lengkap dan jelas.',
        'address' => 'Jl. Pengujian No. 123',
        'star_rating' => 4,
        'property_type' => 'hotel',
        'check_in_time' => '14:00',
        'check_out_time' => '12:00',
        'is_active' => true,
    ]);

    $createResponse->assertRedirect(route('admin.hotels.index'));
    expect(Hotel::where('name', 'Hotel Baru Antigravity')->exists())->toBeTrue();
});

test('admin can toggle hotel status', function () {
    $hotel = Hotel::factory()->create(['is_active' => true]);

    $response = $this->actingAs($this->admin)->post(route('admin.hotels.toggle-status', $hotel->id));

    $response->assertSessionHas('status');
    expect($hotel->fresh()->is_active)->toBeFalse();
});

test('admin can create room type and manage daily inventories', function () {
    $hotel = Hotel::first();

    $createRoom = $this->actingAs($this->admin)->post(route('admin.hotels.rooms.store', $hotel->id), [
        'name' => 'Suite Presidential Mewah',
        'description' => 'Kamar termewah',
        'max_guests' => 4,
        'bed_type' => '2 King Bed',
        'size_m2' => 80,
        'base_price' => 2500000,
        'total_rooms' => 5,
    ]);

    $createRoom->assertRedirect(route('admin.hotels.rooms.index', $hotel->id));
    $room = RoomType::where('name', 'Suite Presidential Mewah')->first();
    expect($room)->not->toBeNull();

    // Update bulk inventory
    $invResponse = $this->actingAs($this->admin)->post(route('admin.hotels.rooms.inventories.update', [$hotel->id, $room->id]), [
        'start_date' => today()->format('Y-m-d'),
        'end_date' => today()->addDays(3)->format('Y-m-d'),
        'available_rooms' => 3,
        'price' => 3000000,
    ]);

    $invResponse->assertSessionHas('status');
});

test('admin can confirm payment manually on pending booking', function () {
    $booking = Booking::factory()->create([
        'status' => BookingStatus::Pending,
    ]);

    $response = $this->actingAs($this->admin)->post(route('admin.bookings.confirm-payment', $booking->booking_code));

    $response->assertSessionHas('status');
    expect($booking->fresh()->status)->toBe(BookingStatus::Paid);
});

test('admin can manage vouchers', function () {
    $code = 'PROMO'.strtoupper(Str::random(6));

    $response = $this->actingAs($this->admin)->post(route('admin.vouchers.store'), [
        'code' => $code,
        'type' => 'percent',
        'value' => 25,
        'min_spend' => 500000,
        'max_discount' => 200000,
        'quota' => 100,
        'valid_from' => today()->format('Y-m-d'),
        'valid_until' => today()->addMonths(2)->format('Y-m-d'),
        'is_active' => true,
    ]);

    $response->assertRedirect(route('admin.vouchers.index'));
    expect(Voucher::where('code', $code)->exists())->toBeTrue();
});
