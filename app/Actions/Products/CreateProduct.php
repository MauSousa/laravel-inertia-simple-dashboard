<?php

declare(strict_types=1);

namespace App\Actions\Products;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class CreateProduct
{
    /**
     * Handle the action.
     *
     * @param  array<string, mixed>  $data
     */
    public function handle(array $data): Product
    {
        return Product::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'image' => $data['image'] ?? null,
        ]);
    }

    /**
     * Upload file to the given path.
     */
    public function uploadFile(Request $request, string $path): string
    {
        $upload = $request->file('image');
        $filename = Str::uuid() . '.' . $upload->extension();
        $image = Image::read($upload)
            ->resize(300, 200);

        Storage::disk('products')->put(
            $filename,
            $image->encodeByExtension($upload->extension()) // @phpstan-ignore-line
        );

        return $filename;
    }
}
