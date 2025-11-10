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
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\QuantityTierController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::get('/category/{categorySlug}', [HomeController::class, 'show'])->name('category.show');

Route::get('/make-order/{id}', [HomeController::class, 'makeOrder'])->name('make-order');

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

    // Colors
    Route::get('/admin/colors', [DashboardController::class, 'colorsIndex'])->name('admin.colors');
    Route::post('/admin/colors/store', [DashboardController::class, 'colorsStore'])->name('admin.colorsStore');
    Route::get('admin/colors/{id}/edit', [DashboardController::class, 'colorsEdit'])->name('admin.colors.edit');
    Route::put('admin/colors/{id}', [DashboardController::class, 'colorsUpdate'])->name('admin.colors.update');
    Route::delete('admin/colors/{id}', [DashboardController::class, 'colorsDestroy'])->name('admin.colors.destroy');

    // Categories
    Route::get('/admin/categories', [DashboardController::class, 'categoriesIndex'])->name('admin.categories');
    Route::post('/admin/categories/store', [DashboardController::class, 'categoriesStore'])->name('admin.categoriesStore');
    Route::get('admin/categories/{id}/edit', [DashboardController::class, 'categoriesEdit'])->name('admin.categories.edit');
    Route::put('admin/categories/{id}', [DashboardController::class, 'categoriesUpdate'])->name('admin.categories.update');
    Route::delete('admin/categories/{id}', [DashboardController::class, 'categoriesDestroy'])->name('admin.categories.destroy');

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

    // New Categories Management Routes
    Route::resource('admin/categories', CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
    Route::get('admin/categories/{category}/manage-subcategories', [CategoryController::class, 'manageSubcategories'])->name('admin.categories.manage-subcategories');
    Route::post('admin/categories/{category}/assign-subcategory', [CategoryController::class, 'assignSubcategory'])->name('admin.categories.assign-subcategory');
    Route::delete('admin/categories/{category}/subcategories/{subcategory}', [CategoryController::class, 'removeSubcategory'])->name('admin.categories.remove-subcategory');
    Route::post('admin/categories/{category}/update-subcategory-order', [CategoryController::class, 'updateSubcategoryOrder'])->name('admin.categories.update-subcategory-order');

    // Subcategories Management Routes
    Route::resource('admin/subcategories', SubcategoryController::class)->names([
        'index' => 'admin.subcategories.index',
        'create' => 'admin.subcategories.create',
        'store' => 'admin.subcategories.store',
        'edit' => 'admin.subcategories.edit',
        'update' => 'admin.subcategories.update',
        'destroy' => 'admin.subcategories.destroy',
    ]);

    // Quantity Tiers Management Routes
    Route::resource('admin/quantity-tiers', QuantityTierController::class)->names([
        'index' => 'admin.quantity-tiers.index',
        'create' => 'admin.quantity-tiers.create',
        'store' => 'admin.quantity-tiers.store',
        'edit' => 'admin.quantity-tiers.edit',
        'update' => 'admin.quantity-tiers.update',
        'destroy' => 'admin.quantity-tiers.destroy',
    ]);
    Route::post('admin/quantity-tiers/update-order', [QuantityTierController::class, 'updateOrder'])->name('admin.quantity-tiers.update-order');

    // Pricing Management Routes
    Route::get('admin/pricing', [PricingController::class, 'index'])->name('admin.pricing.index');
    Route::get('admin/pricing/subcategory/{subcategory}', [PricingController::class, 'manageSubcategory'])->name('admin.pricing.manage-subcategory');
    Route::post('admin/pricing/subcategory/{subcategory}', [PricingController::class, 'updateSubcategoryPricing'])->name('admin.pricing.update-subcategory');
    Route::get('admin/pricing/bulk-manage', [PricingController::class, 'bulkManage'])->name('admin.pricing.bulk-manage');
    Route::post('admin/pricing/bulk-update', [PricingController::class, 'bulkUpdate'])->name('admin.pricing.bulk-update');
    Route::delete('admin/pricing/{pricing}', [PricingController::class, 'destroy'])->name('admin.pricing.destroy');

});

Route::get('/manual-cheque', [ManualChequeController::class, 'index'])->name('manual-cheque');

Route::get('/laser-cheque', [LaserChequeController::class, 'index'])->name('laser-cheque');

Route::get('/personal-cheque', [PersonalChequeController::class, 'index'])->name('personal-cheque');

Route::get('/cheque-list', [ChequeCategoriesController::class, 'index'])->name('cheque-list');

Route::get('order/{id}', [OrderController::class, 'index'])->name('order');

Route::get('/order-history', [OrderController::class, 'history'])->name('order.history');

Route::get('/customer-history', [VendorController::class, 'history'])->name('customer.history');

Route::post('order', [OrderController::class, 'store'])->name('order.store');

Route::get('/check-orders/{customerId}/{categoryId}', [OrderController::class, 'checkOrders']);

// Route::post('/reorder/{customer}', [OrderController::class, 'reorder'])->name('reorder');
Route::post('/order/reorder', [OrderController::class, 'reorder'])->name('order.reorder');



Route::get('customer', [CustomerController::class, 'index'])->name('customer');

Route::post('customer', [CustomerController::class, 'store'])->name('customer.store');

Route::get('manual-cheque-list/{id}', [ManualChequeController::class, 'show'])->name('manual-cheque-list');
Route::get('laser-cheque-list/{id}', [LaserChequeController::class, 'show'])->name('laser-cheque-list');
Route::get('personal-cheque-list/{id}', [PersonalChequeController::class, 'show'])->name('personal-cheque-list');

Route::get('about-us', [AboutusController::class, 'index'])->name('about-us');

Route::resource('customer', CustomerController::class)->middleware('auth');


require __DIR__.'/auth.php';
