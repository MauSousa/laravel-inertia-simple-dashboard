<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('users can see products page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('products.index'));
    $response->assertStatus(200);
});

test('users not authenticated can not see products page', function () {
    $response = $this->get(route('products.index'));
    $response->assertRedirect(route('login'));
});

test('to array', function () {
    $product = Product::factory()->create()->refresh();

    expect(array_keys($product->toArray()))
        ->toBe([
            'id',
            'name',
            'description',
            'price',
            'image',
            'created_at',
            'updated_at',
        ]);
});

test('users can see create product page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('products.create'));
    $response->assertStatus(200);
});

test('users not authenticated can not see create product page', function () {
    $response = $this->get(route('products.create'));
    $response->assertRedirect(route('login'));
});
