<?php

namespace App\Http\Controllers;

use App\Http\Filters\ProductFilter;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    protected string $model = Product::class;

    /**
     * Display a listing of the resource.
     */
    public function index(ProductFilter $filters)
    {

        $items = Product::filter($filters)->paginate($this->perPage());

        if ($items->isEmpty()) {
            throw new ModelNotFoundException('No Item found.');
        }

        $meta = $items instanceof LengthAwarePaginator ? $this->paginationMeta($items) : null;

        $data = [
            'products' => $items->toResourceCollection(),
            'meta' => $meta,
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product, ProductFilter $filters)
    {
        $item = Product::filter($filters)->findOrFail($product->id);
        $data = $item->toResource();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $newItem = $request->validated();
        $item = Product::create($newItem);
        $data = $item->toResource();

        return response()->json($data, HttpResponse::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $updatingItem = $request->validated();
        $product->update($updatingItem);
        $data = $product->refresh()->toResource();

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        $data = ['message' => 'Item deleted.'];

        return response()->json($data);
    }
}
