<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActionLog;
use App\Models\Business;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BusinessApprovalController extends Controller
{
    public function index(): View
    {
        $businesses = Business::latest()->get();

        return view('admin.businesses.index', compact('businesses'));
    }

    public function approve(Request $request, Business $business): RedirectResponse
    {
        $business->update(['status' => 'approved']);

        AdminActionLog::create([
            'admin_id' => $request->user()->id,
            'business_id' => $business->id,
            'action' => 'approved',
        ]);

        return back()->with('status', "{$business->name} has been approved.");
    }

    public function suspend(Request $request, Business $business): RedirectResponse
    {
        $request->validate(['reason' => ['nullable', 'string', 'max:500']]);

        $business->update(['status' => 'suspended']);

        AdminActionLog::create([
            'admin_id' => $request->user()->id,
            'business_id' => $business->id,
            'action' => 'suspended',
            'reason' => $request->reason,
        ]);

        return back()->with('status', "{$business->name} has been suspended.");
    }
}
