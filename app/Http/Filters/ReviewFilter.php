<?php

namespace App\Http\Filters;

class ReviewFilter extends QueryFilter
{
    protected $includables = ['product'];

    protected $sortables = ['id', 'created_at', 'status', 'rating'];

    public function include($value)
    {
        $validated = $this->validateIncludes($value);

        if (! empty($validated)) {
            $this->builder->with($value);
        }

        return $this->builder;
    }

    public function status($value)
    {
        return $this->builder->whereIn('status', explode(',', $value));
    }
}
