<?php

use Illuminate\Support\Facades\Route;

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

