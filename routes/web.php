<?php

use App\Http\Controllers\Admin\BusinessApprovalController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OptionGroupController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;


Route::get('/', function () {return view('welcome');});
Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('menu.show');
Route::post('/cart/add/{item}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.create');
Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
Route::get('/order/{trackingUuid}', function ($trackingUuid) {
    return "Order placeholder for: " . $trackingUuid;
})->name('orders.show');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'owner'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('items', ItemController::class);
    Route::resource('items.option-groups', OptionGroupController::class)->shallow();
    Route::resource('option-groups.options', OptionController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->shallow();
    Route::resource('staff', StaffController::class)
    ->parameters(['staff' => 'staff'])
    ->only(['index', 'create', 'store', 'destroy']);
});

Route::middleware(['auth', 'super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/businesses', [BusinessApprovalController::class, 'index'])->name('businesses.index');
    Route::patch('/businesses/{business}/approve', [BusinessApprovalController::class, 'approve'])->name('businesses.approve');
    Route::patch('/businesses/{business}/suspend', [BusinessApprovalController::class, 'suspend'])->name('businesses.suspend');
});

require __DIR__.'/auth.php';
