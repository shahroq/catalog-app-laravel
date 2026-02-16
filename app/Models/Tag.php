<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    public const MAX_PER_PAGE = 20;

    protected $perPage = 10;

    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];
}
