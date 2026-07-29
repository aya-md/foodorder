<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class CartController extends Controller
{
  public function add(Request $request, Item $item):RedirectResponse
  {  $cart =session('cart',['business_id'=>null,'items'=>[]]);
     if($cart['business_id']!==$item->business_id){
        $cart = ['business_id'=>$item->business_id,'items'=>[]];
     }
     $quantity = $cart['items'][$item->id]['quantity']?? 0;
     $cart['items'][$item->id]=['quantity'=> $quantity + 1];
     session(['cart'=>$cart]);
     return back()->with('status',$item->name . ' added to cart.');
  }
  public function show(): View
{
    $cart = session('cart', ['business_id' => null, 'items' => []]);

    $items = collect();
    $total = 0;

    if ($cart['business_id']) {
        $itemIds = array_keys($cart['items']);
        $dbItems = Item::whereIn('id', $itemIds)->get()->keyBy('id');

        foreach ($cart['items'] as $itemId => $details) {
            if ($dbItems->has($itemId)) {
                $item = $dbItems[$itemId];
                $lineTotal = $item->price * $details['quantity'];
                $total += $lineTotal;

                $items->push([
                    'item' => $item,
                    'quantity' => $details['quantity'],
                    'line_total' => $lineTotal,
                ]);
            }
        }
    }

    $business = $cart['business_id'] ? \App\Models\Business::find($cart['business_id']) : null;

    return view('cart.show', compact('items', 'total', 'business'));
}
}
