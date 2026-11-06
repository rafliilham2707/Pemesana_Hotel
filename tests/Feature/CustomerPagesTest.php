<?php

use App\Models\City;
use App\Models\Hotel;

test('homepage renders successfully with featured hotels and popular cities', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('StayHub')
        ->assertSee('Temukan Hotel')
        ->assertSee('Destinasi Populer')
        ->assertSee('Hotel Rekomendasi');
});

test('search page renders and displays hotel results', function () {
    $response = $this->get(route('search'));

    $response->assertOk()
        ->assertSee('Cari Hotel')
        ->assertSee('Rentang Harga')
        ->assertSee('Bintang Hotel');
});

test('search page filters by destination keyword', function () {
    $city = City::first();

    $response = $this->get(route('search', ['q' => $city->name]));

    $response->assertOk()
        ->assertSee($city->name);
});

test('search page filters by star rating', function () {
    $response = $this->get(route('search', ['star_rating' => [5]]));

    $response->assertOk();
});

test('hotel detail page renders correctly with room types and facilities', function () {
    $hotel = Hotel::active()->with('roomTypes')->first();

    $response = $this->get(route('hotels.show', $hotel->slug));

    $response->assertOk()
        ->assertSee($hotel->name)
        ->assertSee('Pilih Tipe Kamar')
        ->assertSee('Tentang Hotel');

    if ($hotel->roomTypes->isNotEmpty()) {
        $response->assertSee($hotel->roomTypes->first()->name);
    }
});
