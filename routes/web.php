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
   
});

Route::middleware(['auth'])->group(function () {
    Route::get('admin', [DashboardController::class, 'index'])->name('admin');

    //admin section
    Route::get('admin-login', [LoginController::class, 'index'])->name('admin-login');
    Route::get('/admin/profile', [DashboardController::class, 'accountDetails'])->name('admin.profile');

    //user
    Route::post('/admin/user/store', [DashboardController::class, 'userStore'])->name('adminUser.userStore');
    Route::get('admin/users/{id}/edit', [DashboardController::class, 'userEdit'])->name('admin.users.edit');
    Route::put('admin/users/{id}', [DashboardController::class, 'userUpdate'])->name('admin.users.update');
    Route::delete('admin/users/{id}', [DashboardController::class, 'userDestroy'])->name('admin.users.destroy');

    // Order Routes
    Route::post('/admin/orders/store', [DashboardController::class, 'orderStore'])->name('admin.orderStore');
    Route::get('admin/orders/{id}/edit', [DashboardController::class, 'orderEdit'])->name('admin.orders.edit');
    Route::put('admin/orders/{id}', [DashboardController::class, 'orderUpdate'])->name('admin.orders.update');
    Route::delete('admin/orders/{id}', [DashboardController::class, 'orderDestroy'])->name('admin.orders.destroy');

    // Customer
    Route::get('/admin/customer', [DashboardController::class, 'customerIndex'])->name('admin.customer');
    Route::get('/admin/orders', [DashboardController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/users', [DashboardController::class, 'users'])->name('admin.users');
    Route::post('/admin/customer/store', [DashboardController::class, 'customerStore'])->name('admin.customerStore');
    Route::get('admin/customer/{id}/edit', [DashboardController::class, 'customerEdit'])->name('admin.customer.edit');
    Route::put('admin/customer/{id}', [DashboardController::class, 'customerUpdate'])->name('admin.customer.update');
    Route::delete('admin/customer/{id}', [DashboardController::class, 'customerDestroy'])->name('admin.customer.destroy');


    // cheque_categories
    Route::get('/admin/cheque_categories', [DashboardController::class, 'chequeCategoriesIndex'])->name('admin.cheque_categories');
    Route::post('/admin/cheque_categories/store', [DashboardController::class, 'chequeCategoriesStore'])->name('admin.chequeCategoriesStore');
    Route::get('admin/cheque_categories/{id}/edit', [DashboardController::class, 'chequeCategoriesEdit'])->name('admin.cheque_categories.edit');
    Route::put('admin/cheque_categories/{id}', [DashboardController::class, 'chequeCategoriesUpdate'])->name('admin.cheque_categories.update');
    Route::delete('admin/cheque_categories/{id}', [DashboardController::class, 'chequeCategoriesDestroy'])->name('admin.cheque_categories.destroy');

    Route::get('admin/manualcheques', [AdminController::class, 'manual_cheques'])->name('admin-manual_cheques');
    Route::get('admin/lasercheques', [AdminController::class, 'laser_cheques'])->name('admin-laser_cheques');
    Route::get('admin/personalcheques', [AdminController::class, 'personal_cheques'])->name('admin-personal_cheques');

    Route::get('admin/manual_cheques_form', [AdminController::class, 'add_manual_cheques_form']);
    Route::get('admin/laser_cheques_form', [AdminController::class, 'add_laser_cheques_form']);
    Route::get('admin/personal_cheques_form', [AdminController::class, 'add_personal_cheques_form']);

    Route::post('/admin/store-manual-cheque', [ManualChequeController::class, 'store'])->name('store.manual.cheque');
    Route::get('/admin/edit-manual-cheque/{id}', [ManualChequeController::class, 'edit'])->name('edit.manual.cheque');
    Route::post('/admin/update-manual-cheque/{id}', [ManualChequeController::class, 'update'])->name('update.manual.cheque');
    Route::delete('/admin/delete-manual-cheque/{id}', [ManualChequeController::class, 'destroy'])->name('delete.manual.cheque');


    Route::post('/admin/store-laser-cheque', [LaserChequeController::class, 'store'])->name('store.laser.cheque');
    Route::get('/admin/edit-laser-cheque/{id}', [LaserChequeController::class, 'edit'])->name('edit.laser.cheque');
    Route::post('/admin/update-laser-cheque/{id}', [LaserChequeController::class, 'update'])->name('update.laser.cheque');
    Route::delete('/admin/delete-laser-cheque/{id}', [LaserChequeController::class, 'destroy'])->name('delete.laser.cheque');


    Route::post('/admin/store-personal-cheque', [PersonalChequeController::class, 'store'])->name('store.personal.cheque');
    Route::get('/admin/edit-personal-cheque/{id}', [PersonalChequeController::class, 'edit'])->name('edit.personal.cheque');
    Route::post('/admin/update-personal-cheque/{id}', [PersonalChequeController::class, 'update'])->name('update.personal.cheque');
    Route::delete('/admin/delete-personal-cheque/{id}', [PersonalChequeController::class, 'destroy'])->name('delete.personal.cheque');


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

Route::resource('customer', CustomerController::class)->middleware('auth');


require __DIR__.'/auth.php';
