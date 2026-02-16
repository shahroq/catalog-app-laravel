<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TagController extends Controller
{
    protected string $model = Tag::class;

    /**
     * Display a listing of the resource.
     */
    public function index($productId = null)
    {
        $items = $productId
            // ? Product::findOrFail($productId)->load('tags')->tags
            ? Product::findOrFail($productId)->tags
            : Tag::paginate($this->perPage());

        if ($items->isEmpty()) {
            throw new ModelNotFoundException('No Item found.');
        }

        $meta = $items instanceof LengthAwarePaginator ? $this->paginationMeta($items) : null;

        $data = [
            'reviews' => $items->toResourceCollection(),
            'meta' => $meta,
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $item = $tag;

        $data = $item->toResource();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
