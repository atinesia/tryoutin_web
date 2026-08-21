<?php

use App\Http\Controllers\OrderController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Webhook Callback Tripay (Public)
Route::post('/api/tripay-webhook', [OrderController::class, 'webhook']);
