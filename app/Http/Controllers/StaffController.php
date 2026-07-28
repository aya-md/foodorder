<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


class StaffController extends Controller
{
    public function index(): View
{
    $staff = User::where('role', 'staff')
        ->where('business_id', auth('web')->user()->business_id)
        ->get();

    return view('staff.index', compact('staff'));
}

    public function create():View{
    return view('staff.create');
    }

    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

        User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'staff',
            'business_id' => auth('web')->user()->business_id,
    ]);

    return redirect()->route('staff.index')->with('status', 'Staff account created.');
}
    public function destroy(User $staff){
        $staff->delete();
        return redirect()->route('staff.index')->with('status','Staff account removed');
    }
}
