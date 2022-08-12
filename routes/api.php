<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Mail\FitnessMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Rating;

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

//========================================= Splash Screen Api============================================
Route::get('splash_screen', [ApiController::class,'splashvideo']);

//============================QR scan Image Api=============================
Route::get('/qr_image',  [ApiController::class, 'qr_image']);

//============================Category Api==================================
Route::get('/category',  [ApiController::class, 'category']);

//============================classes Details by Category==================================
Route::get('/category_classes',  [ApiController::class, 'category_classes']);


//======================== Send Email Route ===============================
Route::get('send-mail', function () {

    $ratings = Rating::join('clas','ratings.class_id', '=', 'clas.id')->join('users', 'ratings.user_id', '=', 'users.id')->select('users.name', 'clas.clas_name' ,'ratings.class_review','ratings.difficulty_rating','ratings.instructor_rating','ratings.id')->get();
    
   
    $details = [
        'title' => 'User Ratings By Fitness App',
        'body' => 'This is for testing email using smtp'
    ];
   
    Mail::to('mussabahmad1@gmail.com')->send(new \App\Mail\FitnessMail($details));

    return view('admin.ratings', compact('ratings'));
    dd("Email is Sent.");
});