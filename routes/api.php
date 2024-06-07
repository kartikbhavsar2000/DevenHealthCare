<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [App\Http\Controllers\ApiController::class, 'login']);
Route::post('/get_booking_details', [App\Http\Controllers\ApiController::class, 'get_booking_details']);
Route::post('/mark_attendance', [App\Http\Controllers\ApiController::class, 'mark_attendance']);