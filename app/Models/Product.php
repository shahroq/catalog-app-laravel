<?php

namespace App\Models;

use App\Concerns\Auditable;
use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use Auditable;

    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    public const MAX_PER_PAGE = 20;

    protected $perPage = 5;

    protected $fillable = ['name', 'description', 'price', 'category', 'in_stock'];

    // protected $hidden = ['created_at', 'created_by', 'updated_at', 'updated_by'];

    protected $casts = [
        'in_stock' => 'boolean',
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
