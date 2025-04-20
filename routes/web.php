<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ConcessionController;

Route::get('/', function () {
    return view('welcome');
});

// Concession Routes
Route::resource('concessions', ConcessionController::class);

// Order Routes
Route::resource('orders', OrderController::class)->except(['edit', 'update']);

Route::post('/orders/{order}/send-to-kitchen', [OrderController::class, 'sendToKitchen'])->name('orders.send-to-kitchen');
Route::post('/orders/{order}/complete', [OrderController::class, 'completeOrder'])->name('orders.complete');

// Kitchen Routes
Route::get('/kitchen', [OrderController::class, 'kitchen'])->name('kitchen.index');


