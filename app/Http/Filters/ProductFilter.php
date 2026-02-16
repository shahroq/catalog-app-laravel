<?php

namespace App\Http\Filters;

class ProductFilter extends QueryFilter
{
    protected $includables = ['reviews'];

    protected $sortables = ['id', 'created_at', 'in_stock'];

    public function include($value)
    {
        $validated = $this->validateIncludes($value);

        if (! empty($validated)) {
            $this->builder
                ->withCount($value)
                ->withAvg($value, 'rating')
                ->with($value);
        }

        return $this->builder;
    }

    public function in_stock($value)
    {
        return $this->builder->whereIn('in_stock', explode(',', $value));
    }

    public function title($value)
    {
        $likeStr = str_replace('*', '%', $value);

        return $this->builder->where('name', 'like', $likeStr);
    }
}
