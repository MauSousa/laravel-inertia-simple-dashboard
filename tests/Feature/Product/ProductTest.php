<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('users can see products page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/products');
    $response->assertStatus(200);
});

test('users not authenticated can not see products page', function () {
    $response = $this->get('/products');
    $response->assertRedirect('/login');
});
