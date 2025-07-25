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

test('can create product with image', function () {

    Storage::fake('products');

    $user = User::factory()->create();
    $this->actingAs($user);

    $file = UploadedFile::fake()->image('photo1.jpg', 500, 500)->size(1024);

    $response = $this->post(route('products.store'), [
        'name' => 'test',
        'description' => 'test',
        'price' => 100,
        'image' => $file,
    ]);

    $product = Product::latest()->first();

    Storage::disk('products')->assertExists($product->image);
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

test('can not create product with invalid price', function () {

    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('products.store'), [
        'name' => 'test',
        'description' => 'test',
        'price' => -100,
    ]);

    $response->assertSessionHasErrors('price');
});

test('can not create product if not authenticated', function () {

    $response = $this->post(route('products.store'), [
        'name' => 'test',
        'description' => 'test',
        'price' => 100,
    ]);

    $response->assertRedirect(route('login'));
});

test('can update product with new image', function () {
    Storage::fake('products');

    $user = User::factory()->create();
    $product = Product::factory()->create();

    $this->actingAs($user);

    $file = UploadedFile::fake()->image('photo1.jpg', 500, 500)->size(1024);

    $response = $this->patch(route('products.update', $product), [
        'name' => 'test',
        'description' => 'test',
        'price' => 100,
        'image' => $file,
    ]);

    $product = Product::latest()->first();

    Storage::disk('products')->assertExists($product->image);
    assertDatabaseHas('products', [
        'name' => 'test',
        'description' => 'test',
        'price' => 100,
        'image' => $product->image,
    ]);

    $response->assertRedirect(route('products.show', $product));
});

test('can update product without image', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $this->actingAs($user);

    $response = $this->patch(route('products.update', $product), [
        'name' => 'test',
        'description' => 'test',
        'price' => 100,
    ]);

    assertDatabaseHas('products', [
        'name' => 'test',
        'description' => 'test',
        'price' => 100,
    ]);

    $response->assertRedirect(route('products.show', $product));
});

test('can not update product without name', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $this->actingAs($user);

    $response = $this->patch(route('products.update', $product), [
        'description' => 'test',
        'price' => 100,
    ]);

    $response->assertSessionHasErrors('name');
});

test('can not update a product with an invalid image type', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $this->actingAs($user);

    $response = $this->patch(route('products.update', $product), [
        'name' => 'test',
        'description' => 'test',
        'price' => 100,
        'image' => UploadedFile::fake()->create('photo1.pdf'),
    ]);

    $response->assertSessionHasErrors('image');
});

test('can not update product with invalid price', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $this->actingAs($user);

    $response = $this->patch(route('products.update', $product), [
        'name' => 'test',
        'description' => 'test',
        'price' => -100,
    ]);

    $response->assertSessionHasErrors('price');
});

test('can not update product if not authenticated', function () {
    $product = Product::factory()->create();

    $response = $this->patch(route('products.update', $product), [
        'name' => 'test',
        'description' => 'test',
        'price' => 100,
    ]);

    $response->assertRedirect(route('login'));
});

test('can delete product', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $this->actingAs($user);

    $response = $this->delete(route('products.destroy', $product));

    $response->assertRedirect(route('products.index'));

    $this->assertDatabaseMissing('products', [
        'id' => $product->id,
    ]);
});

test('can not delete product if not authenticated', function () {
    $product = Product::factory()->create();

    $response = $this->delete(route('products.destroy', $product));

    $response->assertRedirect(route('login'));
});
