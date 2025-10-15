<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// ROUTE ENDPOINT FOR PROFILE / CAT RESPONSE
Route::middleware('throttle:30,1')
    ->get('me', [ProfileController::class, 'myProfile'])
    ->name('profile');