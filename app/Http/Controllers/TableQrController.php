<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TableQrController extends Controller
{
    public function index(): View
    {
        $business = Auth::user()->business;

        $tables = collect(range(1, $business->table_count))->map(function ($number) use ($business) {
            $url = route('menu.show', $business->slug).'?table='.$number;

            return [
                'number' => $number,
                'url' => $url,
                'qr_image' => 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='.urlencode($url),
            ];
        });

        return view('tables.index', compact('tables', 'business'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'table_count' => ['required', 'integer', 'min:1', 'max:200'],
        ]);

        Auth::user()->business->update([
            'table_count' => $request->table_count,
        ]);

        return redirect()->route('tables.index')->with('status', 'Table count updated.');
    }
}
