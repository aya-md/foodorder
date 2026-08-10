<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\OptionGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OptionGroupController extends Controller
{
    public function index(Item $item): View
    {
        $optionGroups = $item->optionGroups()->with('options')->get();

        return view('option-groups.index', compact('item', 'optionGroups'));
    }

    public function create(Item $item): View
    {
        return view('option-groups.create', compact('item'));
    }

    public function store(Request $request, Item $item): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $item->optionGroups()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('items.option-groups.index', $item)->with('status', 'Option group created.');
    }

    public function edit(OptionGroup $optionGroup): View
    {
        return view('option-groups.edit', compact('optionGroup'));
    }

    public function update(Request $request, OptionGroup $optionGroup): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $optionGroup->update([
            'name' => $request->name,
        ]);

        return redirect()->route('items.option-groups.index', $optionGroup->item)->with('status', 'Option group updated.');
    }

    public function destroy(OptionGroup $optionGroup): RedirectResponse
    {
        $item = $optionGroup->item;

        $optionGroup->delete();

        return redirect()->route('items.option-groups.index', $item)->with('status', 'Option group deleted.');
    }
}
