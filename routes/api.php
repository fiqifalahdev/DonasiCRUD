<?php

use App\Http\Controllers\RaiseFundController;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('guest')->group(function () {

    // Route untuk galang dana
    Route::get('raise', [RaiseFundController::class, 'getALlRaiseFund']);
    Route::post('raise', [RaiseFundController::class, 'createRaiseFund']);
    Route::put('raise/edit/{raiseFund}', [RaiseFundController::class, 'updateRaiseFund']);
    Route::get('raise/show/{raiseFund}', [RaiseFundController::class, 'showRaiseFund']);
    Route::delete('raise/delete/{raiseFund}', [RaiseFundController::class, 'deleteRaiseFund']);

    // Route untuk donasi
    Route::get('donate', [DonationController::class, 'getAllDonation']);
    Route::post('donate', [DonationController::class, 'donate']);
});
