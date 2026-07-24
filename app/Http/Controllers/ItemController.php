<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(): View
    {
        $items = Item::with('category')->orderBy('name')->get();

        return view('items.index', compact('items'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('position')->get();

        return view('items.create', compact('categories'));
    }


     public function store(Request $request): RedirectResponse
{
    $request->validate([
        'category_id' => ['required', 'exists:categories,id'],
        'name' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'price' => ['required', 'numeric', 'min:0'],
        'available' => ['boolean'],
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    ]);

    $imagePath = $request->hasFile('image')
        ? $request->file('image')->store('items', 'public')
        : null;

    Item::create([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'available' => $request->boolean('available'),
        'image' => $imagePath,
    ]);

    return redirect()->route('items.index')->with('status', 'Item created.');
}


    public function edit(Item $item): View
{
    $categories = Category::orderBy('position')->get();

    return view('items.edit', compact('item', 'categories'));
}

public function update(Request $request, Item $item): RedirectResponse
{
    $request->validate([
        'category_id' => ['required', 'exists:categories,id'],
        'name' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'price' => ['required', 'numeric', 'min:0'],
        'available' => ['boolean'],
        'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    ]);

    $imagePath = $item->image;

    if ($request->hasFile('image')) {
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $imagePath = $request->file('image')->store('items', 'public');
    }

    $item->update([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'available' => $request->boolean('available'),
        'image' => $imagePath,
    ]);

    return redirect()->route('items.index')->with('status', 'Item updated.');
}

public function destroy(Item $item): RedirectResponse
{
    $item->delete();

    return redirect()->route('items.index')->with('status', 'Item deleted.');
}
}
