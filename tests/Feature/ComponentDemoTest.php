<?php

test('it renders the component showcase page successfully', function () {
    $response = $this->get('/demo-components');

    $response->assertStatus(200);
    $response->assertSee('StayHub');
    $response->assertSee('Katalog Komponen UI Hotel Booking');
    $response->assertSee('Tahap 1 Selesai');
    $response->assertSee('Rp 1.250.000');
    $response->assertSee('Padma Hotel Bandung');
    $response->assertSee('Pilih tanggal check-in');
});

test('it renders the home page route successfully', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('StayHub');
});
