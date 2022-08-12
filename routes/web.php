<?php

use App\Exports\BookingExport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UploadController;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Clas;
use App\Models\Licence;
use App\Mail\FitnessMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Rating;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $users =  User::all()->count();
    $categoury = Equipment::all()->count();
    $class = Clas::all()->count();
    $lice = Licence::all()->count();
    return view('admin.dashboard',compact('users','class','categoury','lice'));
})->middleware(['auth']);


Route::middleware('auth')->group(function () {

    //=================================user routes =====================================
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/add_users' , [AdminController::class, 'show_user_form'])->name('userform');
    Route::post('/add_users' , [AdminController::class, 'add_users'])->name('add_users');
    Route::get('/edit_user/{id}' , [AdminController::class, 'edit_user'])->name('edit_user');
    Route::post('/update_user/{id}' , [AdminController::class, 'update_user'])->name('update_user');
    Route::delete('/delete_user' , [AdminController::class, 'delete_user'])->name('delete_user');

    //=====================================licence Routes==========================================
    Route::get('/licence' , [AdminController::class, 'licence'])->name('licence');
    Route::post('/add_licence' , [AdminController::class, 'add_licence'])->name('add_licence');
    Route::get('/edit_licence/{id}' , [AdminController::class, 'edit_licence'])->name('edit_licence');
    Route::PUT('/licence_update' , [AdminController::class, 'licence_update'])->name('licence_update');
    Route::delete('/licence_delete' , [AdminController::class, 'licence_delete'])->name('licence_delete');

    //============================video upload controller=======================================
    Route::post('/upload', [UploadController::class, 'store'])->name('chunk.store');
    Route::get('/admin_logout', [AdminController::class, 'logout'])->name('admin_logout');

    //========================Equipments Routes =========================================
    Route::get('/equipments', [AdminController::class, 'eqp'])->name('equipments');
    Route::get('/add_equipments', [AdminController::class, 'add_eqp_show'])->name('show_add_equipments');
    Route::post('/add_equipments', [AdminController::class, 'add_eqp'])->name('add_equipments');
    Route::get('/edit_equipment/{id}' , [AdminController::class, 'edit_equipment'])->name('edit_equipment');
    Route::post('/edit_equipment/upload' ,[UploadController::class, 'store']);
    Route::post('/update_equipment/{id}' , [AdminController::class, 'update_equipment'])->name('update_equipment');
    Route::delete('/equipment_delete' , [AdminController::class, 'equipment_delete'])->name('equipment_delete');

    //=============================Classes Routes ==========================================
    Route::get('/classes', [AdminController::class, 'clas'])->name('classes');
    Route::get('/add_class', [AdminController::class, 'add_clas_show'])->name('show_add_class');
    Route::post('/add_class', [AdminController::class, 'add_clas'])->name('add_class');
    Route::get('/edit_class/{id}' , [AdminController::class, 'edit_class'])->name('edit_class');
    Route::post('/edit_class/upload' ,[UploadController::class, 'store']);
    Route::post('/update_class/{id}' , [AdminController::class, 'update_class'])->name('update_class');
    Route::delete('/class_delete' , [AdminController::class, 'class_delete'])->name('class_delete');

     //=============================Ratings And Reviews Routes ========================================
     Route::get('/ratings', [AdminController::class, 'ratings'])->name('ratings');
     Route::delete('/ratings_delete' , [AdminController::class, 'ratings_delete'])->name('ratings_delete');
     Route::get('/booking', [AdminController::class, 'booking'])->name('booking');
     Route::get('booking_export',[AdminController::class, 'get_booking_data'])->name('get_booking_data');
     Route::delete('/booking_delete' , [AdminController::class, 'booking_delete'])->name('booking_delete');

     //========================================= Splash Screen ============================================
     Route::get('splash_screen', [AdminController::class,'splashvideo'])->name('splash_screen');
     Route::post('splash_screen', [AdminController::class,'splashvideoadd'])->name('splash_screen_video');

      //========================================= QR Scan  ============================================
      Route::get('QR_show', [AdminController::class,'QR_show'])->name('QR_show');
      Route::post('QR', [AdminController::class,'QR'])->name('QR');

      //============================Class category========================================
      Route::get('category', [AdminController::class,'category'])->name('category');
      Route::post('add_category', [AdminController::class,'add_category'])->name('add_category');
      Route::get('edit_category/{id}' , [AdminController::class, 'edit_category'])->name('edit_category');
      Route::PUT('category_update' , [AdminController::class, 'category_update'])->name('category_update');
      Route::delete('/category_delete' , [AdminController::class, 'category_delete'])->name('category_delete');
;
});
//==================================Dashboard Route ==========================================
Route::get('/dashboard', function () {
    $users =  User::all()->count();
    $categoury = Equipment::all()->count();
    $class = Clas::all()->count();
    $lice = Licence::all()->count();
    return view('admin.dashboard',compact('users','class','categoury','lice'));
})->middleware(['auth'])->name('dashboard');


require __DIR__ . '/auth.php';
