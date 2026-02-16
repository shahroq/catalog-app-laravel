<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $includeProduct = $request->routeIs('reviews.*') && $this->relationLoaded('product');

        return [
            'id' => $this->id,
            'content' => $this->content,
            'rating' => $this->rating,
            'status' => $this->status,
            'product_id' => $this->product_id,
            'product' => $this->when($includeProduct, $this->product->toResource()),
        ];
    }
}
