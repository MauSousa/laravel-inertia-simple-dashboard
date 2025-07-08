<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Products\CreateProduct;
use App\Actions\Products\UpdateProduct;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $products = Product::orderBy('created_at', 'desc')
            ->get()
            ->map(fn ($product): array => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'image' => $product->image ? '/storage/products/' . $product->image : '/storage/products/product_placeholder.png',
            ]);

        return inertia('Products/Index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return inertia('Products/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, CreateProduct $action): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $action->uploadFile($request, '/');
        }

        $action->handle($validated);

        return to_route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): Response
    {
        return inertia('Products/Show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): Response
    {
        return inertia('Products/Edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product, UpdateProduct $action): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $action->uploadFile($request);
        }

        $action->handle($product, $validated);

        return to_route('products.edit', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): void
    {
        //
    }
}
