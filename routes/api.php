<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

//=============================== User Login Api==========================
Route::post('/login',  [ApiController::class, 'login']);

//============================Equipment Details Api=============================
Route::get('/eqp_details',  [ApiController::class, 'eqp_details']);

//============================Recomended Video Eqp Api=============================
Route::get('/recomended_video',  [ApiController::class, 'recomended_video']);

//============================Class Details Api=============================
Route::get('/class_details',  [ApiController::class, 'class_details']);

//============================Booking  Details Api=============================
Route::post('/booking_details',  [ApiController::class, 'booking_details']);

//============================Ratings Api=============================
Route::post('/ratings',  [ApiController::class, 'ratings']);