<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChequeCategoriesController;
use App\Http\Controllers\ComputerChequesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LaserChequeController;
use App\Http\Controllers\ManualChequeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AboutusController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PersonalChequeController;
use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('partials.home');
})->name('dashboard');

Route::get('/success', function () {
    return view('layouts.success');
})->name('success');

// Route::get('/', function () {
//     return view('partials.home');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor-dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::get('/manual-cheque', [ManualChequeController::class, 'index'])->name('manual-cheque');

Route::get('/laser-cheque', [LaserChequeController::class, 'index'])->name('laser-cheque');

Route::get('/personal-cheque', [PersonalChequeController::class, 'index'])->name('personal-cheque');

Route::get('/cheque-list', [ChequeCategoriesController::class, 'index'])->name('cheque-list');

Route::get('order/{id}', [OrderController::class, 'index'])->name('order');

Route::get('/order-history', [OrderController::class, 'history'])->name('order.history');

Route::get('/customer-history', [VendorController::class, 'history'])->name('customer.history');

Route::post('order', [OrderController::class, 'store'])->name('order.store');

Route::get('/check-orders/{customerId}', [OrderController::class, 'checkOrders']);

Route::post('/reorder/{customerId}', [OrderController::class, 'reorder']);


Route::get('customer', [CustomerController::class, 'index'])->name('customer');

Route::post('customer', [CustomerController::class, 'store'])->name('customer.store');

Route::get('manual-cheque-list/{id}', [ManualChequeController::class, 'show'])->name('manual-cheque-list');
Route::get('laser-cheque-list/{id}', [LaserChequeController::class, 'show'])->name('laser-cheque-list');
Route::get('personal-cheque-list/{id}', [PersonalChequeController::class, 'show'])->name('personal-cheque-list');

Route::get('about-us', [AboutusController::class, 'index'])->name('about-us');

//admin section
Route::get('admin-login', [LoginController::class, 'index'])->name('admin-login');
Route::get('admin', [DashboardController::class, 'index'])->name('admin');

require __DIR__.'/auth.php';
