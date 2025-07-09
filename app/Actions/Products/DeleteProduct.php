<?php

declare(strict_types=1);

namespace App\Actions\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class DeleteProduct
{
    public function handle(Product $product): void
    {
        if ($product->image) {
            Storage::disk('products')->delete($product->image);
        }

        $product->delete();
    }
}
