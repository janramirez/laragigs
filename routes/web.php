<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//show all listings
Route::get('/', [ListingController::class, 'index']);

// create listings
Route::get('/listings/create', [ListingController::class, 'create']);

// store listing data
Route::post('/listings', [ListingController::class, 'store']);

// show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit']);

// update listing
Route::put('/listings/{listing}', [ListingController::class, 'update']);

// delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy']);

// show single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// show register/create form
Route::get('/register', [UserController::class, 'create']);
