<?php

declare(strict_types=1);

namespace App\Actions\Products;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class UpdateProduct
{
    /**
     * Handle the action.
     *
     * @param  array<string, mixed>  $data
     */
    public function handle(Product $product, array $data): void
    {
        $product->update([
            'name' => $data['name'] ?? $product->name,
            'description' => $data['description'] ?? $product->description,
            'price' => $data['price'] ?? $product->price,
            'image' => $data['image'] ?? $product->image,
        ]);

        $product->refresh();
    }

    /**
     * Upload file to the given path.
     */
    public function uploadFile(Request $request, Product $product): string
    {
        Storage::disk('products')->delete($product->image);

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
