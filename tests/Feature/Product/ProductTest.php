<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\assertDatabaseHas;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

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

test('users can see show product page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create();

    $response = $this->get(route('products.show', $product));
    $response->assertStatus(200);
});

test('users not authenticated can not see show product page', function () {
    $product = Product::factory()->create();

    $response = $this->get(route('products.show', $product));
    $response->assertRedirect(route('login'));
});

test('users can see edit product page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create();

    $response = $this->get(route('products.edit', $product));
    $response->assertStatus(200);
});

test('users not authenticated can not see edit product page', function () {
    $product = Product::factory()->create();

    $response = $this->get(route('products.edit', $product));
    $response->assertRedirect(route('login'));
});

test('users can create product with image', function () {

    Storage::fake('products');

    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('products.store'), [
        'name' => 'test',
        'description' => 'test',
        'price' => 100,
        'image' => UploadedFile::fake()->image('photo1.jpg'),
    ]);

    $product = Product::latest()->first();

    /* Storage::disk('products')->assertExists($product->image); */
    assertDatabaseHas('products', [
        'name' => 'test',
        'description' => 'test',
        'price' => 100,
        'image' => $product->image,
    ]);
    $response->assertRedirect(route('products.index'));
});

test('can create product without image', function () {

    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('products.store'), [
        'name' => 'test',
        'description' => 'test',
        'price' => 100,
    ]);

    assertDatabaseHas('products', [
        'name' => 'test',
        'description' => 'test',
        'price' => 100,
    ]);
    $response->assertRedirect(route('products.index'));
});

test('can not create product without name', function () {

    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('products.store'), [
        'description' => 'test',
        'price' => 100,
    ]);

    $response->assertSessionHasErrors('name');
});

test('can not create a product with an invalid image type', function () {

    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('products.store'), [
        'name' => 'test',
        'description' => 'test',
        'price' => 100,
        'image' => UploadedFile::fake()->create('photo1.pdf'),
    ]);

    $response->assertSessionHasErrors('image');
});
