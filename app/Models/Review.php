<?php

namespace App\Models;

use App\Concerns\Auditable;
use App\Enums\ReviewStatus;
use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use Auditable;

    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    public const MAX_PER_PAGE = 20;

    protected $perPage = 5;

    protected $fillable = ['product_id', 'content', 'rating', 'status'];

    // protected $hidden = ['created_at', 'created_by', 'updated_at', 'updated_by', ];

    protected $casts = [
        'status' => ReviewStatus::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
