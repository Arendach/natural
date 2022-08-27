<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('product/{product:slug}', [ProductController::class, 'index'])->name('product');
Route::get('category/{category:slug}', [CategoryController::class, 'index'])->name('category');
Route::get('sitemap.xml', 'SiteMapController@index')->name('sitemap.xml');
Route::get('thank-order/{order:id}', [OrderController::class, 'thank'])->name('thank.order');
Route::get('thank-feedback/{feedback:id}', [FeedbackController::class, 'thank'])->name('thank.feedback');

Route::get('/search/{query}', 'SearchController@index')->name('search');

Route::post('order/create', [OrderController::class, 'create'])->name('order.create');
Route::post('feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');