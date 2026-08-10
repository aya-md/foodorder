<?php

use App\Models\Business;
use App\Models\Category;
use App\Models\Item;
use App\Models\Order;

it('creates a real order with the correct total when a customer checks out', function () {
    $business = Business::factory()->create();
    $category = Category::factory()->for($business)->create();
    $item = Item::factory()->for($business)->for($category)->create(['price' => 25.00]);

    // Add 2x the item to the session cart, same structure the real CartController uses
    session([
        'cart' => [
            'business_id' => $business->id,
            'items' => [
                $item->id => ['quantity' => 2],
            ],
        ],
    ]);

    $response = $this->post(route('checkout.store'), [
        'customer_name' => 'Test Customer',
        'phone' => '0600000000',
        'type' => 'take_away',
    ]);

    $order = Order::first();

    expect($order)->not->toBeNull();
    expect((float) $order->total)->toBe(50.00);
    expect($order->business_id)->toBe($business->id);
    expect($order->customer_name)->toBe('Test Customer');
    expect($order->items()->first()->unit_price)->toEqual('25.00');

    $response->assertRedirect(route('orders.show', $order->tracking_uuid));
});

it('rejects checkout when the cart is empty', function () {
    $response = $this->post(route('checkout.store'), [
        'customer_name' => 'Test Customer',
        'type' => 'take_away',
    ]);

    expect(Order::count())->toBe(0);
    $response->assertRedirect(route('cart.show'));
});

it('requires a table number when the order type is dine-in', function () {
    $business = Business::factory()->create();
    $category = Category::factory()->for($business)->create();
    $item = Item::factory()->for($business)->for($category)->create();

    session([
        'cart' => [
            'business_id' => $business->id,
            'items' => [$item->id => ['quantity' => 1]],
        ],
    ]);

    $response = $this->post(route('checkout.store'), [
        'customer_name' => 'Test Customer',
        'type' => 'dine_in',
    ]);

    $response->assertSessionHasErrors('table_number');
    expect(Order::count())->toBe(0);
});
