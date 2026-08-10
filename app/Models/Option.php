<?php

namespace App\Models;

use App\Models\Concerns\BelongsToBusiness;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['business_id', 'option_group_id', 'label', 'extra_price'])]
class Option extends Model
{
    use BelongsToBusiness,HasFactory;

    protected function casts(): array
    {
        return [
            'extra_price' => 'decimal:2',
        ];
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function OptionGroup(): BelongsTo
    {
        return $this->belongsTo(OptionGroup::class);
    }
}
