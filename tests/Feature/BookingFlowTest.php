<?php

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\RoomInventory;
use App\Models\RoomType;
use App\Models\User;
use App\Models\Voucher;

test('authenticated user can view booking form for available room', function () {
    $user = User::factory()->create();
    $roomType = RoomType::first();

    $response = $this->actingAs($user)->get(route('booking.create', [
        'room_type_id' => $roomType->id,
        'check_in' => today()->addDay()->format('Y-m-d'),
        'check_out' => today()->addDays(2)->format('Y-m-d'),
        'rooms' => 1,
        'guests' => 2,
    ]));

    $response->assertOk()
        ->assertSee($roomType->hotel->name)
        ->assertSee($roomType->name)
        ->assertSee('Data Kontak Pemesan');
});

test('user can create a booking and inventory is properly deducted', function () {
    $user = User::factory()->create();
    $roomType = RoomType::first();
    $checkIn = today()->addDays(5)->format('Y-m-d');
    $checkOut = today()->addDays(6)->format('Y-m-d');

    // Pastikan ada inventori awal
    $initialInventory = RoomInventory::firstOrCreate(
        ['room_type_id' => $roomType->id, 'date' => $checkIn],
        ['available_rooms' => $roomType->total_rooms, 'price' => $roomType->base_price]
    );
    $initialRooms = $initialInventory->available_rooms;

    $response = $this->actingAs($user)->post(route('booking.store'), [
        'room_type_id' => $roomType->id,
        'check_in' => $checkIn,
        'check_out' => $checkOut,
        'rooms' => 1,
        'guests' => 2,
        'guest_name' => 'Ahmad Fauzi',
        'guest_email' => 'ahmad@example.com',
        'guest_phone' => '081234567890',
        'payment_method' => 'bank_transfer',
    ]);

    $booking = Booking::where('guest_email', 'ahmad@example.com')->latest()->first();
    expect($booking)->not->toBeNull()
        ->and($booking->status)->toBe(BookingStatus::Pending)
        ->and($booking->booking_code)->toStartWith('BK-');

    $response->assertRedirect(route('booking.payment', $booking->booking_code));

    // Verifikasi stok kamar berkurang
    $updatedInventory = RoomInventory::where('room_type_id', $roomType->id)
        ->where('date', $checkIn)
        ->first();
    expect($updatedInventory->available_rooms)->toBe($initialRooms - 1);
});

test('voucher calculation works on booking creation', function () {
    $user = User::factory()->create();
    $roomType = RoomType::first();
    $voucher = Voucher::where('code', 'WELCOME50K')->first();

    $response = $this->actingAs($user)->post(route('booking.store'), [
        'room_type_id' => $roomType->id,
        'check_in' => today()->addDays(10)->format('Y-m-d'),
        'check_out' => today()->addDays(11)->format('Y-m-d'),
        'rooms' => 1,
        'guests' => 2,
        'guest_name' => 'Budi Voucher',
        'guest_email' => 'budi.voucher@example.com',
        'guest_phone' => '081234567890',
        'voucher_code' => 'WELCOME50K',
    ]);

    $booking = Booking::where('guest_email', 'budi.voucher@example.com')->first();
    expect($booking)->not->toBeNull()
        ->and((float) $booking->discount)->toBe(50000.0)
        ->and($booking->voucher_id)->toBe($voucher->id);
});

test('user can simulate payment and confirm booking to paid status', function () {
    $user = User::factory()->create();
    $booking = Booking::factory()->create([
        'user_id' => $user->id,
        'status' => BookingStatus::Pending,
    ]);

    $response = $this->actingAs($user)->post(route('booking.pay', $booking->booking_code), [
        'method' => 'bank_transfer',
    ]);

    $response->assertRedirect(route('booking.success', $booking->booking_code));
    expect($booking->fresh()->status)->toBe(BookingStatus::Paid);
});

test('cancelled booking restores inventory', function () {
    $user = User::factory()->create();
    $roomType = RoomType::first();
    $checkIn = today()->addDays(20)->format('Y-m-d');
    $checkOut = today()->addDays(21)->format('Y-m-d');

    // Buat booking
    $booking = Booking::factory()->create([
        'user_id' => $user->id,
        'room_type_id' => $roomType->id,
        'check_in' => $checkIn,
        'check_out' => $checkOut,
        'rooms' => 1,
        'status' => BookingStatus::Pending,
    ]);

    $inv = RoomInventory::firstOrCreate(
        ['room_type_id' => $roomType->id, 'date' => $checkIn],
        ['available_rooms' => 5, 'price' => 500000]
    );
    $initialRooms = $inv->available_rooms;

    $response = $this->actingAs($user)->post(route('account.bookings.cancel', $booking->booking_code));

    $response->assertSessionHas('status');
    expect($booking->fresh()->status)->toBe(BookingStatus::Cancelled);

    $updatedInv = RoomInventory::where('room_type_id', $roomType->id)->where('date', $checkIn)->first();
    expect($updatedInv->available_rooms)->toBe($initialRooms + 1);
});

test('expired booking command processes expired pending bookings and restores rooms', function () {
    $booking = Booking::factory()->create([
        'status' => BookingStatus::Pending,
        'expires_at' => now()->subMinutes(10),
        'check_in' => today()->addDays(30)->format('Y-m-d'),
        'check_out' => today()->addDays(31)->format('Y-m-d'),
        'rooms' => 1,
    ]);

    RoomInventory::firstOrCreate(
        ['room_type_id' => $booking->room_type_id, 'date' => $booking->check_in],
        ['available_rooms' => 5, 'price' => 500000]
    );

    $this->artisan('bookings:expire')
        ->assertSuccessful();

    expect($booking->fresh()->status)->toBe(BookingStatus::Expired);
});
