<?php

namespace App\Concerns;

use Illuminate\Support\Facades\Auth;

trait Auditable
{
    protected static function bootAuditable()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id() ?? 1;
            $model->updated_by = Auth::id() ?? 1;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id() ?? 1;
        });
    }
}
