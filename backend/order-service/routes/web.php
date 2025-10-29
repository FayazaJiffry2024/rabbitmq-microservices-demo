<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController; // <-- add this line

Route::get('/', function () {
    return view('welcome');
});

// New route to create order
Route::post('/order', [OrderController::class, 'createOrder']);
