<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'business_id' => Business::factory(),
            'customer_name' => $this->faker->name(),
            'type' => 'take_away',
            'status' => 'pending',
            'total' => 25.00,
            'tracking_uuid' => Str::uuid(),
        ];
    }
}
