<?php

use App\Models\Business;
use App\Models\Order;
use App\Models\User;

it('only shows orders belonging to the logged-in owner\'s own business', function () {
    $businessA = Business::factory()->create();
    $businessB = Business::factory()->create();

    $ownerA = User::factory()->create(['role' => 'owner', 'business_id' => $businessA->id]);

    $orderA = Order::factory()->for($businessA)->create(['status' => 'pending']);
    $orderB = Order::factory()->for($businessB)->create(['status' => 'pending']);

    $response = $this->actingAs($ownerA)->get(route('orders.index'));

    $response->assertSee('#'.$orderA->id);
    $response->assertDontSee('#'.$orderB->id);
});

it('prevents an owner from changing another business\'s order status', function () {
    $businessA = Business::factory()->create();
    $businessB = Business::factory()->create();

    $ownerA = User::factory()->create(['role' => 'owner', 'business_id' => $businessA->id]);
    $orderB = Order::factory()->for($businessB)->create(['status' => 'pending']);

    $response = $this->actingAs($ownerA)->patch(route('orders.preparing', $orderB));

    $response->assertStatus(404);
    expect($orderB->fresh()->status)->toBe('pending');
});
