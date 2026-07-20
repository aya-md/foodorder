<?php

namespace App\Models;

use App\Models\Concerns\BelongsToBusiness;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[fillable(['item_id','business_id','name'])]
class OptionGroup extends Model
{
    use HasFactory,BelongsToBusiness;

    public function business():BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
    public function item():BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
    public function options():HasMany
    {
        return $this->hasMany(Option::class);
    }

}
