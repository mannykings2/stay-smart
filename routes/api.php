<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Paystack endpoints (public)
use App\Http\Controllers\PagesController;

// Initialize endpoint removed (use PagesController::payNow for web flow).
Route::get('/paystack/callback', [PagesController::class, 'verifyPayment'])->name('paystack.callback');
Route::post('/paystack/callback', [PagesController::class, 'verifyPayment']);
