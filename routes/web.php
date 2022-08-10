<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('product/{product:slug}', [ProductController::class, 'index'])->name('product');
Route::get('category/{category:slug}', [CategoryController::class, 'show'])->name('category');
Route::get('sitemap.xml', 'SiteMapController@index')->name('sitemap.xml');
Route::get('thank/{order:id}', [OrderController::class, 'thank'])->name('thank');

Route::get('/search/{query}', 'SearchController@index')->name('search');

Route::post('order/create', 'OrderController@create')->name('order.create');
Route::post('feedback/create', 'FeedbackController@create')->name('feedback.create');