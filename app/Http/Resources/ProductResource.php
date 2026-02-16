<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $includeReviews = $request->routeIs('products.*') && $this->relationLoaded('reviews');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'in_stock' => (bool) $this->in_stock,
            'category' => array_map('trim', explode(' ', $this->category)),
            // 'tags' => $this->tags->toResourceCollection(),
            'tags' => $this->tags->pluck('name'),
            // 'reviews' => $this->when($includeReviews, $this->reviews->toResourceCollection()),
            // 'reviewsCount' => $this->when($includeReviews, count($this->reviews)),
            $this->mergeWhen($includeReviews, [
                'reviews' => $this->reviews->toResourceCollection(),
                'review_count' => $this->reviews_count ?? $this->reviews->count(),
                'average_rating' => isset($this->reviews_avg_rating)
                    ? round($this->reviews_avg_rating, 2)
                    : $this->reviews->avg('rating'),
            ]),
        ];
    }
}
