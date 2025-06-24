<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Products\CreateProduct;
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
        return inertia('Products/Index', []);
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

        $action->handle($request->validated());

        return to_route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): void
    {
        //
    }
}
