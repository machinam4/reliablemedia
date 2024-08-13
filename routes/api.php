<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\MPESAResponseController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/c2b/confirmation', [MPESAResponseController::class, 'confirmation']);
Route::post('/c2b/validation', [MPESAResponseController::class, 'validation']);

// sms responses
Route::get('/sms/sms_stats', [SMSController::class, 'smsStats']);