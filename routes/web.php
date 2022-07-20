<?php

use App\Http\Controllers\ProductController;

Route::get('category', 'RedirectController@category');
Route::get('product', 'RedirectController@product');
Route::get('f/{id}', 'RedirectController@feedback');
Route::redirect('search', '/');
Route::get('/', 'IndexController@index')->name('home');
Route::get('product/{product:slug}', [ProductController::class, 'index'])->name('product');
Route::get('category/{slug}', 'CategoryController@show')->name('category');
Route::get('sitemap.xml', 'SiteMapController@index')->name('sitemap.xml');

Route::get('/search/{query}', 'SearchController@index')->name('search');

Route::post('order/create', 'OrderController@create')->name('order.create');
Route::post('feedback/create', 'FeedbackController@create')->name('feedback.create');