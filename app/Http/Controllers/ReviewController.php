<?php

namespace App\Http\Controllers;

use App\Http\Filters\ReviewFilter;
use App\Http\Requests\Reviews\StoreReviewRequest;
use App\Http\Requests\Reviews\UpdateReviewRequest;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ReviewController extends Controller
{
    protected string $model = Review::class;

    /**
     * Display a listing of the resource.
     */
    public function index(ReviewFilter $filters)
    {
        $items = Review::filter($filters)->paginate($this->perPage());

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
    public function show(Review $review, ReviewFilter $filters)
    {
        $item = Review::filter($filters)->findOrFail($review->id);

        $data = $item->toResource();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        // check product_id
        $product = Product::find($request->input('product_id'));
        if (! $product) {
            throw new ModelNotFoundException('Product not found.');
        }

        $newItem = $request->validated();
        $newItem += ['status' => 'PENDING'];

        $item = Review::create($newItem);
        $data = $item->toResource();

        return response()->json($data, HttpResponse::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $updatingItem = $request->validated();

        $review->update($updatingItem);
        $data = $review->refresh()->toResource();

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        $data = ['message' => 'Item deleted.'];

        return response()->json($data);
    }
}
