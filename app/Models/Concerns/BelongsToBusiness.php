<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToBusiness
{
    protected static function bootBelongsToBusiness(): void
    {
        static::addGlobalScope('business', function (Builder $query) {
            if (auth()->check() && auth()->user()->business_id) {
                $query->where('business_id', auth()->user()->business_id);
            }
        });

        static::creating(function ($model) {
            if (auth()->check() && auth()->user()->business_id && ! $model->business_id) {
                $model->business_id = auth()->user()->business_id;
            }
        });
    }
}
