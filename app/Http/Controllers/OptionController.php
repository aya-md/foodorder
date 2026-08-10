<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\OptionGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OptionController extends Controller
{
    public function create(OptionGroup $optionGroup): View
    {
        return view('options.create', compact('optionGroup'));
    }

    public function store(Request $request, OptionGroup $optionGroup): RedirectResponse
    {
        $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'extra_price' => ['required', 'numeric', 'min:0'],
        ]);
        $optionGroup->options()->create([
            'label' => $request->label,
            'extra_price' => $request->extra_price,
        ]);
        $item = $optionGroup->item;

        return redirect()->route('items.option-groups.index', $item)->with('status', 'Option added.');
    }

    public function edit(Option $option): View
    {
        return view('options.edit', compact('option'));
    }

    public function update(Request $request, Option $option): RedirectResponse
    {
        $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'extra_price' => ['required', 'numeric', 'min:0'],
        ]);
        $option->update([
            'label' => $request->label,
            'extra_price' => $request->extra_price,
        ]);
        $item = $option->optionGroup->item;

        return redirect()->route('items.option-groups.index', $item)->with('status', 'Option updated.');
    }

    public function destroy(Option $option): RedirectResponse
    {
        $item = $option->optionGroup->item;
        $option->delete();

        return redirect()->route('items.option-groups.index', $item)->with('status', 'Option deleted.');
    }
}
