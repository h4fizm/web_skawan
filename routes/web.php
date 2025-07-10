<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\ProductImagesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Models\ProductCategories;

Route::get('/', function () {
    return view('landing.index');
})->name('landing.index');

Route::get('/checkout', function () {
    return view('landing.checkout_product');
})->name('landing.checkout');

Route::get('/dashboard', function () {
    return view('landing.dashboard_user');
})->name('landing.dashboard');

Route::get('/design', function () {
    return view('landing.design_product');
})->name('landing.design');

Route::get('/design/{id}', function () {
    return view('landing.design');
})->name('landing.design.single');

Route::get('/detail', function () {
    return view('landing.detail_product');
})->name('landing.detail');

Route::get('/category', function () {
    return view('landing.list_category');
})->name('landing.category');

Route::get('/product', function () {
    return view('landing.list_product');
})->name('landing.product');

Route::get('/preview', function () {
    return view('landing.preview_product');
})->name('landing.preview');

Route::get('/profile', function () {
    return view('landing.user_profile');
})->name('landing.profile');

Route::middleware('auth')->group(function () {
    Route::get('/manage-users/{id}/verif', [UserController::class, 'verif'])->name('verif.user')->middleware('can:kelola-pengguna');
    // Roles and Permissions - Restricted to 'manage-account' permission
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionController::class);

    // Manage Users - Restricted to 'manage-account' permission
    Route::resource('manage-users', UserController::class);

    Route::resource('products', ProductsController::class);
    Route::resource('products-categories', ProductCategoriesController::class);
    Route::resource('products-images', ProductImagesController::class);
});

require __DIR__ . '/auth.php';
