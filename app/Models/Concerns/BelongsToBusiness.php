<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin Model
 *
 * @method static void addGlobalScope(string $identifier, \Illuminate\Database\Eloquent\Scope|callable $scope)
 * @method static void creating(\Closure $callback)
 */
trait BelongsToBusiness
{
    protected static function bootBelongsToBusiness(): void
    {
        static::addGlobalScope('business', function (Builder $query): void {
            if (Auth::check() && Auth::user()?->business_id) {
                $query->where('business_id', Auth::user()->business_id);
            }
        });

        static::creating(function ($model): void {
            if (Auth::check() && Auth::user()?->business_id && ! $model->business_id) {
                $model->business_id = Auth::user()->business_id;
            }
        });
    }
}
