<?php

namespace App\Models;

use App\Models\Concerns\BelongsToBusiness;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['business_id', 'order_id', 'item_id', 'quantity', 'unit_price', 'chosen_options'])]
class OrderItem extends Model
{
    use BelongsToBusiness,HasFactory;

    protected function casts(): array
    {
        return [
            'chosen_options' => 'array',
            'price' => 'decimal,2',
        ];
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function item(): BelongsTo
    {
        return $this->BelongsTo(Item::class);
    }
}
