<?php

declare(strict_types=1);

use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('can view users index', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get(route('users.index'));

    $response->assertOk();
});

test('user not authenticated can not create new user', function () {
    $response = $this->get(route('users.index'));

    $response->assertRedirect(route('login'));
});

test('can create new user', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->post(route('users.store'), [
        'name' => 'test user',
        'email' => 'test@hotmail.com',
    ]
    );

    $response->assertRedirect(route('users.index'));

    $this->assertDatabaseHas('users', [
        'name' => 'test user',
        'email' => 'test@hotmail.com',
    ]);
});

test('can not create new user with invalid data', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->post(route('users.store'), [
        'name' => '',
        'email' => 'test@hotmail.com',
    ]
    );

    $response->assertSessionHasErrors('name');
});

test('can not create new user with existing email', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->post(route('users.store'), [
        'name' => 'test user',
        'email' => $user->email,
    ]
    );

    $response->assertSessionHasErrors('email');
});

test('can delete user', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->create();

    $this->actingAs($user);

    $response = $this->delete(route('users.destroy', $user2));

    $response->assertRedirect(route('users.index'));
});
