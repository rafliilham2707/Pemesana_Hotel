<?php

use App\Enums\UserRole;
use App\Models\User;

test('admin can access dashboard', function () {
    $admin = User::where('email', 'admin@example.com')->first();

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk()
        ->assertSee('Panel Admin')
        ->assertSee('Total Hotel');
});

test('regular customer cannot access admin dashboard', function () {
    $user = User::where('email', 'user@example.com')->first()
        ?? User::where('role', UserRole::Customer)->first();

    $response = $this->actingAs($user)->get(route('admin.dashboard'));

    $response->assertForbidden();
});
