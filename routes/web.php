<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing.index');
});

Route::get('/checkout', function () {
    return view('landing.checkout_product');
});

Route::get('/dashboard', function () {
    return view('landing.dashboard_user');
});

Route::get('/design', function () {
    return view('landing.design_product');
});

Route::get('/design/{id}', function ($id) {
    return view('landing.design', ['id' => $id]);
});

Route::get('/detail/{id}', function ($id) {
    return view('landing.detail_product', ['id' => $id]);
});

Route::get('/category/{category}', function ($category) {
    return view('landing.list_category', ['category' => $category]);
});

Route::get('/product/{product}', function ($product) {
    return view('landing.list_product', ['product' => $product]);
});

Route::get('/preview/{product}', function ($product) {
    return view('landing.preview_product', ['product' => $product]);
});

Route::get('/profile', function () {
    return view('landing.user_profile');
});
