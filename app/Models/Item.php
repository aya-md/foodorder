<?php

namespace App\Models;

use App\Models\Concerns\BelongsToBusiness;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['business_id', 'category_id', 'name', 'price', 'description', 'image', 'available'])]
class Item extends Model
{
    use HasFactory,BelongsToBusiness,SoftDeletes;

    protected function casts():array
    {
        return [
            'available' => 'boolean',
            'price' => 'decimal:2',
        ];
    }

    public function business():BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function optionGroups():hasMany
    {
        return $this->hasMany(OptionGroup::class);
    }
}
